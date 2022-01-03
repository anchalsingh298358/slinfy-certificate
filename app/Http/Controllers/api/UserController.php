<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Department;
use App\Course;
use Validator;
use Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        // print_r($password);die();

        $userId = '';

        if(is_numeric($username))
        {
            $validator = Validator::make($request->all(),array(
                        'username' => 'required|integer|min:10',
                        'school_id' =>'required',
                        'password' => 'required',
                        'country_code' => 'required',
                    ));
        }
        else
        {
            $validator = Validator::make($request->all(),array(
                       'username' => 'required|email',
                       'school_id' =>'required',
                       'password' => 'required'
                    ));
        }
        
        if($validator->fails()) 
        {
            return response()->json(['status' => API_FAILURE_RESPONSE, 'error' => $validator->errors()->first()],
                $this->successStatus);
        }
      
        // is phone?
        if(is_numeric($username))
        {

            if(Auth::attempt(['phone_number' => $request->username, 'password' => $request->password]))
            {
                $userId = Auth::user()->id;
                // print_r($userId);die();
            }

            if(!$userId)
            {
                return response()->json(['status' => 0, 'error' => 'Wrong Credential']);
            }

            $user = User::whereIn('user_type',[TEACHER_USER_TYPE,PARENT_USER_TYPE])->where([
                    'phone_number' => $username,
                    'school_id' => $request->school_id,
                    'status' => USER_STATUS_ACTIVE,
                    'id' => $userId,
                    'country_code' => $request->country_code
                    ])
                    // ->orWhere('mother_phone_no',$username)
                    ->first();
                    
            if (empty($user)) {
                return response()->json(['status' => 0, 'error' => 'User not exist']);
            } 
            
        }
        else
        {
            if(Auth::attempt(['email' => $username, 'password' => $password]))
            {
                $userId = Auth::user()->id;
            }



            $user = User::whereIn('user_type',[TEACHER_USER_TYPE,PARENT_USER_TYPE])->where([
                    'email' =>$username,
                    'school_id' => $request->school_id,
                    'status' => USER_STATUS_ACTIVE,
                    'id' => $userId
                ])
                ->first();

            if (empty($user)) {
                return response()->json(['error' => 'user not exist']);
            }
        }
      
        if($user){
            Auth::loginUsingId($user['id']);
            $user = Auth::user();
            $loginUsrId = $user->id;
            $classData['school_id'] = $request->school_id;
            $classData['teacher_id'] = $loginUsrId;
            $classData['session_id'] = $user->session_id;
            $classes = Classes::getTeacherClass($classData);
            $success['token'] = $user->createToken('SchoolDiary')->accessToken;
            $data['user_id'] = $user->id;
            $data['session'] = getSessionIdBySchoolId($request->school_id);
            // dd($data);
            $userDetail = User::getUserDetails($data);
            $userDetail = $userDetail['user'];
            $school_fee_config = Schools::getSchoolConfigByMetaKey(Auth::user()->school_id, SCHOOL_FEE_DURATION);
            $userDetail->school_fee_duration = ($school_fee_config) ? $school_fee_config->meta_value : "3";
            $userDetail->profile_url = url('/public/user_images');
            $user->device_token = request('device_token');
            $user->device_platform = request('device_platform');
            $user->device_unique_id = (request('device_unique_id') != null) ? request('device_unique_id') : '';
            
            $userDetail->login_counter = $user->login_counter ++;

            if($user->login_counter == 2)
            {
                $user->first_time_login = FIRST_TIME_LOGIN;
                $userDetail->first_time_login = $user->first_time_login;                
            }
            else
            {
                $userDetail->first_time_login = $user->first_time_login;
            }

            $userDetail['is_incharge'] = true;
            if (empty($userDetail['incharge'])) {
                $userDetail['is_incharge'] = false;
            }

            $userDetail['route_id'] = 0;
            if ($user->user_type == STUDENT_USER_TYPE) {
                $getRouteDetails = \App\Assign_routes::where(array(
                    'student_id' => $user->id,
                    'deleted_at' => null
                ))->first();
                if ($getRouteDetails) {
                    $userDetail['route_id'] = $getRouteDetails->route_id;
                }
            }

            if ($user->user_type == DRIVER_USER_TYPE) {
                $getRouteDetails = \App\Transport::where(array(
                    'driver_id' => $user->id,
                    'deleted_at' => null
                ))->first();
                if ($getRouteDetails) {
                    $userDetail['route_id'] = $getRouteDetails->id;
                }
            }
            if ($user->user_type == PARENT_USER_TYPE) {
                if (count($userDetail['child']) > 0) {
                    $key = 0;
                    $getRouteDetails = \App\Assign_routes::where(array(
                        'student_id' => $userDetail['child'][$key]->student_id,
                        'deleted_at' => null
                    ))->first();
                    if ($getRouteDetails) {
                        $userDetail['route_id'] = $getRouteDetails->route_id;
                    }
                }

            }
            $userDetail->otp = (!empty($otp)? $otp : '');

            //echo "<pre>";
            // print_r($userDetail);exit;
              if (sizeof($classes) > 0) {
            $userDetail['classList'] = $classes;
        }
           if ($user->save()) {

            return response()->json(['status' => 1,'success' => $success, 'data' => $userDetail], $this->successStatus);
        }
        }

    }
    
    //Login
    public function login1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'phone_number' => 'required',
            // 'country_code' => 'required',
            'email' => 'required',
            'device_type' => 'required',
            'device_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => API_FAILURE_RESPONSE, 'message' => $validator->errors()->first()], Response::HTTP_OK);
        }

        $user = User::with('getDepartment', 'getCourse', 'getBatch')->where(['email' => $request->email])->first();

        if(!$user)
        {
            $response = array(
                'status' => API_FAILURE_RESPONSE,
                'message' => 'Login Failed',
            );
        }
        elseif ($user->status == ACTIVE) {
            $updateDeviceToken = User::find($user->id);
            
            $updateDeviceToken->device_token = $request->device_token;
            $updateDeviceToken->device_type = $request->device_type;
            $updateDeviceToken->last_login = date('H:i:s');
            $updateDeviceToken->is_logged_in = IS_LOGGED_IN;
            $updateDeviceToken->save();

            if ($updateDeviceToken->profile_pic) {
                $user->profile_pic = !empty($updateDeviceToken->profile_pic) ? Url('/') . $updateDeviceToken->profile_pic : NULL;
            } else {
                $user->profile_pic = NULL;
            }

            $user->token = $user->createToken('MyApp')->accessToken;
            $response = array(
                'status' => API_SUCCESS_RESPONSE,
                'message' => 'Login Successfully.',
                'data' => $user
            );
        }        
        else{
            
            $response = array(
                'status' => API_FAILURE_RESPONSE,
                'message' => 'Currently Your Account Is Inactive',
            );
            
        }

        return response()->json($response, Response::HTTP_OK);
    }

    //Register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'country_code' => 'required',
            'phone_number' => 'required',
            'device_type' => 'required',
            'device_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => API_FAILURE_RESPONSE, 'message' => $validator->errors()->first()], Response::HTTP_OK);
        }

        $input = $request->all();

        $user_exist = User::with('getDepartment', 'getCourse', 'getBatch')->where(['phone_number' => $request->phone_number, 'user_type' => STUDENT_USER])->first();
                
        if (!($user_exist)) {
            $user = new User;
            $user->phone_number = $request->phone_number;
            $user->country_code = $request->country_code;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->user_type = $request->user_type;
            $user->device_type = $request->device_type;
            $user->device_token = $request->device_token;

            $user->save();

            $user->profile_pic = !empty($user->profile_pic) ? url('/') . $user->profile_pic : NULL;

            $user->token = $user->createToken('MyApp')->accessToken;
            $response = array(
                'status' => API_SUCCESS_RESPONSE,
                'message' => 'Register Successfully.',
                'data' => $user
            );

        } else {

            $updateDeviceToken = User::find($user_exist->id);
            $updateDeviceToken->device_token = $request->device_token;
            $updateDeviceToken->device_type = $request->device_type;
            $updateDeviceToken->last_login = date('H:i:s');
            $updateDeviceToken->is_logged_in = IS_LOGGED_IN;
            $updateDeviceToken->save();

            $user_exist->profile_pic = !empty($user_exist->profile_pic) ? url('/') . $user_exist->profile_pic : NULL;
            $user_exist->token = $user_exist->createToken('MyApp')->accessToken;
            $response = array(
                'status' => API_SUCCESS_RESPONSE,
                'message' => 'Login Successfully',
                'data' => $user_exist
            );
        }

        return response()->json($response, Response::HTTP_OK);
    }

    // Logout api
    public function logout(Request $request)
    {
        $usr = User::find(Auth::user()->id);

        if ($usr) {
            $response['message'] = API_FAILURE_TRY_AGAIN_MESSAGE;
            $usr->is_logged_in = IS_NOT_LOGGED_IN;
            $usr->device_token = NULL;
            $usr->last_login = date('H:i:s');
            if ($usr->save()) {
                $response = array(
                    'status' => API_SUCCESS_RESPONSE,
                    'message' => 'Logged out Successfully'
                );
            } else {
                $response = array(
                    'status' => API_FAILURE_RESPONSE,
                    'message' => $response['message'],
                );
            }
        }

        return response()->json($response, Response::HTTP_OK);
    }


    //Upload Profile
    public function upload_profile(Request $request)
    {
        $validator = validator($request->all(), [
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => API_FAILURE_RESPONSE, 'message' => $validator->errors()->first()], Response::HTTP_OK);
        }

        $id = Auth::user()->id;

        $user = User::with('getDepartment', 'getCourse', 'getBatch')->find($id);

        $path = '/public/images/profile';
        $file = $request->profile_pic;
        $extension = $file->getClientOriginalExtension();
        $picture = date('YmdHis') . '.' . $extension;
        $destinationPath = base_path() . $path;
        $file->move($destinationPath, $picture);
        $user->profile_pic = $path . '/' . $picture;

        if ($user->save()) {
            $response = [
                'status' => API_SUCCESS_RESPONSE,
                'message' => 'Upload Image Successfully',
                'data' => url('/') . $user->profile_pic
            ];
        } else {
            $response = array(
                'status' => API_FAILURE_RESPONSE,
                'message' => 'Something Went Wrong',
            );
        }

        return response()->json($response, Response::HTTP_OK);
    }


    //Notification ON/OFF
    public function notification_on_off(Request $request)
    {
        $validator = validator($request->all(), [
            'notification_status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => API_FAILURE_RESPONSE, 'message' => $validator->errors()->first()], Response::HTTP_OK);
        }

        $id = Auth::user()->id;

        $user = User::find($id);

        $user->notification_on_off = $request->notification_status;

        if ($user->save())
        {
            $response = [
                'status' => API_SUCCESS_RESPONSE,
                'message' => 'Successfully',
            ];
        }
        else
        {
            $response = array(
                'status' => API_FAILURE_RESPONSE,
                'message' => 'Something Went Wrong',
            );
        }

        return response()->json($response, Response::HTTP_OK);
    }

    //Get Own Profile
    public function get_own_profile(Request $request)
    {
        $data = User::with('getDepartment', 'getCourse', 'getBatch')->where(['id' => Auth::user()->id])->first();

        if(!empty($data) > 0)
        {
            $data->profile_pic  = !empty($data->profile_pic) ? url('/') . $data->profile_pic : NULL;

            $response = array(
                'status' => API_SUCCESS_RESPONSE,
                'message' => 'Successfully',
                'data' => $data
            );
        }
        else
        {
            $response = array(
                'status' => API_FAILURE_RESPONSE,
                'message' => 'No Found',
            );
        }

        return response()->json($response, Response::HTTP_OK);
    }

    //Update own user data
    public function update_own_data(Request $request)
    {
        $validator = validator($request->all(), [
            'date' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'course' => 'required',
            'date_from' => 'required',
            'date_to' => 'required|after:date_from',
            'department' => 'required',
            'college_name' => 'required',
            'session' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => API_FAILURE_RESPONSE, 'message' => $validator->errors()->first()], Response::HTTP_OK);
        }

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->date = $request->date;
        $data->father_name = $request->father_name;
        $data->mother_name = $request->mother_name;
        $data->gender = $request->gender;
        $data->address = $request->address;
        $data->city = $request->city;
        $data->state = $request->state;
        $data->course_id = $request->course;
        $data->date_from = $request->date_from;
        $data->date_to = $request->date_to;
        $data->department_id = $request->department;
        $data->college_name = $request->college_name;
        $data->session = $request->session;
        $data->batch_id = $request->batch;

        if ($data->save())
        {
            $response = [
                'status' => API_SUCCESS_RESPONSE,
                'message' => 'Successfully updated info',
            ];
        }
        else
        {
            $response = array(
                'status' => API_FAILURE_RESPONSE,
                'message' => 'Something Went Wrong',
            );
        }

        return response()->json($response, Response::HTTP_OK);
    }

    //Get Course List
    public function course_list()
    {
        $courses = Course::select('id', 'name', 'status')->where('deleted_at', NULL)->latest()->get()->toArray();

        if(count($courses) > 0)
        {
            $response = array(
                'status' => API_SUCCESS_RESPONSE,
                'message' => 'Successfully',
                'data' => $courses
            );
        }
        else
        {
            $response = array(
                'status' => API_FAILURE_RESPONSE,
                'message' => 'No Found',
            );
        }

        return response()->json($response, Response::HTTP_OK);
    }

    //Get Department List
    public function department_list()
    {
        $department = Department::select('id', 'name', 'status')->where('deleted_at', NULL)->latest()->get()->toArray();

        if(count($department) > 0)
        {
            $response = array(
                'status' => API_SUCCESS_RESPONSE,
                'message' => 'Successfully',
                'data' => $department
            );
        }
        else
        {
            $response = array(
                'status' => API_FAILURE_RESPONSE,
                'message' => 'No Found',
            );
        }

        return response()->json($response, Response::HTTP_OK);
    }
}
