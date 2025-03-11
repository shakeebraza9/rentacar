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
            <h4 class="text-themecolor">ALL CAR TYPE LIST
            </h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Car type</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- page start-->
                <div class="row">
                    <div class="col-sm-12">
                        <section class="card">
                            <header class="card-header bg-info d-flex justify-content-between align-items-center">
                                <h4 class="mb-0 text-white">All Types List</h4>
                                <a href="{{ route('admin.cartype.create') }}" class="btn btn-light">Create</a>
                            </header>
                        <div class="card-body">
                          <div class="table-responsive m-t-40">
                            <table id="example23" class="mydatatable display nowrap table table-hover table-striped border" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Amount</th>
                                        <th class="hidden-phone">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
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

       <script src="{{asset('public/admin/assets/node_modules/datatables.net/js/jquery.dataTables.min.js')}}">
       </script>

       <script src="{{asset('public/admin/assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js')}}">
       </script>

       <script src="{{asset('public/admin/assets/node_modules/switchery/dist/switchery.min.js')}}"></script>

       <script>
        $(function () {
            var application_table = $('.mydatatable').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                fixedColumns: false,
                fixedHeader: false,
                scrollCollapse: false,
                scrollX: true,
                autoWidth: false,
                dom: 'lfrtip',
                lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
                ajax: {
                    url: "{{ URL::to('admin/cartype/index') }}",
                    type: "GET"
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { data: 'slug', name: 'slug' },
                    { data: 'amount', name: 'amount' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                initComplete: function () {
                    $('.js-switch').each(function () {
                        new Switchery($(this)[0], $(this).data());
                    });
                }
            });

            // Search Button Trigger
            $('#searchButton').click(function () {
                application_table.search($('input[type=search]').val()).draw();
            });

            // Reset Filters and Reload Table
            $('#resetButton').click(function () {
                $('input[type=search]').val('');
                application_table.search('').draw();
            });

            // Delete CarType via AJAX
            $(document).on('click', '.delete-cartype', function () {
                let cartypeId = $(this).data('id');

                if (confirm('Are you sure you want to delete this Car Type?')) {
                    $.ajax({
                        url: '/admin/cartype/delete/' + cartypeId,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            alert(response.message);
                            application_table.draw(); // Reload DataTable after deletion
                        },
                        error: function () {
                            alert('Error deleting Car Type.');
                        }
                    });
                }
            });
        });


    </script>
@endsection
