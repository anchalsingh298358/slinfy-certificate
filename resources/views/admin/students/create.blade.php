@extends('layouts.admin')

@section('title', 'Add Student')

@section('content')


<div class="content-header">

    <div class="container-fluid">

        <div class="row mb-2">

            <div class="col-sm-6">

                <!-- <h1 class="m-0 text-dark">Add</h1> -->

            </div>

            <div class="col-sm-6">

                {{--<ol class="breadcrumb float-sm-right">--}}

                    {{--<li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>--}}

                    {{--<li class="breadcrumb-item active">Student List</li>--}}

                {{--</ol>--}}

            </div>

        </div>

    </div>

</div>

<?php
    $janJune = 'Jan - June ' . date('Y');
    $julyDec = 'July - Dec ' . date('Y');
?>

<section class="content">

    <div class="container-fluid">

        <div class="row">

            <div class="col-sm-12">

                <div class="card bg-white user-detail-wrap">

                    <div class="card-header  bg-white">

                        <h4 class="float-left">{{isset($student) ? 'Edit' : 'Add'}}  Student </h4>

                    </div>

                    <div class="card-body account-setting-wrap">

                        <div class="container h-100">

                            <div class="row h-100 justify-content-center align-items-center">

                                @if(isset($student))
                                    <form method="post" action="{{route('admin.students.update', \Illuminate\Support\Facades\Crypt::encrypt($student->id))}}" enctype="multipart/form-data" class="col-md-12" id="student-form">

                                        @method('PATCH')

                                      <input type="hidden" name="id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($student->id) }}">
                                      <input type="hidden" name="status" value="{{ $student->status }}">
                                @else

                                <form method="post" action="{{ route('admin.students.store') }}" enctype="multipart/form-data" class="col-md-12" id="student-form">

                                    @method('POST')                                    

                                @endif

                                @csrf


                            <div class="row ">
                                <div class="col-md-6">

                                    <label class="col-sm-3 col-form-label" for="size">Image</label>

                                    <div class="col-sm-4 input text upload-button-field cstmUploadBtn col-form-label">
                                    <label>Upload</label>
                                    <input type="file" class="form-control image" name="profile_pic"
                                    id="profile_pic" value="{{old('profile_pic')}}"/>

                                    <!-- <small class="error">{{ $errors->first('profile_pic') }}</small> -->
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="img-name-box upload_file">
                                            
                                            <?php
                                                if(isset($student))
                                                {
                                                    $displayImg = 'display: block';
                                                }
                                                else
                                                {
                                                    $displayImg = 'display: none';
                                                }
                                            ?>

                                            <img src="{{ isset($student) ? asset($student->profile_pic) : ''  }}" class="profile-img-tag" width="100px" style="{{ $displayImg }}" />

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label" for="size">Session</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="session" id="session">
                                            <option selected="" disabled="">Select Session</option>
                                            <option value="Jan - June {{ date('Y') }}" {{ isset($student) && $student->session == $janJune ? 'selected' : '' }}>
                                            {{ $janJune }}
                                            </option>
                                            <option value="Jan - June {{ date('Y') }}"  >{{ $julyDec }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label" for="size">Student Name</label>
                                    <div class="col-sm-12">

                                        <input type="text" class="form-control" name="name"
                                        id="name" value="{{ isset($student) ? $student->name : old('name') }}" placeholder="Enter Student Name" />

                                        <!-- <small class="error">{{ $errors->first('name') }}</small> -->
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label" for="size">Gender</label>

                                    <div class="col-sm-12">
                                        <select name="gender" class="form-control">
                                            <option selected="" disabled="">Select Gender</option>
                                            <option value='Male' {{ isset($student) && $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value='Female' {{ isset($student) && $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                            <option value='Other' {{ isset($student) && $student->gender == 'Other' ? 'selected' : '' }} >Other</option>
                                        </select>                     
                                        <!-- <small class="error">{{ $errors->first('gender') }}</small> -->
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label" for="size">Father Name</label>

                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="father_name"
                                        id="father_name" value="{{ isset($student) ? $student->father_name : old('father_name') }}" placeholder="Enter Father Name"/>
                                        <!-- <small class="error">{{ $errors->first('father_name') }}</small> -->
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label" for="size">Mother Name</label>

                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="mother_name"
                                        id="profession" value="{{ isset($student) ? $student->mother_name : old('mother_name') }}" placeholder="Enter Mother Name"/>
                                        <!-- <small class="error">{{ $errors->first('profession') }}</small> -->
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label" for="size">City </label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="city"
                                        id="city-input" value="{{ isset($student) ? $student->city : old('city') }}" placeholder="Enter City" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label" for="size">Address </label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="address"
                                        id="address-input" value="{{ isset($student) ? $student->address : old('address') }}"  placeholder="Enter Address"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label" for="size">State </label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="state"
                                        id="state-input" value="{{ isset($student) ? $student->state : old('state') }}"   placeholder="Enter State"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label" for="size">College Name </label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="college_name"
                                        id="college_name-input" value="{{ isset($student) ? $student->college_name : old('college_name') }}"  placeholder="Enter College Name"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <label class="col-sm-12 col-form-label" for="size">Select Country</label>
                                                    <div class="col-sm-12">

                                                        <select class="form-control country" name="country_code">
                                                            <option disabled="" selected="">Select Country</option>
                                                            @if(!empty($countries))
                                                            @foreach($countries as $key => $country)
                                                            <option
                                                            value="{{$country->phonecode}}" {{ isset($student) && $student->country_code == $country->phonecode ? 'selected' : '' }}>{{$country->name}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>

                                                        <!-- <small class="error">{{ $errors->first('country') }}</small> -->
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label class="col-sm-12 col-form-label" for="size">Phone Number</label>
                                                        <input type="text" class="form-control" name="phone_number"
                                                        id="phone_number" value="{{ isset($student) ? $student->phone_number : old('phone_number') }}" placeholder="Enter Phone Number"/>

                                                        <!-- <small class="error">{{ $errors->first('phone_number') }}</small> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label" for="size">Email</label>
                                    <div class="col-sm-12">

                                        <input type="email" class="form-control" name="email" id="email"
                                        value="{{ isset($student) ? $student->email : old('email') }}" placeholder="Enter Email"/>

                                        <!-- <small class="error">{{ $errors->first('email') }}</small> -->
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label" for="size">Duration</label>
                                    <div class="col-sm-12">

                                        @if(count($durations) > 0)
                                            <select id="duration" class="duration form-control" name="duration">
                                                <option selected="" disabled="">Select Duration</option>
                                                @foreach($durations as $duration)
                                                    <option value="{{ $duration['id'] }}" {{ isset($student) && $student->duration_id == $duration['id'] ? 'selected' : '' }}> {{ $duration['name'] }}</option>
                                                @endforeach
                                            </select>
                                        @endif

                                        <!-- <small class="error">{{ $errors->first('course') }}</small> -->
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label" for="size">Technology</label>
                                    <div class="col-sm-12">
                                        @if(count($technologies) > 0)
                                            <select id="technology" class="technology form-control" name="technology">
                                                <option selected="" disabled="">Select Technology</option>
                                                @foreach($technologies as $technology)
                                                    <option value="{{ $technology['id'] }}" {{ isset($student) && $student->technology_id == $technology['id'] ? 'selected' : '' }}> {{ $technology['name'] }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        
                                        <!-- <small class="error">{{ $errors->first('department') }}</small> -->
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label" for="size">Date From</label>
                                    <div class="col-sm-12">

                                        <input type="date" class="form-control" name="date_from" id="date_from"
                                        value="{{ isset($student) ? $student->date_from : old('date_from') }}" placeholder="Enter Date From"/>

                                        <!-- <small class="error">{{ $errors->first('date_from') }}</small> -->
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label" for="size">Date To</label>
                                    <div class="col-sm-12">
                                        <input type="date" class="form-control" name="date_to"
                                        id="date_to" placeholder="Enter Date To" value="{{ isset($student) ? $student->date_to : old('date_to') }}">
                                        <!-- <small class="error">{{ $errors->first('date_to') }}</small> -->
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-sm-3 col-form-label" for="size">Batches</label>
                                    <div class="col-sm-12">
                                        @if(count($batches) > 0)
                                            <select id="batch" class="batch form-control" name="batch">
                                                <option selected="" disabled="">Select Batch</option>
                                                @foreach($batches as $batch)
                                                    <option value="{{ $batch['id'] }}" {{ isset($student) && $student->batch_id == $batch['id'] ? 'selected' : '' }}> {{ $batch['name'] }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-row1 mt-2">

                                <div class="col-sm-3"></div>

                                <div class="col-sm-12">

                                    <button type="submit" class="btn update-btn btn-primary">Submit</button>

                                    <a href="{{route('admin.students.index')}}"
                                    class="btn update-btn btn-default">Cancel</a>

                                </div>
                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


</div>


</section>



@stop
