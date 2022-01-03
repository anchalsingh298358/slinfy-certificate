@extends('layouts.admin')
@section('title', ' User Profile')
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

                        {{--<li class="breadcrumb-item active">Batch List</li>--}}

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

                            <h4 class="float-left">{{isset($user) ? 'Edit' : 'Add'}} User </h4>

                        </div>

                        <div class="card-body account-setting-wrap">

                            <div class="container h-100">

                                <div class="row h-100 justify-content-center align-items-center">

                                    @if(isset($user))

                                    {!! Form::model($user, ['method' => 'PATCH','route' => ['admin.users.update', \Illuminate\Support\Facades\Crypt::encrypt($user->id)] , 'files' => true, 'class' => 'col-md-8', 'id' => 'user-form']) !!}

                                    @else

                                    {!! Form::open(['method' => 'POST','route' => ['admin.users.store'] , 'files' => true, 'class' => 'col-md-8', 'id' => 'user-form']) !!}

                                    @endif

                                        {{ csrf_field() }}


                                        <div class="form-row mb-3">

                                            <label class="col-sm-3 col-form-label" for="size">Name</label>

                                            <div class="col-sm-9">

                                                <input type="text" class="form-control" name="name" id="name"
                                                       value="{{isset($user) ? $user->name : old('name')}}" placeholder="Enter Name" />
                                            </div>

                                        </div>

                                        <div class="form-row mb-3">

                                            <label class="col-sm-3 col-form-label" for="size">Email</label>

                                            <div class="col-sm-9">

                                                <input type="text" class="form-control" name="email" id="email"
                                                       value="{{isset($user) ? $user->email : old('email')}}" placeholder="Enter Email" />
                                            </div>

                                        </div>

                                        <div class="form-row mb-3">

                                            <label class="col-sm-3 col-form-label" for="size">Password</label>

                                            <div class="col-sm-9">

                                                <input type="text" class="form-control" name="password" id="password"
                                                value="" placeholder="Enter Password" />
                                            </div>

                                        </div>

                                        <div class="form-row mb-3">

                                            <label class="col-sm-3 col-form-label" for="size">Confirm Password</label>

                                            <div class="col-sm-9">

                                                <input type="text" class="form-control" name="confirm-password" id="confirm-password"
                                                value="" placeholder="Enter Confirm Password" />
                                            </div>

                                        </div>

                                        <div class="form-row mb-3">

                                            <label class="col-sm-3 col-form-label" for="size">Role</label>

                                            <div class="col-sm-9">

                                                @if(isset($userRole))
                                                <!-- {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!} -->

                                                <!-- <?php
                                                    print_r($userRole);

                                                ?> -->

                                                <select name="roles" multiple="" class="form-control">
                                                    @foreach($roles as $role)
                                                    <option value="{{ $role }}">{{ $role }}</option>
                                                    @endforeach
                                                </select>

                                                @else
                                                <!-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!} -->

                                                <select name="roles" multiple="" class="form-control">
                                                    @foreach($roles as $role)
                                                    <option>{{ $role }}</option>
                                                    @endforeach
                                                </select>
                                                @endif
                                                
                                            </div>

                                        </div>


                                        <div class="form-row">

                                            <div class="col-sm-3"></div>


                                            <div class="col-sm-9   ">

                                                <button type="submit" class="btn update-btn btn-primary">Submit</button>

                                                <a href="{{route('admin.users.index')}}"
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


@endsection