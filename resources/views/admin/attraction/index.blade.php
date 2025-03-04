@extends('admin.layout')
@section('css')



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


    .dataTables_filter{
        display: none!important;
    }


</style>
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">ALL Attractions LIST
            </h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Attractions</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- page start-->
                <div class="row">
                    <div class="col-sm-12" >
                        <section class="card">
                            <header class="card-header d-flex justify-content-between align-items-center" style="background-color: #6b0909">
                                <h4 class="mb-0 text-white">All Attractions List</h4>
                                <a href="{{ route('attractions.create') }}" class="btn bg-info">Create New</a>
                            </header>

                        <div class="card-body">
                          <div class="table-responsive m-t-40">
                            <table id="example23" class="mydatatable display nowrap table table-hover table-striped border" cellspacing="0" width="100%">
                                    <thead>

                                        <tr class="" >
                                            <th class="hidden-phone">Action</th>
                                            <th>#</th>


                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Slug</th>
                                            <th>Price</th>
                                            <th>Status </th>


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



       <script>
        $(function () {
            var application_table = $('.mydatatable').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                scrollX: true,
                autoWidth: false,
                lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
                ajax: {
                    url: @json(route('attractions.index')), // Laravel route
                    type: "GET",
                    data: function (d) {
                        d.category_id = $('.category').val(); // Category filter
                        d.title = $('.title').val();         // Title filter
                        d.slug = $('.slug').val();           // Slug filter
                        d.selling_price = $('.price').val(); // Price filter
                        d.is_enable = $('.is_enable').val(); // Status filter
                        d.is_featured = $('.is_featured').val(); // Featured filter
                    },
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                    }
                },
                columns: [
                    { data: 0, name: 'action', orderable: false, searchable: false }, // Action column
                    { data: 1, name: 'id' },                                          // ID column
                    { data: 2, name: 'image', orderable: false, searchable: false },  // Image column
                    { data: 3, name: 'title' },                                       // Title column
                    { data: 4, name: 'slug' },                                        // Slug column
                    { data: 5, name: 'selling_price' },                               // Price column
                    { data: 6, name: 'status', orderable: false, searchable: false }, // Status column
                ]
            });

            // Trigger DataTable reload on filter change
            $('.search_result').click(function () {
                application_table.draw();
            });

            // Status toggle
            $(".mydatatable").delegate(".is_enable", "change", function () {
                $.ajax({
                    url: @json(url('/admin/status')),
                    type: "POST",
                    data: {
                        id: $(this).data('id'),
                        table: 'products',
                        column: 'is_enable',
                        value: $(this).prop('checked') ? 1 : 0,
                    },
                    success: function () {
                        console.log("Status updated successfully.");
                    },
                    error: function () {
                        console.error("Error updating status.");
                    }
                });
            });
        });

    </script>
@endsection
