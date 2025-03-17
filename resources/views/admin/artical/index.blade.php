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
            <h4 class="text-themecolor">ALL ARTICLE LIST
            </h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Article</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- page start-->
                <div class="row">
                    <div class="col-sm-12">
                        <section class="card">
                            <header class="card-header" style="background-color: #6b0909; display: flex; justify-content: space-between; align-items: center;">
                                <h4 class="mb-0 text-white">All Article List</h4>
                                <a href="{{ route('artical.create') }}" class="btn btn-light">Create New</a>
                            </header>
                        <div class="card-body">
                          <div class="table-responsive m-t-40">
                            <table id="example23" class="mydatatable display nowrap table table-hover table-striped border" cellspacing="0" width="100%">
                                    <thead>
                                        <tr class="" >
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Action</th>
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
       <script src="{{asset('public/admin/assets/node_modules/datatables.net/js/jquery.dataTables.min.js')}}"></script>
       <script src="{{asset('public/admin/assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js')}}"></script>
       <script src="{{asset('public/admin/assets/node_modules/switchery/dist/switchery.min.js')}}"></script>


       <script>
        $(function () {
            var application_table = $('.mydatatable').DataTable({
                processing: true,
                "searching": true,
                fixedColumns: false,
                fixedHeader: false,
                scrollCollapse: false,
                scrollX: true,
                autoWidth: false,
                dom: 'lfrtip',
                serverSide: true,
                lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
                ajax: {
                    url: "{{URL::to('admin/artical/index')}}",
                    type: "GET",
                    data: function (d) { }
                },
                columns: [
                    { data: 0, name: 'id' },
                    { data: 1, name: 'name' },
                    { data: 2, name: 'action', orderable: false, searchable: false }
                ],
                initComplete: function () { }
            });

            application_table.on('draw', function () {
                $('.js-switch').each(function () {
                    new Switchery($(this)[0], $(this).data());
                });
            });

            // Search Functionality
            $("#searchButton").click(e => {
                application_table.search($('input[type=search]').val());
                application_table.draw();
            });

            // ✅ Handle FAQ Deletion
            $(document).on('click', '.delete-btn', function () {
                var faqId = $(this).data('id');

                if (confirm('Are you sure you want to delete this FAQ?')) {
                    $.ajax({
                        url: "{{ url('admin/artical/delete') }}/" + faqId,
                        type: 'DELETE',
                        data: { _token: "{{ csrf_token() }}" },
                        success: function (response) {
                            alert(response.success);
                            application_table.ajax.reload();
                        },
                        error: function () {
                            alert('Error deleting FAQ.');
                        }
                    });
                }
            });

        });

    </script>
@endsection
