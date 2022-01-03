@extends('layouts.admin')

@section('title', 'Student Detail')


@section('content')



    <div class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <!-- <h1 class="m-0 text-dark">Add</h1> -->

                </div>

                <div class="col-sm-6">

                    {{--<ol class="breadcrumb float-sm-right">--}}

                    {{--<li class="breadcrumb-item"><a href="{{url('/admin')}}">Home</a></li>--}}

                    {{--<li class="breadcrumb-item active">Edit Category</li>--}}

                    {{--</ol>--}}

                </div>

            </div>

        </div>

    </div>



    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="card bg-white user-detail-wrap">

                        <div class="card-header  bg-white">

                            <h4 class="float-left">Student Detail </h4>

                        </div>

                        <div class="card-body account-setting-wrap">

                            <div class="container h-100">

                                <div class="row h-100 justify-content-center align-items-center">

                                    <table class="table table-striped">
                                    <tbody>
                                            <tr>
                                                <th>Profile Pic</th>
                                                <td><span id=""></span>
                                                @if(!empty($student->profile_pic))
                                                <img src="{{url('/') . $student->profile_pic}}" width="100"> 
                                                @else
                                                N/A
                                                @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Name</th>
                                                <td><span id=""></span>{{ $student->name }} </td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td><span id=""></span>{{ $student->email }} </td>
                                            </tr>
                                            <tr>
                                                <th>Phone Number</th>
                                                <td><span id=""></span>+{{ $student->country_code }} {{ $student->phone_number }} </td>
                                            </tr>
                                            <tr>
                                                <th>Gender</th>
                                                <td><span id=""></span>{{$student->gender}}</td>
                                            </tr>
                                            <tr>
                                                <th>Father Name</th>
                                                <td><span id=""></span>{{ $student->father_name }} </td>
                                            </tr>
                                            <tr>
                                                <th>Mother Name</th>
                                                <td><span id=""></span>{{ $student->mother_name }} </td>
                                            </tr>
                                            
                                            <tr>
                                                <th>Duration</th>
                                                <td><span id=""></span>{{ isset($student->getDuration->name) ? $student->getDuration->name : '' }} </td>
                                            </tr>
                                            <tr>
                                                <th>Course Date</th>
                                                <td><span id=""></span>{{ $student->date_from }} - {{ $student->date_to }} </td>
                                            </tr>
                                            <tr>
                                                <th>Batch</th>
                                                <td><span id=""></span>{{ isset($student->getBatch->name) ? $student->getBatch->name : '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Technology</th>
                                                <td><span id=""></span>{{ isset($student->getTechnology->name) ? $student->getTechnology->name : '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>College Name</th>
                                                <td><span id=""></span>{{ $student->college_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Session</th>
                                                <td><span id=""></span>{{ $student->session }}</td>
                                            </tr>
                                            
                                        </tbody>
                                </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@stop

@section('scripts')
    <script>
        
    </script>
@stop
