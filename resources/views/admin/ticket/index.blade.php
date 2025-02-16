@extends('admin.layout')
@section('css')



<style>
table td {
    /* border: 1px solid lightgray; */
}

table th {
    /* border: 1px solid lightgray; */
}

@media (max-width: 767px) {

    .container-fluid,
    .container-sm,
    .container-md,
    .container-lg,
    .container-xl,
    .container-xxl {

        overflow: scroll !important;
    }
}


.dataTables_filter {
    display: none !important;
}
</style>
@endsection

@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">ALL TICKET LIST
        </h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Ticket</li>
            </ol>
        </div>
    </div>
</div>

<!-- page start-->
<div class="row">
    <div class="col-sm-12">
        <section class="card">
            <header class="card-header bg-info d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-white">All Ticket List</h4>
                <a href="{{ route('ticket.create') }}" class="btn btn-dark">Create New</a>
            </header>

            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="example23" class="mydatatable display nowrap table table-hover table-striped border" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="hidden-phone">Action</th>
                                <th>#</th>
                                <th>Attraction</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Discount Price</th>
                                <th>Status</th>
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



<script>
    $(function () {
        var application_table = $('.mydatatable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            scrollX: true,
            autoWidth: false,
            lengthMenu: [
                [10, 25, 50, 100, 500],
                [10, 25, 50, 100, 500]
            ],
            ajax: {
                url: @json(route('ticket.index')), // Laravel route
                type: "GET"
            },
            columns: [
                { data: 'action', name: 'action', orderable: false, searchable: false },
                { data: 'id', name: 'id' },
                { data: 'attraction', name: 'attraction' },
                { data: 'title', name: 'title' },
                { data: 'description', name: 'description' },
                { data: 'discount_price', name: 'discount_price' },
                { data: 'status', name: 'status', orderable: false, searchable: false }
            ]
        });

        // Delete button click handler
        $(".mydatatable").on("click", ".delete-button", function () {
            var ticketId = $(this).data("id"); // Get the ticket ID
            if (confirm("Are you sure you want to delete this ticket?")) {
                $.ajax({
                    url: '/admin/ticket/delete/' + ticketId, // Route to delete the ticket
                    type: "GET",
                    success: function (response) {
                        if (response.success) {
                            alert(response.message);
                            application_table.ajax.reload(); // Reload the DataTable
                        } else {
                            alert(response.message || "Failed to delete the ticket.");
                        }
                    },
                    error: function (xhr) {
                        alert("An error occurred while deleting the ticket.");
                    }
                });
            }
        });
    });

</script>
@endsection
