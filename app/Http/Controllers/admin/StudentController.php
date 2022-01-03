<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Http\Requests\StoreStudent;
use App\Http\Requests\StoreStudentImport;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
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

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.students.list');
    }

    //Get student data for datatable
    public function student_list(Request $request)
    {
        $students = User::with('getTechnology', 'getDuration', 'getBatch')->where('deleted_at', NULL)->where('role_type', STUDENT_USER)->get()->toArray();
        
        if(count($students) > 0)
        {
            foreach ($students as $key => $value)
            {
                // $students[$key]['checkbox'] = '<input type="checkbox" name="checkbox[]" class="delete_check" value="'.$value['id'].'" id=delcheck_'.$value['id'].' >';
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
        $data['countries'] = Country::get();
        $data['technologies'] = Technology::where('deleted_at', NULL)->where('status', ACTIVE)->get()->toArray();
        $data['durations'] = Duration::where('deleted_at', NULL)->where('status', ACTIVE)->get()->toArray();
        $data['batches'] = Batch::where('deleted_at', NULL)->where('status', ACTIVE)->get()->toArray();
        return view('admin.students.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudent $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->country_code = $request->country_code;
        $user->email = $request->email;
        $user->date = $request->date;
        $user->father_name = $request->father_name;
        $user->mother_name = $request->mother_name;
        $user->gender = $request->gender;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->duration_id = $request->duration;
        $user->date_from = $request->date_from;
        $user->date_to = $request->date_to;
        $user->technology_id = $request->technology;
        $user->college_name = $request->college_name;
        $user->session = $request->session;
        $user->batch_id = $request->batch;

        $role = Role::firstOrCreate(['name' => 'Student']);

        $user->role_type = $role->name;
        $user->role_id = $role->id;

        $picture = '';
        $path = '/public/images/profile';

        if ($request->hasFile('profile_pic')) {
            $file = $request->profile_pic;
            $extension = $file->getClientOriginalExtension();
            $picture = uniqid() . date('YmdHis') . '.' . $extension;
            $destinationPath = base_path() . $path;
            $file->move($destinationPath, $picture);

            $user->profile_pic = $path . '/' . $picture;
        }

        if ($user->save()) {
            return redirect()->route('admin.students.index')->withSuccess('Student Created Successfully!');
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
        $data['student'] = User::with('getTechnology', 'getDuration', 'getBatch')->find($id);
        return view('admin.students.show', $data);
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
        $data['countries'] = Country::get();
        $data['technologies'] = Technology::where('deleted_at', NULL)->where('status', ACTIVE)->get()->toArray();
        $data['durations'] = Duration::where('deleted_at', NULL)->where('status', ACTIVE)->get()->toArray();
        $data['batches'] = Batch::where('deleted_at', NULL)->where('status', ACTIVE)->get()->toArray();
        $data['student'] = User::with('getTechnology', 'getDuration', 'getBatch')->find($id);
        return view('admin.students.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = Crypt::decrypt($request->id);
        $user = User::find($id);
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->country_code = $request->country_code;
        $user->email = $request->email;
        $user->date = $request->date;
        $user->father_name = $request->father_name;
        $user->mother_name = $request->mother_name;
        $user->gender = $request->gender;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->duration_id = $request->duration;
        $user->date_from = $request->date_from;
        $user->date_to = $request->date_to;
        $user->technology_id = $request->technology;
        $user->college_name = $request->college_name;
        $user->session = $request->session;
        $user->batch_id = $request->batch;

        $role = Role::firstOrCreate(['name' => 'Student']);

        $user->role_type = $role->name;
        $user->role_id = $role->id;
        $user->status = $request->status;

        $picture = '';
        $path = '/public/images/profile';

        if ($request->hasFile('profile_pic')) {
            $file = $request->profile_pic;
            $extension = $file->getClientOriginalExtension();
            $picture = uniqid() . date('YmdHis') . '.' . $extension;
            $destinationPath = base_path() . $path;
            $file->move($destinationPath, $picture);

            $user->profile_pic = $path . '/' . $picture;
        }

        if ($user->save()) {
            return redirect()->route('admin.students.index')->withSuccess('Student Updated Successfully!');
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

        $delete = User::find($id);

        $delete->deleted_at = CURRENT_DATE;

        $result['status'] = API_SUCCESS_RESPONSE;

        if ($delete->save()) {
            Session::flash('success', 'Student Deleted Successfully.');
            return response()->json($result, 200);
        }
    }

    //update category status
    public function update_status($id, $status)
    {
        $id = Crypt::decrypt($id);

        $userstatus = User::find($id);

        if ($userstatus) {
            $userstatus->status = ($status == INACTIVE) ? ACTIVE : INACTIVE;
            $userstatus->save();

            $result['status'] = API_SUCCESS_RESPONSE;
            return response()->json($result, 200);
        } else {
            $result['status'] = API_FAILURE_RESPONSE;
            return response()->json($result, 200);
        }
    }

    public function import_form()
    {
        return view('admin.students.import_form');
    }

    public function import_student(StoreStudentImport $request)
    {
        if (!$request->file('import_student')) {
            Session::flash('error', 'Please choose file.');
            return redirect()->back();
        }

        config(['excel.import.startRow' => 2]);

        $return = Excel::toArray(new UsersImport,request()->file('import_student'));
   
        foreach ($return[0] as $key => $value)
        {
            $emailExists = User::where('email', $value['emailid'])->first();
            if (!empty($emailExists)) {
                Session::flash('error', $value['emailid'] .' already exists');
                return redirect()->back();
            }

            $phoneExists = User::where('email', $value['contactno'])->first();
            if (!empty($phoneExists)) {
                Session::flash('error', $value['contactno'] .' already exists');
                return redirect()->back();
            }

            $checkDuration = Duration::where('name', $value['duration'])->first();
            if(!empty($checkDuration))
            {
                $duration = $checkDuration->id;
            }
            else
            {
                $newDuration = new Duration;
                $newDuration->name = $value['duration'];
                $newDuration->status = ACTIVE;
                $newDuration->save();

                $duration = $newDuration->id;
            }


            $checkTechnology = Technology::where('name', $value['technology'])->first();
            if(!empty($checkTechnology))
            {
                $technology = $checkTechnology->id;
            }
            else
            {
                $newTechnology = new Technology;
                $newTechnology->name = $value['technology'];
                $newTechnology->status = ACTIVE;
                $newTechnology->save();

                $technology = $newTechnology->id;
            }

            $data = new User;
            $replace = str_replace('/', '-', $value['date']);
            $data->date = date('Y-m-d', strtotime($replace));
          
            $data->name = $value['studentname'];
            $data->father_name = $value['fathername'];
            $data->mother_name = $value['mothername'];
            $data->address = $value['address'];
            $data->city = $value['city'];
            $data->state = $value['state'];
            $data->country_code = $value['countrycode'];
            $data->phone_number = $value['contactno'];
            $data->duration_id = $duration;

            $replace_date_from = str_replace('/', '-', $value['datefrom']);
            $data->date_from = date('Y-m-d', strtotime($replace_date_from));

            $replace_date_to = str_replace('/', '-', $value['dateto']);
            $data->date_to = date('Y-m-d', strtotime($replace_date_to));

            $data->technology_id = $technology;
            $data->email = $value['emailid'];
            $data->gender = $value['gender'];
            $data->college_name = $value['collegename'];
            $data->session = $request['session'];
            $data->created_by = Auth::user()->id;
            $role = Role::firstOrCreate(['name' => 'Student']);

            $data->role_type = $role->name;
            $data->role_id = $role->id;
            $data->save();
        }

        return redirect()->route('admin.students.index')->withSuccess('Uploaded Successfully!');
    }

    public function studentCertificate($studentID)
    {
        $studentID = Crypt::decrypt($studentID);

        $data['user'] = User::with('getTechnology', 'getDuration', 'getBatch')->find($studentID);
        return view('admin.certificate.certificate', $data);
    }

}
