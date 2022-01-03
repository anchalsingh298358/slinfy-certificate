<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use Validator;
use App\User;
use App\Technology;
use App\Duration;
use App\Batch;
use App\Country;
use Redirect;
use Session;
use Auth;
use stdClass;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.certificate.list');
    }

    //Get student data for datatable
    public function certificate_student_list(Request $request)
    {
        $students = User::with('getTechnology', 'getDuration', 'getBatch')->where('deleted_at', NULL)->where('role_type', STUDENT_USER)->get()->toArray();
        
        if(count($students) > 0)
        {
            foreach ($students as $key => $value)
            {
                $students[$key]['checkbox'] = '<input type="checkbox" name="checkbox[]" class="delete_check" value="'.$value['id'].'" id=delcheck_'.$value['id'].' >';
                $students[$key]['print'] = '<a href="'.route("admin.student.certificate", Crypt::encrypt($value["id"])) .'"><img src="'.asset('public/images/certificate/print.jpg').'"/></a>';
                $students[$key]['sr_no'] = $key + 1;
                $students[$key]['name'] = $value['name'];
                $students[$key]['email'] = $value['email'];
                $students[$key]['student_phone_number'] = '+'.$value['country_code'] .' '.$value['phone_number'] ;
                $students[$key]['gender'] = $value['gender'];
             
                $students[$key]['father_name'] = $value['father_name'];
                $students[$key]['mother_name'] = $value['mother_name'];
                $students[$key]['technology'] = isset($value['get_technology']) ? $value['get_technology']['name'] : NULL;

                $dateFrom = isset($value['date_from']) ? date('d M Y', strtotime($value['date_from'])) : '';
                $dateTo = isset($value['date_to']) ? date('d M Y', strtotime($value['date_to'])) : '';

                $students[$key]['date_from'] = $value['date_from'];
                $students[$key]['date_to'] =  $value['date_to'];
                $students[$key]['batch'] = isset($value['get_batch']) ? $value['get_batch']['name'] : NULL;
                $students[$key]['duration'] = isset($value['get_duration']) ? $value['get_duration']['name'] : NULL;
                $students[$key]['college_name'] = $value['college_name'];
                $students[$key]['session'] = $value['session'];
                $students[$key]['action'] = NULL;
                $students[$key]['edit'] = route('admin.students.edit' , Crypt::encrypt($value['id']));
                $students[$key]['show'] = route('admin.students.show' , Crypt::encrypt($value['id']));
                $students[$key]['update_status'] = route('admin.students.status', ['id' => Crypt::encrypt($value['id']), 'status' => $value['status']]);
                $students[$key]['delete'] = route('admin.students.destroy', Crypt::encrypt($value['id']));
                $students[$key]['can_edit_students'] = \Gate::allows('edit_students', 'admin.students.edit');
                $students[$key]['can_view_students'] = \Gate::allows('view_students', 'admin.students.show');
                $students[$key]['can_delete_students'] = \Gate::allows('delete_students', 'admin.students.destroy');
                $students[$key]['can_update_status'] = \Gate::allows('status_students', 'admin.students.status');
            }
        }

        return Datatables::of($students)
            // ->addColumn('checkbox', '<input type="checkbox" name="checkbox[]" class="delete_check" value="" id="delcheck_"'.$row['id'].'/>')            
            ->rawColumns(['print','action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
