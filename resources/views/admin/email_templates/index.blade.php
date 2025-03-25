@extends('admin.layout')
@section('css')

<link rel="stylesheet" type="text/css"
href="{{asset('public/admin/assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" type="text/css"
href="{{asset('public/admin/assets/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css')}}">
<link href="{{asset('public/admin/assets/node_modules/switchery/dist/switchery.min.css')}}" rel="stylesheet" type="text/css" />

<style>

    table td{
        /* border: 1px solid lightgray; */
    }

    table th{
        /* border: 1px solid lightgray; */
    }

    @media (max-width: 767px){
        .container-fluid, .container-sm, .container-md, .container-lg, .container-xl, .container-xxl {
            overflow: scroll!important;
        }
    }

</style>
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">ALL EMAIL LIST
            </h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Email setting</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- page start-->
                <div class="row">
                    <div class="col-sm-12">
                        <section class="card">
                            <header class="card-header d-flex justify-content-between align-items-center" style="background-color: #6b0909">
                                <h4 class="mb-0 text-white">All Email List</h4>


                            </header>

                        <div class="card-body">
                          <div class="table-responsive m-t-40">
                            <table id="emailTable" class="display nowrap table table-hover table-striped border" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Subject</th>
                                        <th>Last Updated</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                    </div>
                    </div>
                </div>
           </section>
        </div>
      </div>

@endsection
 @section('js')


       <!-- This is data table -->
       <script src="{{asset('public/admin/assets/node_modules/datatables.net/js/jquery.dataTables.min.js')}}"></script>
       <script src="{{asset('public/admin/assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js')}}"></script>
       <script src="{{asset('public/admin/assets/node_modules/switchery/dist/switchery.min.js')}}"></script>


       <script>
        $(document).ready(function () {
            var emailTable = $('#emailTable').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                scrollX: true,
                autoWidth: false,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                ajax: {
                    url: "{{ route('admin.email.index') }}",
                    type: "GET"
                },
                columns: [
                    { data: "action", orderable: false, searchable: false },
                    { data: "id" },
                    { data: "name" },
                    { data: "subject" },
                    { data: "updated_at" }
                ]
            });

            // Custom Search Function
            $("#searchButton").click(function () {
                var searchValue = $("#searchInput").val();
                emailTable.search(searchValue).draw();
            });
        });

    </script>
@endsection
