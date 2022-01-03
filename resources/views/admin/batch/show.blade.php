@extends('layouts.admin')

@section('title', 'Batch Detail')

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

                    {{--<li class="breadcrumb-item active">Edit Batch-</li>--}}

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

                            <h4 class="float-left">Batch Detail </h4>

                        </div>

                        <div class="card-body account-setting-wrap">

                            <div class="container h-100">

                                <div class="row h-100 justify-content-center align-items-center">

                                    <table class="table table-striped">
                                    <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <td><span id=""></span>{{ $batch->name }} </td>
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
