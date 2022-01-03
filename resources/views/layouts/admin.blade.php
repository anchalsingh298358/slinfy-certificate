<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>

    <link href="{{ url('/public/both/bootstrap-4.0.0-dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <!-- <link rel="stylesheet" href="{{url('/public/admin/assets/plugins/dataTable/jquery.dataTables.css')}}"> -->

    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css"/>
    <!-- <link rel="stylesheet" href="{{url('/public/admin/assets/plugins/dataTable/dataTables.bootstrap.min.css')}}"> -->

    <!-- <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.bootstrap.min.css"> -->
    <link rel="stylesheet" href="{{url('/public/admin/assets/plugins/dataTable/fixedHeader.bootstrap.min.css')}}">

    <!-- <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap.min.css"> -->
    
    <link rel="stylesheet" href="{{url('/public/admin/assets/plugins/dataTable/responsive.bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{url('/public/admin/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{url('public/admin/assets/plugins/fontawesome-free/css/all.min.css')}}">

    <link rel="stylesheet" href="{{url('public/admin/assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{url('public/admin/assets/plugins/bootstrap-mutliselect/css/bootstrap-multiselect.css')}}">
    

    <link rel="stylesheet"
          href="{{url('public/admin/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}">

    <link rel="stylesheet" href="{{url('public/admin/assets/css/adminlte.min.css')}}">

    <link rel="stylesheet" href="{{url('public/admin/assets/css/custom.css')}}">


    @yield('style')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-light">

        <ul class="navbar-nav">

            <li class="nav-item">

                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>

            </li>

        </ul>


        <ul class="navbar-nav ml-auto">


            <div class="user-area dropdown float-right">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"

                   aria-expanded="false">

                    <span>{{Auth::user()->name}}</span>

                </a>


                <div class="user-menu dropdown-menu">

                    <a class="nav-link" href="{{ route('admin.account.create') }}">My Account</a>

                    <a class="nav-link" href="{{ route('logout') }}"

                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">

                        @csrf

                    </form>

                </div>

            </div>

        </ul>

    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{url('/admin/dashboard')}}" class="brand-link text-center">
            <img src="{{ url('/public/admin/login/img/logo.png') }}" alt="AdminLTE Logo" class="img-responsive"
                 height="">
        </a>

        <div class="sidebar">        
            @include('includes.admin.sidebar')
        </div>
    </aside>

    <div class="content-wrapper">
        @yield('breadcrum')
        <section class="content">
            @yield('content')
        </section>
    </div>

    <footer class="main-footer">
        <strong>Copyright &copy; 2021 </strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">

        </div>
    </footer>


    <aside class="control-sidebar control-sidebar-dark">

    </aside>
</div>

<script>
    var BASE_URL = "<?php echo url('/'); ?>";
</script>



<script src="{{url('/public/admin/assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<!-- <script>jQuery.noConflict();</script> -->
{{--<!-- <script src="{{ url('/public/both/jquery.min.js') }}"></script> -->--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="{{ url('/public/both/bootstrap-4.0.0-dist/js/bootstrap.min.js') }}"></script>
<script src="{{ url('/public/both/jquery.validate.min.js') }}"></script>

<!-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> -->
<script src="{{url('/public/admin/assets/plugins/dataTable/jquery.dataTables.min.js')}}"></script>

<!-- <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script> -->
<script src="{{url('/public/admin/assets/plugins/dataTable/dataTables.buttons.min.js')}}"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> -->
<script src="{{url('/public/admin/assets/plugins/dataTable/jszip.min.js')}}"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> -->
<script src="{{url('/public/admin/assets/plugins/dataTable/pdfmake.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="{{url('/public/admin/assets/plugins/dataTable/vfs_fonts.js')}}"></script>


<!-- <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script> -->
<script src="{{url('/public/admin/assets/plugins/dataTable/buttons.html5.min.js')}}"></script>


<!-- <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script> -->
<script src="{{url('/public/admin/assets/plugins/dataTable/buttons.print.min.js')}}"></script>

<!-- <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script> -->
<script src="{{url('/public/admin/assets/plugins/dataTable/dataTables.select.min.js')}}"></script>


<!-- <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script> -->
<script src="{{url('/public/admin/assets/plugins/dataTable/dataTables.responsive.min.js')}}"></script>


<!-- <script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap.min.js"></script> -->
<script src="{{url('/public/admin/assets/plugins/dataTable/responsive.bootstrap.min.js')}}"></script>

<!-- <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> -->
<script src="{{url('/public/admin/assets/plugins/dataTable/dataTables.bootstrap4.min.js')}}"></script>

<!-- <script>
  $.widget.bridge('uibutton', $.ui.button)
</script> -->
<script src="{{url('public/admin/assets/js/adminlte.js')}}"></script>
<!-- <script src="{{url('public/admin/assets/js/pages/dashboard.js')}}"></script> -->
<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
<script src="{{ url('public/admin/assets/js/demo.js')}}"></script>
<script src="{{ url('/public/admin/assets/plugins/select2/js/select2.min.js') }}"></script>

<script src="{{ url('/public/admin/assets/plugins/bootstrap-mutliselect/js/bootstrap-multiselect.js') }}"></script>

<script src="{{ url('/public/admin/assets/plugins/sweet_alert/sweetalert.min.js') }}"></script>
<script
    src="{{ url('/public/admin/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ url('public/admin/assets/js/scripts.js') }}"></script>
<script src="{{ url('public/admin/assets/js/datatable-listing.js') }}"></script>

<script type="text/javascript">
        $(document).ready(function(){
            <?php if (\Session::has('success')){ ?>
                toastr.success("{{ \Session::get('success') }}", "Success");
            <?php
                }elseif (\Session::has('error')) {
            ?>
                toastr.error("{{ \Session::get('error') }}", "Error");
            <?php
                }elseif (\Session::has('warning')) {
            ?>
                toastr.warning("{{ \Session::get('warning') }}", "Warning");
            <?php }elseif (\Session::has('info')) { ?>
                toastr.info("{{ \Session::get('info') }}", "Info");
            <?php } ?>
        });
        
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

        toastr.options = {
            "preventDuplicates": true
        }
</script>

@yield('scripts')

<script>

</script>

</body>
</html>
