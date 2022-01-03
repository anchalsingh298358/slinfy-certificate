@extends('layouts.admin')

@section('title', 'Add Technology')

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

    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="card bg-white user-detail-wrap">

                        <div class="card-header  bg-white">

                            <h4 class="float-left">{{isset($technology) ? 'Edit' : 'Add'}} Technology </h4>

                        </div>

                        <div class="card-body account-setting-wrap">

                            <div class="container h-100">

                                <div class="row h-100 justify-content-center align-items-center">

                                    @if(isset($technology))
                                        <form method="post" action="{{route('admin.technology.update', \Illuminate\Support\Facades\Crypt::encrypt($technology->id) )}}" enctype="multipart/form-data" class="col-md-8" id="technology-form">

                                        @method('patch')

                                          <input type="hidden" name="id" value="{{ \Illuminate\Support\Facades\Crypt::encrypt($technology->id) }}">
                                          <input type="hidden" name="status" value="{{ $technology->status }}">
                                    @else

                                    <form method="post" action="{{route('admin.technology.store')}}" enctype="multipart/form-data" class="col-md-8" id="technology-form">
                                    @method('post')

                                    @endif

                                        {{ csrf_field() }}


                                        <div class="form-row mb-3">

                                            <label class="col-sm-3 col-form-label" for="size">Name</label>

                                            <div class="col-sm-9">

                                                <input type="text" class="form-control" name="name" id="name"
                                                       value="{{isset($technology) ? $technology->name : old('name')}}" placeholder="Enter Technology Name" />

                                                <!-- <small class="error">{{ $errors->first('name') }}</small> -->
                                            </div>

                                        </div>


                                        <div class="form-row">

                                            <div class="col-sm-3"></div>


                                            <div class="col-sm-9   ">

                                                <button type="submit" class="btn update-btn btn-primary">Submit</button>

                                                <a href="{{route('admin.technology.index')}}"
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
