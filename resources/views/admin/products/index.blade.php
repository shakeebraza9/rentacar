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
    

    .dataTables_filter{
        display: none!important;
    }


</style>
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">ALL PRODUCTS LIST 
            </h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Products</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- page start-->
                <div class="row">
                    <div class="col-sm-12">
                        <section class="card">
                            <header class="card-header bg-info">
                                <h4 class="mb-0 text-white" >All Products List</h4>
                            </header>
                        <div class="card-body">    
                          <div class="table-responsive m-t-40">
                            <table id="example23" class="mydatatable display nowrap table table-hover table-striped border" cellspacing="0" width="100%">
                                    <thead>
                                        <tr class="" >
                                            <th>
                                                <button type="button" class="search_result btn btn-primary" >
                                                    <i class="mdi mdi-magnify"></i>
                                                </button>
                                            </th>
                                            <th></th>
                                            
                                            <th>
                                               
                                                <select style="width: 200px" class="form-control category">
                                                    <option value="">Select Category</option>
                                                    {!!$categoryDropdown!!}
                                                </select>
                                            </th>
                                            <th></th>
                                            <th>
                                                <input type="text" placeholder="Title" class="form-control title "/>
                                            </th>
                                            <th>
                                                <input type="text" placeholder="Slug" class="form-control slug"/>
                                            </th>
                                            <th>
                                                <input style="width: 100px"  type="text" placeholder="Price" class="form-control price"/>
                                            </th>
                                           
                                            <th>
                                                <select style="width: 100px"  class="form-control is_enable">
                                                    <option value="">Select Status</option>
                                                    <option value="1">Approve</option>
                                                    <option value="0">Pending</option>
                                                </select>
                                            </th>
                                            <th>
                                                <select style="width: 100px"  class="form-control is_featured ">
                                                    <option value="">Select Featured</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select> 
                                            </th>
                                            
                                        </tr>
                                        <tr class="" >
                                            <th class="hidden-phone">Action</th>
                                            <th>#</th>
                                            
                                            <th>Category</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Slug</th>
                                            <th>Price</th>
                                            <th>Status </th>
                                            <th>Featured </th>
                                            
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
                url: "{{URL::to('admin/products/index')}}",
                type: "GET",
                data: function ( d ) {

                    d.category_id = $('.category').val();
                    d.title = $('.title').val();
                    d.slug = $('.slug').val();
                    d.price = $('.price').val();
                    d.is_enable = $('.is_enable').val();
                    d.is_featured = $('.is_featured').val();
       
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

   
        $(".mydatatable").delegate(".is_enable", "change", function(){
            var isChecked = $(this).prop('checked');
            $.ajax({
                url: "{{URL::to('/admin/status')}}",
                data: {
                    id:$(this).data('id'),
                    table:'products',
                    column:'is_enable',
                    value: $(this).prop('checked') ? 1: 0,
                },
                dataType: "json",
                success: function (response) {
                    
                },
                errror:function (response) {
                    
                },
            });
            console.log(isChecked);
        });


        $(".mydatatable").delegate(".is_featured", "change", function(){
            var isChecked = $(this).prop('checked');
            $.ajax({
                url: "{{URL::to('/admin/status')}}",
                data: {
                    id:$(this).data('id'),
                    table:'products',
                    column:'is_featured',
                    value: $(this).prop('checked') ? 1: 0,
                },
                dataType: "json",
                success: function (response) {
                    
                },
                errror:function (response) {
                    
                },
            });
            console.log(isChecked);
        });


        $('.search_result').click(function(){          
           
            // users_table.search($('input[type=search]').val());
            application_table.draw();
        }); 




      });
    </script>
@endsection