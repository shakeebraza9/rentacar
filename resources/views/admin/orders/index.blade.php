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
        <h4 class="text-themecolor">ALL ORDERS LIST</h4>
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

<!-- Filter Section -->
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form id="filterForm" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="buyer_name" class="form-label">Buyer Name</label>
                            <input type="text" id="buyer_name" name="buyer_name" class="form-control" placeholder="Search by Buyer Name">
                        </div>
                        <div class="col-md-4">
                            <label for="payment_status" class="form-label">Payment Status</label>
                            <select id="payment_status" name="payment_status" class="form-control">
                                <option value="">Select Payment Status</option>
                                <option value="0">Unpaid</option>
                                <option value="1">Paid</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Order Status</label>
                            <select id="status" name="status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                    </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Page Start -->
<div class="row">
    <div class="col-sm-12">
        <section class="card">
            <header class="card-header" style="background-color: #6b0909">
                <h4 class="mb-0 text-white">All Order List</h4>
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
                                <th>Deposit Status</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
</div>
    @endsection
 @section('js')

       <script src="{{asset('public/admin/assets/node_modules/datatables.net/js/jquery.dataTables.min.js')}}"></script>
       <script src="{{asset('public/admin/assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js')}}"></script>



       <script>
        $(document).ready(function() {
            $(document).on('click', '.download-invoice', function() {
                var orderId = $(this).data('id'); // Get encrypted order ID
                var button = $(this); // Store button reference
                console.log('Downloading invoice for Order ID:', orderId);

                // Change button text & disable it (showing loader)
                button.html('<i class="spinner-border spinner-border-sm"></i> Downloading...').prop('disabled', true);

                // Delay to show loader before starting the download
                setTimeout(function() {
                    window.location.href = '/admin/orders/download-invoice/' + orderId;

                    // Reset button after download starts
                    setTimeout(function() {
                        button.html('<i class="bi bi-file-earmark-pdf"></i> Download Invoice').prop('disabled', false);
                    }, 5000); // Adjust delay if needed
                }, 1000);
            });
        });




        $(function () {
            var application_table = $('.mydatatable').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                fixedColumns: false,
                fixedHeader: false,
                scrollCollapse: false,
                scrollX: true,
                autoWidth: false,
                dom: 'lfrtip',
                lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
                ajax: {
                    url: "{{ URL::to('admin/orders/index') }}",
                    type: "GET",
                    data: function (d) {
                        d.buyer_name = $('#buyer_name').val();
                        d.payment_status = $('#payment_status').val();
                        d.status = $('#status').val();
                        d.date_range = $('#date_range').val();
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
                    { data: 'deposit_status', name: 'deposit_status' },
                    { data: 'amount', name: 'amount' },
                    { data: 'status', name: 'status' },
                ],
                initComplete: function () {
                    $('#buyer_name, #payment_status, #status, #date_range').on('change keyup', function () {
                        application_table.draw();
                    });

                    $('.js-switch').each(function () {
                        new Switchery($(this)[0], $(this).data());
                    });
                }
            });

            $('#searchButton').click(function () {
                application_table.draw();
            });

            $('#resetButton').click(function () {
                $('#buyer_name').val('');
                $('#payment_status').val('');
                $('#status').val('');
                $('#date_range').val('');
                application_table.draw();
            });

            // Delete Order
            $(document).on('click', '.delete-order', function () {
                let orderId = $(this).data('id');

                if (confirm('Are you sure you want to delete this order?')) {
                    $.ajax({
                        url: '/admin/orders/delete/' + orderId,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            alert(response.message);
                            application_table.draw(); // Reload DataTable after deletion
                        },
                        error: function (xhr) {
                            alert('Error deleting order.');
                        }
                    });
                }
            });
        });


    </script>
@endsection
