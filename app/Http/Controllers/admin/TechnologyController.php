<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTechnology;
use App\Http\Requests\UpdateTechnology;
use Illuminate\Support\Facades\Crypt;
use App\Technology;
use App\User;
use Auth;
use Validator;
use Session;
use Redirect;
use DataTables;

class TechnologyController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view_technology|add_technology|edit_technology|delete_technology', ['only' => ['index','show']]);
        $this->middleware('permission:add_technology', ['only' => ['create','store']]);
        $this->middleware('permission:edit_technology', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_technology', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.technology.list');
    }


    //Get technology data for datatable
    public function technology_list(Request $request)
    {
        $technology = Technology::select('id', 'name', 'status')->where('deleted_at', NULL)->latest()->get();

        if(count($technology) > 0)
        {
            foreach ($technology as $key => $value)
            {
                $technology[$key]['checkbox'] = '<input type="checkbox" name="checkbox[]" class="delete_check" value="'.$value->id.'" id=delcheck_'.$value->id.' >';
                $technology[$key]['sr_no'] = $key + 1;
                $technology[$key]['name'] = $value->name;
                $technology[$key]['action'] = NULL;
                $technology[$key]['edit'] = route('admin.technology.edit' , Crypt::encrypt($value->id));
                $technology[$key]['show'] = route('admin.technology.show' , Crypt::encrypt($value->id));
                $technology[$key]['update_status'] = route('admin.technology.status', ['id' => Crypt::encrypt($value->id), 'status' => $value->status]);
                $technology[$key]['delete'] = route('admin.technology.destroy',Crypt::encrypt($value->id));
                $technology[$key]['can_edit_technology'] = \Gate::allows('edit_technology', 'admin.technology.edit');
                $technology[$key]['can_view_technology'] = \Gate::allows('view_technology', 'admin.technology.show');
                $technology[$key]['can_delete_technology'] = \Gate::allows('delete_technology', 'admin.technology.destroy');
                $technology[$key]['can_update_status'] = \Gate::allows('status_technology', 'admin.technology.status');
            }
        }

        return Datatables::of($technology)
            // ->addColumn('checkbox', '<input type="checkbox" name="checkbox[]" class="delete_check" value="" id="delcheck_"'.$row['id'].'/>')            
            ->rawColumns(['checkbox','action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.technology.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTechnology $request)
    {
        $technology = new Technology;
        $technology->created_by = Auth::user()->id;
        $technology->name = $request->name;

        if ($technology->save()) {
            Session::flash('success', 'Technology Added Successfully.');
            return Redirect()->route('admin.technology.index');
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
        $data['technology'] = Technology::find($id);
        return view('admin.technology.show', $data);
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
        $data['technology'] = Technology::find($id);
        return view('admin.technology.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTechnology $request, $id)
    {
        $id = Crypt::decrypt($id);
        $technology = Technology::find($id);
        $technology->created_by = Auth::user()->id;
        $technology->name = $request->name;
        $technology->status = $request->status;

        if ($technology->save()) {
            Session::flash('success', 'Technology Updated Successfully.');
            return Redirect()->route('admin.technology.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $delete = Technology::find($id);

        $delete->deleted_at = CURRENT_DATE;

        $result['status'] = API_SUCCESS_RESPONSE;

        if ($delete->save()) {
            Session::flash('success', 'Technology Deleted Successfully.');
            return response()->json($result, 200);
        }
    }

    //update technology status
    public function update_status($id, $status)
    {
        $id = Crypt::decrypt($id);
        $technology = Technology::find($id);

        if ($technology) {
            $technology->status = ($status == INACTIVE) ? ACTIVE : INACTIVE;
            $technology->save();

            $result['status'] = API_SUCCESS_RESPONSE;
            return response()->json($result, 200);
        } else {
            $result['status'] = API_FAILURE_RESPONSE;
            return response()->json($result, 200);
        }
    }

    //Delete All
    public function delete_all(Request $request)
    {
        $delete = Technology::whereIn('id',$request->deleteids_arr)->delete();
        Session::flash('success', 'Technology Deleted Successfully.');        
    }
}
