@extends('layouts.admin')
@section('title', 'Admin Users List')
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

                        <h4 class=""><span class="float-left">Users List</span>
                            @can('add_users')
                            <span class="float-right mr-1"><a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add</a></span>
                            @endcan
                        </h4>

                    </div>

                    <div class="card-body account-setting-wrap">

                        <div class="col-12">

                            <div class="row">
                                <!-- Check All <input type="checkbox" class='checkall' id='checkall'><input type="button" id='delete_record' value='Delete' > -->

                                <div class="table-responsive listing-table">

                                    <table class="table table-bordered table-striped w-100" id="size_table">

                                        <thead>

                                            <tr>

                                                <th>Sr. No</th>

                                                <th>Name</th>

                                                <th>Email</th>

                                                <th>Users</th>

                                                <th>Action</th>

                                            </tr>

                                        </thead>

                                        <tbody>
                                            @if($data)
                                             @foreach ($data as $key => $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>@if(!empty($user->getRoleNames()))
                                                      @foreach($user->getRoleNames() as $v)
                                                         <label class="badge badge-success">{{ $v }}</label>
                                                      @endforeach
                                                    @endif
                                                  </td>
                                                <td>
                                                    <ul>
                                                        @can('edit_users')
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('admin.users.edit', \Illuminate\Support\Facades\Crypt::encrypt($user->id)) }}" class="info-btn"><i class="fa fa-edit"></i></a>
                                                        </li>
                                                        @endcan

                                                        @can('view_users')
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('admin.users.show', \Illuminate\Support\Facades\Crypt::encrypt($user->id)) }}" class="info-btn"><i class="fa fa-eye"></i></a>
                                                        </li>
                                                        @endcan

                                                        @can('delete_users')
                                                        <li class="list-inline-item">
                                                            {!! Form::open(['method' => 'DELETE','route' => ['admin.users.destroy', \Illuminate\Support\Facades\Crypt::encrypt($user->id)],'style'=>'display:inline']) !!}
                                                            <button class="info-btn"><i class="fa fa-trash"></i></button>
                                                            {!! Form::close() !!}
                                                        </li>
                                                        @endcan
                                                    </ul>
                                                    
                                                    
                                                    
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


    </div>

</section>

@endsection