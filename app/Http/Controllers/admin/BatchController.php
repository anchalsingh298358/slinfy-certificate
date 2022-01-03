<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBatch;
use App\Http\Requests\UpdateBatch;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Batch;
use App\User;
use Auth;
use Validator;
use Session;
use Redirect;
use DataTables;

class BatchController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view_batches|add_batches|edit_batches|delete_batches', ['only' => ['index','show']]);
        $this->middleware('permission:add_batches', ['only' => ['create','store']]);
        $this->middleware('permission:edit_batches', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_batches', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.batch.list');
    }


    public function batch_list(Request $request)
    {
        $batches = Batch::select('id', 'name', 'status')->where('deleted_at', NULL)->latest()->get();

        if(count($batches) > 0)
        {
            foreach ($batches as $key => $value)
            {
                $batches[$key]['checkbox'] = '<input type="checkbox" name="checkbox[]" class="delete_check" value="'.$value->id.'" id=delcheck_'.$value->id.' >';
                $batches[$key]['sr_no'] = $key + 1;
                $batches[$key]['name'] = $value->name;
                $batches[$key]['action'] = NULL;
                $batches[$key]['edit'] = route('admin.batches.edit', Crypt::encrypt($value->id));
                $batches[$key]['show'] = route('admin.batches.show', Crypt::encrypt($value->id));
                $batches[$key]['update_status'] = route('admin.batches.status', ['id' => Crypt::encrypt($value->id), 'status' => $value->status]);
                $batches[$key]['delete'] = route('admin.batches.destroy', Crypt::encrypt($value->id));
                $batches[$key]['can_edit_batches'] = \Gate::allows('edit_batches', 'admin.batches.edit');
                $batches[$key]['can_view_batches'] = \Gate::allows('view_batches', 'admin.batches.show');
                $batches[$key]['can_delete_batches'] = \Gate::allows('delete_batches', 'admin.batches.destroy');
                $batches[$key]['can_update_status'] = \Gate::allows('status_batches', 'admin.batches.status');
            }
        }

        return Datatables::of($batches)
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
        return view('admin.batch.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBatch $request)
    {
        $batch = new Batch;
        $batch->created_by = Auth::user()->id;
        $batch->name = $request->name;

        if ($batch->save()) {
            Session::flash('success', 'Batch Added Successfully.');
            return Redirect()->route('admin.batches.index');
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
        $data['batch'] = Batch::find($id);
        return view('admin.batch.show', $data);
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
        $data['batch'] = Batch::find($id);
        return view('admin.batch.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBatch $request)
    {
        $id = Crypt::decrypt($request->id);
        $batch = Batch::find($id);
        $batch->created_by = Auth::user()->id;
        $batch->name = $request->name;

        if ($batch->save()) {
            Session::flash('success', 'Batch Updated Successfully.');
            return Redirect()->route('admin.batches.index');
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
        $delete = Batch::find($id);

        $delete->deleted_at = CURRENT_DATE;

        $result['status'] = API_SUCCESS_RESPONSE;

        if ($delete->save()) {
            Session::flash('success', 'Batch Deleted Successfully.');
            return response()->json($result, 200);
        }
    }

    //update course status
    public function update_status($id, $status)
    {
        $id = Crypt::decrypt($id);
        $batch = Batch::find($id);

        if ($batch) {
            $batch->status = ($status == INACTIVE) ? ACTIVE : INACTIVE;
            $batch->save();

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
        $delete = Batch::whereIn('id',$request->deleteids_arr)->delete();
        Session::flash('success', 'Batch Deleted Successfully.');        
        
    }
}
