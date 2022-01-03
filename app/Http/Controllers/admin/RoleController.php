<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Authorizable;
use App\Permission;
use App\Role;
use Validator;
use Illuminate\Http\Request;
use DB;
use Auth;

class RoleController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:view_roles|add_roles|edit_roles|delete_roles', ['only' => ['index','show']]);
         $this->middleware('permission:add_roles', ['only' => ['create','store']]);
         $this->middleware('permission:edit_roles', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_roles', ['only' => ['destroy']]);
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();
        $permissions = Permission::all();

        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('admin.roles.create',compact('permission'));
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
            'name' => 'required|unique:roles,name',
            // 'permission' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->with('error', 'Something went wrong');
        }

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
            return redirect()->route('admin.roles.index')->with('success', $request->name . ' Role Added.');
        

        // return redirect()->back();
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return view('admin.roles.create',compact('role','permission','rolePermissions'));
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
        if($role = Role::findOrFail($id)) {
            // admin role has everything
            if($role->name === 'Super Duper Admin') {
                $role->syncPermissions(Permission::all());
                return redirect()->route('admin.roles.index');
            }

        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));
            return redirect()->route('admin.roles.index')->with('success', $role->name . ' permissions has been updated.');
        } else {
            return redirect()->route('admin.roles.index')->with('error', 'Role with id '. $id .' note found.');
        }

        return redirect()->route('admin.roles.index');
    }

    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return view('admin.roles.show',compact('role','rolePermissions'));
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('admin.roles.index')
                        ->with('success','Role deleted successfully');
    }
}
