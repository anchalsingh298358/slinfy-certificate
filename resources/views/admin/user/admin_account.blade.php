@extends('layouts.admin')
@section('title', 'Admin Profile')
@section('content')
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <!-- <h1 class="m-0 text-dark">Add</h1> -->
         </div>
         <div class="col-sm-6">
            {{--
            <ol class="breadcrumb float-sm-right">
               --}}
               {{--
               <li class="breadcrumb-item"><a href="{{url('/admin')}}">Home</a></li>
               --}}
               {{--
               <li class="breadcrumb-item active">Admin Profile</li>
               --}}
               {{--
            </ol>
            --}}
         </div>
      </div>
   </div>
</div>
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <!-- @include('validation_message.validation_message') -->
         <div class="col-sm-12">
            <div class="card bg-white user-detail-wrap">
               <div class="card-header  bg-white">
                  <h4 class="float-left">Admin Profile</h4>
               </div>
               <div class="card-body account-setting-wrap">
                  <div class="container h-100">
                     <div class="row h-100 justify-content-center align-items-center">
                        <!-- {!! Form::model(Auth::user(), ['method' => 'PATCH','route' => ['admin.account.update', Auth::user()->id] , 'files' => true, 'class' => 'col-md-12', 'id' => 'admin-form']) !!} -->

                        <form method="post" action="{{ route('admin.account.update', Auth::user()->id) }}" class="col-sm-12">
                           @method('patch')
                           {{csrf_field()}}
                           <!-- {{csrf_field()}} -->
                           <input type="hidden" name="" value="{{ Auth::user()->id}}">
                           <div class="row">
                              <div class="col-12 col-sm-6 col-md-6 col-lg-3 mt-3">
                                 <div class="form-group material-behaviour">
                                    <label class="movelabel" for="">Name</label>
                                    <input class="form-control" type="text" name="name" value="{{ Auth::user()->name }}" required="">
                                 </div>
                              </div>
                              
                              <div class="col-12 col-sm-6 col-md-6 col-lg-3 mt-3">
                                 <div class="form-group material-behaviour">
                                    <label class="movelabel" for="">Email</label>
                                    <input class="form-control" type="text" name="email" value="{{ Auth::user()->email}}" disabled="">
                                 </div>
                              </div>
                              <div class="col-12 col-sm-6 col-md-6 col-lg-3 mt-3">
                                 <div class="form-group mt-2">
                                    <label class="movelabel" for=""></label><br>
                                    <input type="submit" class="btn btn-primary login_btn" name="" value="Update" >
                                 </div>
                              </div>
                           </div>
                        </form>
                        <!-- {!! Form::close() !!} -->
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-sm-12">
            <div class="card bg-white user-detail-wrap">
               <div class="card-header  bg-white">
                  <h4 class="float-left">Change Password</h4>
               </div>
               <div class="card-body account-setting-wrap">
                  <div class="container h-100">
                     <div class="row h-100 justify-content-center align-items-center">
                        <form method="post" action="{{ route('admin.account.update.password') }}" class="col-sm-12">
                           @method('post')
                           {{csrf_field()}}
                           <input type="hidden" name="" value="{{ Auth::user()->id}}">
                           <div class="row">
                              <div class="col-12 col-sm-6 col-md-6 col-lg-3 mt-3">
                                 <div class="form-group material-behaviour">
                                    <label class="movelabel" for="">Old Password</label>
                                    <input class="form-control" type="password" name="old_password" value="" required="">
                                 </div>
                              </div>
                              <div class="col-12 col-sm-6 col-md-6 col-lg-3 mt-3">
                                 <div class="form-group material-behaviour">
                                    <label class="movelabel" for="">New Password</label>
                                    <input class="form-control" type="password" name="new_password" value="" required="">
                                 </div>
                              </div>
                              <div class="col-12 col-sm-6 col-md-6 col-lg-3 mt-3">
                                 <div class="form-group material-behaviour">
                                    <label class="movelabel" for="">Confirm Password</label>
                                    <input class="form-control" type="password" name="confirm_password" >
                                 </div>
                              </div>
                              <div class="col-12 col-sm-6 col-md-6 col-lg-3 mt-3">
                                 <div class="form-group mt-2">
                                    <label class="movelabel" for=""></label><br>
                                    <input type="submit" class="btn btn-primary login_btn" name="" value="Update" >
                                 </div>
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