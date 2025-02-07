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
    

    .dataTables_filter{
        display: none!important;
    }


</style>
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">ALL ORDERS LIST 
            </h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Orders</li>
                </ol>
            </div>
        </div>
    </div>


    <!-- page start-->
                <div class="row">
                    <div class="col-sm-12">
                        <section class="card">
                            <header class="card-header bg-info">
                                <h4 class="mb-0 text-white" >All Order List</h4>
                            </header>
                        <div class="card-body">    
                          <div class="table-responsive m-t-40">
                            <table id="example23" class="mydatatable display nowrap table table-hover table-striped border" cellspacing="0" width="100%">
                                    <thead>
                                        <tr class="" >
                                            <th>
                                                <button type="button" class="search_result btn btn-primary"><i class="mdi mdi-magnify"></i>
                                                </button>
                                                <input style="width: 100px" 
                                                  placeholder="Order ID" 
                                                  class="form-control order_id" />
                                            </th>
                                            <th>
                                                <select style="width:100px" 
                                                  class="form-control order_status">
                                                    <option value="">Status</option>
                                                    <option value="1">Approve</option>
                                                    <option value="0">Pending</option>
                                                </select>
                                            </th>
                                            <th>
                                                <select style="width: 100px"  class="form-control payment_status">
                                                    <option value="">Payment</option>
                                                    <option value="1">Paid</option>
                                                    <option value="0">Unpaid</option>
                                                </select> 
                                            </th>
                                            <th>
                                                <input style="width: 150px" 
                                                  placeholder="Tracking ID" 
                                                  class="form-control tracking_id" />
                                            </th>
                                            <th>
                                                <input style="width: 100px" 
                                                  placeholder="Fullname" 
                                                  class="form-control fullname" />
                                            </th>
                                            <th>
                                                <input style="width: 100px" 
                                                  placeholder="Phone" 
                                                  class="form-control phone" />
                                            </th>
                                            <th>
                                                <select style="width: 150px"  
                                                class="payment_status form-control">
                                                <option value="">
                                                    Payment Method</option>
                                                    <option value="cash_on_delivery">
                                                        Cash On Delivery</option>
                                                </select>
                                            </th>
                                            <th>
                                                <input style="width: 100px" 
                                                  placeholder="Grand Total" 
                                                  class="form-control grand_total" />
                                            </th>       
                                        </tr>
                                        <tr class="" >
                                            <th>ID</th>
                                            <th>Status</th>
                                            <th>Payment</th>    
                                            <th>Tracking ID</th>   
                                            <th>Name</th> 
                                            <th>Phone</th>
                                            <th>Payment Method</th>
                                            <th>Grand Total</th>
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
                url: "{{URL::to('admin/orders/index')}}",
                type: "GET",
                data: function ( d ) {

                    d.id = $(".order_id").val();
                    d.order_status = $(".order_status").val();
                    d.payment_status = $(".payment_status").val();
                    d.tracking_id = $(".tracking_id").val();
                    d.fullname = $(".fullname").val();
                    d.phone = $(".phone").val();
                    d.payment_status = $(".payment_status").val();
                    d.grand_total = $('.grand_total').val();
                   
                    

                   
                }
            },
            initComplete: function () {     

                $('.js-switch').each(function () {
                   new Switchery($(this)[0], $(this).data());
                 }); 
            }
        });


        // $('input[type=search]').unbind();
        $("#searchButton").click(e =>{ 
            application_table.search($('input[type=search]').val());
            application_table.draw();
        });

   
        $('.search_result').click(function(){          
            application_table.draw();
        }); 


      });
    </script>
@endsection