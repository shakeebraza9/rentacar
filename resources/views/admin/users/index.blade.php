@extends('admin.layout')
@section('css')

<link rel="stylesheet" type="text/css"
href="{{asset('public/admin/assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" type="text/css"
href="{{asset('public/admin/assets/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css')}}">


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
            <h4 class="text-themecolor">ALL USERS LIST 
            </h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- page start-->
                <div class="row">
                    <div class="col-sm-12">
                        <section class="card">
                            <header class="card-header bg-info">
                                <h4 class="mb-0 text-white" >All Users List</h4>
                            </header>
                        <div class="card-body">    
                          {{-- <div class="table-responsive m-t-40"> --}}
                            <table id="example23" class="mydatatable display nowrap table table-hover table-striped border" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>
                                                <input class="username form-control" placeholder="Username"/>
                                            </th>
                                            <th>
                                                <input class="email form-control" placeholder="Email"/>
                                            </th>
                                            <th>
                                                <select class="role_id form-control" >
                                                    <option value="">Search By Roles</option>
                                                    @foreach ($roles as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </th>
                                            <th colspan="3" 
                                             title="{{__('action')}}" 
                                             style = "background:white;">
                                                <div class="restore_list">
                                                    <button id="searchButton" type="button" class="btn btn-sm btn-success search_list"><i class="fa fa-search"></i>
                                                    </button>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr class="" >
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th class="hidden-phone">Action</th>
                                        </tr>
                                     </thead>
                                    <tbody>
                             </tbody>
                        </table>
                    {{-- </div> --}}


              </div>
           </div>
          </section>
         </div>
       
  @endsection

 @section('js')

       <!-- This is data table -->
       <script src="{{asset('public/admin/assets/node_modules/datatables.net/js/jquery.dataTables.min.js')}}"></script>
       <script src="{{asset('public/admin/assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js')}}"></script>
    

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
                url: "{{URL::to('admin/users/index')}}",
                type: "GET",
                data: function ( d ) {

                        d.username = $('.mydatatable .username').val();
                        d.email=$('.mydatatable .email').val();
                        d.role_id=$('.mydatatable .role_id').val();
       
                }
            },
            columns: [
                { 
                  orderable: false, 
                  searchable: false 
                },
                {  
                   orderable: true, 
                   searchable: true  
                },

                {
                   orderable: true, 
                   searchable: true  
                },
                {
                   orderable: true, 
                   searchable: true  
                },
                { 
                  orderable: false, 
                  searchable: false 
                },
                
            ],
            initComplete: function () {                
            }
        });

        $('input[type=search]').unbind();
        $("#searchButton").click(e =>{ 
            application_table.search($('input[type=search]').val());
            application_table.draw();
        });

        $("#example23 thead .row-checkbox").change(function (e) { 
            var isChecked = $(this).prop('checked');
            $('#example23 tbody .row-checkbox').prop('checked', isChecked);
        });


      });
    </script>
@endsection