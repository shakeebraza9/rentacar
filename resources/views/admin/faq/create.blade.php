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
            <h4 class="text-themecolor">Create  FAQ
            </h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Faq</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4>Create FAQ</h4>
            </div>
            <div class="card-body">
                <form id="faqForm">
                    @csrf

                    <div id="error-messages" class="alert alert-danger d-none"></div>

                    <div class="mb-3">
                        <label for="name" class="form-label">FAQ Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <span class="text-danger error-text name_error"></span>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        <span class="text-danger error-text description_error"></span>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="car">Car</option>
                            <option value="attraction">Attraction</option>
                        </select>
                        <span class="text-danger error-text type_error"></span>
                    </div>

                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('faq.index') }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
      </div>

@endsection
 @section('js')
<script>
    $(document).ready(function () {
        $('#faqForm').submit(function (e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $('.error-text').text(''); // Clear previous errors
            $('#error-messages').addClass('d-none').html('');

            $.ajax({
                url: "{{ route('faq.store') }}",
                type: "POST",
                data: formData,
                success: function (response) {
                    alert(response.success);
                    window.location.href = "{{ route('faq.index') }}";
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = "<ul>";

                        $.each(errors, function (key, value) {
                            errorMessage += "<li>" + value[0] + "</li>";
                            $('.' + key + '_error').text(value[0]);
                        });

                        errorMessage += "</ul>";
                        $('#error-messages').removeClass('d-none').html(errorMessage);
                    }
                }
            });
        });
    });
</script>

@endsection
