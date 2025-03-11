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
            <h4 class="text-themecolor">ALL REVIEW LIST
            </h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Review</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- page start-->
                <div class="row">
                    <div class="col-sm-12">
                        <section class="card">
                            <header class="card-header d-flex justify-content-between align-items-center" style="background-color: #6b0909">
                                <h4 class="mb-0 text-white">All Review List</h4>

                                <div>
                                    <!-- Add Button -->
                                    <a href="{{ route('createadminreview') }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-plus"></i> Add Review
                                    </a>

                                    <!-- Sort Button -->
                                    <a class="btn btn-primary btn-sm" id="sortButton" href="{{ route('review_sort') }}">
                                        <i class="fas fa-sort"></i> Sort
                                    </a>
                                </div>
                            </header>

                        <div class="card-body">
                          <div class="table-responsive m-t-40">
                            <table id="example23" class="mydatatable display nowrap table table-hover table-striped border" cellspacing="0" width="100%">
                                    <thead>
                                        <tr class="" >
                                            <th>Action</th>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Product</th>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Review</th>
                                            <th>Status</th>
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
            // scrollY: '500px',
            autoWidth: false,
            dom: 'lfrtip',
            serverSide: true,
            lengthMenu: [[10,25, 50, 100,500],[10,25, 50, 100,500]],
            ajax: {
                url: "{{URL::to('admin/review/index')}}",
                type: "GET",
                data: function ( d ) {

                }
            },
            initComplete: function () {
                // $('.js-switch').each(function () {
                //    new Switchery($(this)[0], $(this).data());
                //  });
            }
        });

        application_table.on( 'draw', function () {
            $('.js-switch').each(function () {
               new Switchery($(this)[0], $(this).data());
            });
        } );



        // $('input[type=search]').unbind();
        $("#searchButton").click(e =>{
            application_table.search($('input[type=search]').val());
            application_table.draw();
        });

        $(document).on('click', '.delete-review', function () {
            var reviewId = $(this).data('id'); // Get Encrypted ID
            var url = "{{ route('admin.review.destroy', ':id') }}".replace(':id', reviewId);

            if (confirm("Are you sure you want to delete this review?")) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            alert(response.message);
                            $('.mydatatable').DataTable().ajax.reload();
                        } else {
                            alert("Error deleting review.");
                        }
                    },
                    error: function () {
                        alert("Something went wrong!");
                    }
                });
            }
        });


      });
    </script>
@endsection
