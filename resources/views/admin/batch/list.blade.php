@extends('layouts.admin')

@section('title', 'Batch List')

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

						<h4 class=""><span class="float-left">Batch List</span> <span class="float-right mr-1"><a href="{{ route('admin.batches.create') }}" class="btn btn-primary">Add</a></span></h4>

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

                                            <th>Action</th>

                                        </tr>

                                        </thead>                                    

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


@stop

@section('scripts')

    <script>

        jQuery(document).ready(function () {        

            jQuery('#size_table').DataTable({                
                "responsive": true,
                "processing": true,
                "serverSide": true,  
                "ajax": {
                   "url": "{{ Route('admin.batches.list.json') }}",
                },
                "columns":[
                    { "data": "sr_no" },
                    { "data": "name" },
                    { "data": "action" },                    
                ],

                "columnDefs":
                [
                    {
                        "targets": 2,
                        render: function (data, type, row, meta) {

                            var status = row['status'] == 1 ? "checked" : "";

                            html = `<ul class="p-0">`;
                                        if (row.can_edit_batches) {
                                        html += `<li class="list-inline-item">`+

                                            `<a href="`+row.edit+`"`+

                                            `class="info-btn">`+

                                            `<i class="fa fa-edit"></i>`+

                                            `</a>`+

                                        `</li>`;
                                        }

                                        if (row.can_view_batches) {
                                        html += `<li class="list-inline-item">`+

                                            `<a href="`+row.show+`"`+

                                            `class="info-btn">`+

                                            `<i class="fa fa-eye"></i>`+

                                            `</a>`+

                                        `</li>`;
                                        }

                                        if (row.can_delete_batches) {
                                        html += `<li class="list-inline-item">

                                            <a class="delete-data info-btn" href="javascript:void(0);"

                                               data-url="`+row.delete+`"

                                               data-title="Are you sure?"

                                               data-body="Batch will be deleted!"

                                               data-icon="" data-success="Batch successfully deleted!"

                                               data-cancel="Batch is safe!"

                                               title="Delete"><i class="fa fa-trash"></i>

                                            </a>

                                        </li>`;
                                        }
                                        
                                        
                                        if (row.can_update_status) {
                                        html += `<li class="list-inline-item">

                                            <div style="position: relative;" data-table=""

                                                data-id="`+row.id+`"

                                                data-status=" `+row.status+`"

                                                class="switch update_status "

                                                data-url="`+row.update_status+`"

                                                data-title="Are you sure to change status?" data-icon=""

                                                data-success="Batch status successfully updated!"

                                                data-cancel="Batch status did not changed!" title="Update">

                                            <label>

                                            <input class="status" id="togle-`+row.id+`" `+status+` type="checkbox">

                                            <span class="lever slider round"></span>

                                            </label>

                                            </div>

                                        </li> ` ;
                                        }
                                       


                            return html + `</ul>`;
                        }
                    }                
                ],
                "dom": 'lBfrtip',
                "buttons": [        
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 0, 1, 2],
                        },
                    },

                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 0, 1, 2],
                            alignment: 'center',
                        },
                    },

                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [ 0, 1, 2]
                        }
                    },       
                ],
                "lengthMenu": [
                  [10, 25, 50, 100, -1],
                  [10, 25, 50, 100, "All"]
                ],
                "sPaginationType" : "full_numbers",                
            });

        });

    </script>

@endsection
