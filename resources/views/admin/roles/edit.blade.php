@extends('layouts.admin')

@section('title', 'Edit Role & Permissions')

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

                            <h4 class="float-left">{{isset($role) ? 'Edit' : 'Add'}} Batch </h4>

                        </div>

                        <div class="card-body account-setting-wrap">

                            <div class="container h-100">

                                <div class="row h-100 justify-content-center align-items-center">

                                    @if(isset($role))

                                    {!! Form::model($role, ['method' => 'PATCH','route' => ['admin.roles.update', \Illuminate\Support\Facades\Crypt::encrypt($role->id)] , 'files' => true, 'class' => 'col-md-8', 'id' => 'role-form']) !!}
                                          
                                    @else

                                    {!! Form::model($role, ['method' => 'PATCH','route' => ['admin.roles.store'] , 'files' => true, 'class' => 'col-md-8', 'id' => 'role-form']) !!}

                                    @endif

                                        {{ csrf_field() }}


                                        <div class="form-row mb-3">

                                            <label class="col-sm-3 col-form-label" for="size">Name</label>

                                            <div class="col-sm-9">

                                                <input type="text" name="name" class="form-control" value="{{ $role->name }}">

                                            </div>

                                        </div>

                                        <div class="form-row mb-3">

                                            <label class="col-sm-3 col-form-label" for="size">Permission</label>

                                            <div class="col-sm-9">

                                                @foreach($permission as $value)
                                                    <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                                        {{ $value->name }}</label>
                                                        <br/>
                                                @endforeach
                                                
                                            </div>

                                        </div>


                                        <div class="form-row">

                                            <div class="col-sm-3"></div>


                                            <div class="col-sm-9   ">

                                                <button type="submit" class="btn update-btn btn-primary">Submit</button>

                                                <a href="{{route('admin.roles.index')}}"
                                                   class="btn update-btn btn-default">Cancel</a>

                                            </div>

                                        </div>

                                    {!! Form::close() !!}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


        </div>


    </section>


    @endsection

