<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests\StoreDuration;
use App\Http\Requests\UpdateDuration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Duration;
use App\User;
use Auth;
use Validator;
use Session;
use Redirect;
use DataTables;

class DurationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view_durations|add_durations|edit_durations|delete_durations', ['only' => ['index','show']]);
        $this->middleware('permission:add_durations', ['only' => ['create','store']]);
        $this->middleware('permission:edit_durations', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_durations', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.duration.list');
    }

    public function duration_list(Request $request)
    {
        $duration = Duration::select('id', 'name', 'status')->where('deleted_at', NULL)->latest()->get();

        if(count($duration) > 0)
        {
            foreach ($duration as $key => $value)
            {
                $duration[$key]['checkbox'] = '<input type="checkbox" name="checkbox[]" class="delete_check" value="'.$value->id.'" id=delcheck_'.$value->id.' >';
                $duration[$key]['sr_no'] = $key + 1;
                $duration[$key]['name'] = $value->name;
                $duration[$key]['action'] = NULL;
                $duration[$key]['edit'] = route('admin.durations.edit', Crypt::encrypt($value->id));
                $duration[$key]['show'] = route('admin.durations.show' , Crypt::encrypt($value->id));
                $duration[$key]['update_status'] = route('admin.durations.status', ['id' => Crypt::encrypt($value->id), 'status' => $value->status]);
                $duration[$key]['delete'] = route('admin.durations.destroy', Crypt::encrypt($value->id));
                $duration[$key]['can_edit_durations'] = \Gate::allows('edit_durations', 'admin.durations.edit');
                $duration[$key]['can_view_durations'] = \Gate::allows('view_durations', 'admin.durations.show');
                $duration[$key]['can_delete_durations'] = \Gate::allows('delete_durations', 'admin.durations.destroy');
                $duration[$key]['can_update_status'] = \Gate::allows('status_durations', 'admin.durations.status');
            }
        }

        return Datatables::of($duration)
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
        return view('admin.duration.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDuration $request)
    {
        $duration = new Duration;
        $duration->created_by = Auth::user()->id;
        $duration->name = $request->name;

        if ($duration->save()) {
            Session::flash('success', 'Duration Added Successfully.');
            return Redirect()->route('admin.durations.index');
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
        $data['duration'] = Duration::find($id);
        return view('admin.duration.show', $data);
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
        $data['duration'] = Duration::find($id);
        return view('admin.duration.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDuration $request, $id)
    {
        $id = Crypt::decrypt($id);
        $duration = Duration::find($id);
        $duration->created_by = Auth::user()->id;
        $duration->name = $request->name;

        if ($duration->save()) {
            Session::flash('success', 'Duration Updated Successfully.');
            return Redirect()->route('admin.durations.index');
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

        $delete = Duration::find($id);

        $delete->deleted_at = CURRENT_DATE;

        $result['status'] = API_SUCCESS_RESPONSE;

        if ($delete->save()) {
            Session::flash('success', 'Duration Deleted Successfully.');
            return response()->json($result, 200);
        }
    }

    //update duration status
    public function update_status($id, $status)
    {
        $id = Crypt::decrypt($id);
        
        $duration = Duration::find($id);

        if ($duration) {
            $duration->status = ($status == INACTIVE) ? ACTIVE : INACTIVE;
            $duration->save();

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
        $delete = Duration::whereIn('id',$request->deleteids_arr)->delete();
        Session::flash('success', 'Duration Deleted Successfully.');        
    }
}
