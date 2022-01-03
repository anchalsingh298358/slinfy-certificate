@extends('layouts.admin')

@section('title', 'Import Students')

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

                    {{--<li class="breadcrumb-item active">Add Category</li>--}}

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

                            <h4 class="float-left">Import Student </h4>

                        </div>

                        <div class="card-body account-setting-wrap">

                            <div class="container h-100">

                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <strong>Please be sure to match your CSV with our sample- <a href="{{ url('public/csv_files/sample.xlsx') }}" download>Click Here</a> what your file should look like.</strong>
                                    </div>
                                </div>

                                <div class="row h-100 justify-content-center align-items-center">

                                    <form method="post" action="{{ route('admin.student.import.data') }}" enctype="multipart/form-data" class="col-md-8" id="import_student">

                                        @method('POST')

                                        {{ csrf_field() }}

                                        <div class="form-row mb-3">

                                            <label class="col-sm-3 col-form-label" for="size">File</label>

                                            <div class="col-sm-9">

                                                <div class="input text upload-button-field cstmUploadBtn col-form-label">
                                                    <label>Upload</label>
                                                    <input type="file" class="form-control import_file" name="import_student"
                                                    id="import_student" value="{{old('import_student')}}"/>
                                                    </div>

                                                    <div class="img-name-box upload_file">
                                                        
                                                    </div>

                                                <!-- <small class="error">{{ $errors->first('name') }}</small> -->
                                            </div>

                                        </div>

                                        <div class="form-row mb-3">

                                            <label class="col-sm-3 col-form-label" for="size">Session</label>

                                            <div class="col-sm-9">

                                                <select class="form-control" name="session" id="session">
                                                    <option selected="" disabled="">Select Session</option>
                                                    <option value="Jan - June {{ date('Y') }}">Jan - June {{ date('Y') }}</option>
                                                    <option value="Jan - June {{ date('Y') }}">July - Dec {{ date('Y') }}</option>
                                                </select>

                                                <!-- <small class="error">{{ $errors->first('session') }}</small> -->
                                            </div>

                                        </div>


                                        <div class="form-row">

                                            <div class="col-sm-3"></div>

                                            <div class="col-sm-9   ">

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
