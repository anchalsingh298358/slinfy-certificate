<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Validator;
use Session;
use Redirect;
use Hash;
use Spatie\Permission\Models\Role;
use DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{    
    function __construct()
    {
        $this->middleware('permission:view_users|add_users|edit_users|delete_users', ['only' => ['index','show']]);
        $this->middleware('permission:add_users', ['only' => ['create','store']]);
        $this->middleware('permission:edit_users', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_users', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->get();
        return view('admin.user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('admin.user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required'],
            'password' => ['required'],
            'confirm-password' => ['required','same:password'],
            'email' => ['required', 'string', 'email', 'max:255','unique:users,email,NULL,id,deleted_at,NULL'],
            'roles' => 'required|min:1'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->with('error', 'Insufficient data to update.');
        }

        // hash password
        $password = Hash::make($request['password']);

        $role_id = Role::firstOrCreate(['name' => trim($request->roles)]);
       
        $users = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
            'role_id' => $role_id->id,
            'role_type' => $request->roles
        ];
        

        // Create the user
        if ( $user = User::create($users) ) {

            $this->syncPermissions($request, $user);

            return redirect()->route('admin.users.index')->with('success', $request->name . ' User has been created.');

        } else {
            return redirect()->route('admin.users.index')->with('error', 'Unable to create user');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::find($id);
        return view('admin.user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('admin.user.create',compact('user','roles','userRole'));
        // return view('admin.user.admin_account');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);

        // $this->validate($request, [
        //     'name' => 'bail|required|min:2',
        //     'email' => 'required|email|unique:users,email,' . $id,
        //     'roles' => 'required|min:1'
        // ]);

        // Get the user

        $user = User::findOrFail($id);

        // Update user
        $user->fill($request->except('roles', 'permissions', 'password'));
        
        // check for password change
        if($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        // Handle the user roles
        $this->syncPermissions($request, $user);

        $user->save();

        $role = Role::firstOrCreate(['name' => trim($request->roles)]);

        $update_role_type = User::where('id', $id)->update(['role_id' => $role->id, 'role_type' => $role->name]);

        return redirect()->route('admin.users.index')->with('success', ' User has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( Auth::user()->id == $id ) {
            flash()->warning('Deletion of currently logged in user is not allowed :(')->important();
            return redirect()->back();
        }

        if( User::findOrFail($id)->delete() ) {
            flash()->success('User has been deleted');
        } else {
            flash()->success('User not deleted');
        }

        return redirect()->back();
    }

    private function syncPermissions(Request $request, $user)
    {
        // Get the submitted roles
        $roles = $request->get('roles', []);
        $permissions = $request->get('permissions', []);

        // Get the roles
        $roles = Role::firstOrCreate(['name' => trim($roles)]);
      
        // check for current role changes
        if( ! $user->hasAllRoles( $roles ) ) {
            // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);

        return $user;
    }
}
