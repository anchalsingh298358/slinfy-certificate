@extends('layouts.admin')
@section('title', 'User Detail')
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

                            <h4 class=""><span class="float-left">Users Detail</span>
                               
                                <span class="float-right mr-1"><a href="{{ route('admin.users.index') }}" class="btn btn-primary">Back</a></span>
                                
                            </h4>

                        </div>

                        <div class="card-body account-setting-wrap">

                            <div class="container h-100">

                                <div class="row h-100 justify-content-center align-items-center">

                                    <table class="table table-striped">
                                    <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <td><span id=""></span>{{ $user->name }} </td>
                                            </tr>

                                            <tr>
                                                <th>Email</th>
                                                <td><span id=""></span>{{ $user->email }} </td>
                                            </tr>

                                            <tr>
                                                <th>Role</th>
                                                <td>
                                                    @if(!empty($user->getRoleNames()))
                                                        @foreach($user->getRoleNames() as $v)
                                                            <label class="badge badge-success">{{ $v }}</label>
                                                        @endforeach
                                                    @endif
                                                </td>
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


@endsection