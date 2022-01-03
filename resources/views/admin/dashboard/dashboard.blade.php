@extends('layouts.admin')
@section('title', 'Dashboard')

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




    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-3 col-6">
               
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{isset($students) && !empty($students) ? $students : 0}}</h3>
                            <p>Students</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>

                    </div>
                
            </div>

            <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{isset($batches) && !empty($batches) ? $batches : 0}}</h3>
                            <p>Batches</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>

                    </div>
           
            </div>

            <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{isset($duration) && !empty($duration) ? $duration : 0}}</h3>
                            <p>Duration</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
          
            </div>

            <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{isset($technology) && !empty($technology) ? $technology : 0}}</h3>
                            <p>Technology</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
          
            </div>

        </div>
    </div>
@stop

@section('scripts')

    <script>

        $(document).ready(function () {

        });

    </script>

@endsection

