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

                                        <tr>
                                            <th>#</th>
                                            <th>Buyer Name</th>
                                            <th>Buyer Email</th>
                                            <th>Buyer Phone Number</th>
                                            <th>To Date</th>
                                            <th>From Date</th>
                                            <th>Payment Status</th>
                                            <th>Amount</th>
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

       <script src="{{asset('public/admin/assets/node_modules/datatables.net/js/jquery.dataTables.min.js')}}"></script>
       <script src="{{asset('public/admin/assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js')}}"></script>



       <script>
        $(function () {
            var application_table = $('.mydatatable').DataTable({
                processing: true,
                searching: true,
                fixedColumns: false,
                fixedHeader: false,
                scrollCollapse: false,
                scrollX: true,
                autoWidth: false,
                dom: 'lfrtip',
                serverSide: true,
                lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
                ajax: {
                    url: "{{ URL::to('admin/orders/index') }}",
                    type: "GET",
                    data: function (d) {
                        d.buyer_name = $('input[name=buyer_name]').val();
                        d.buyer_email = $('input[name=buyer_email]').val();
                        d.buyer_phone_number = $('input[name=buyer_phone_number]').val();
                        d.from_date = $('input[name=from_date]').val();
                        d.to_date = $('input[name=to_date]').val();
                        d.payment_status = $('select[name=payment_status]').val();
                        d.status = $('select[name=status]').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'buyer_name', name: 'buyer_name' },
                    { data: 'buyer_email', name: 'buyer_email' },
                    { data: 'buyer_phone_number', name: 'buyer_phone_number' },
                    { data: 'from_date', name: 'from_date' },
                    { data: 'to_date', name: 'to_date' },
                    { data: 'payment_status', name: 'payment_status' },
                    { data: 'amount', name: 'amount' },
                    { data: 'status', name: 'status' },
                ],
                initComplete: function () {
                    $('.js-switch').each(function () {
                        new Switchery($(this)[0], $(this).data());
                    });
                }
            });

            $("#searchButton").click(e => {
                application_table.draw();
            });

            $('.search_result').click(function () {
                application_table.draw();
            });
        });

    </script>
@endsection
