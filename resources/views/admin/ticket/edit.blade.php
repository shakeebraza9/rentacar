@extends('admin.layout')
@section('css')
<link href="{{asset('admin/assets/node_modules/switchery/dist/switchery.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin/assets/node_modules/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<style>

    .invalid-feedback{
      display: block;
   }

   .form-group {
    margin-bottom: 10px;
   }


   .ck-editor__editable_inline {
    min-height: 200px;
   }



   .gallery-box{

   }

   .select2-container{
    width: 100%!important;
   }

   .select2-dropdown {
    z-index: 1124!important;
   }

</style>
<?php
// dd()
?>
<link href="{{asset('admin/assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" />
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<link href="{{asset('admin/assets/css/pages/user-card.css')}}" rel="stylesheet">
<link href="{{asset('admin/assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">ADD YOUR TICKET
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


<div class="row">
    <div class="col-md-12">
        <section class="card">

            <div class="card-body">
                <form method="post" action="{{ route('ticket.update', Crypt::encryptString($ticket->id)) }}">
                    @csrf


                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <div class="row">
                        <div class="col-md-12">
                            <section class="card">
                                <header class="card-header" style="background-color: #6b0909">
                                    <h4 class="mb-0 text-white">Edit Ticket Details</h4>
                                </header>
                                <div class="card-body">
                                    <!-- Select Attraction -->
                                    <div class="form-group row">
                                        <label for="attraction" class="col-md-2 col-form-label">Select Attraction</label>
                                        <div class="col-md-10">
                                            <select id="attraction" name="attraction_id" class="form-control">
                                                @foreach($attractions as $attraction)
                                                    <option value="{{ $attraction->id }}"
                                                        {{ old('attraction_id', $ticket->attraction_id) == $attraction->id ? 'selected' : '' }}>
                                                        {{ $attraction->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Title -->
                                    <div class="form-group row">
                                        <label for="title" class="col-md-2 col-form-label">Title</label>
                                        <div class="col-md-10">
                                            <input type="text" id="title" name="title" class="form-control"
                                                placeholder="Enter Title"
                                                value="{{ old('title', $ticket->title) }}">
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group row">
                                        <label for="description" class="col-md-2 col-form-label">Description</label>
                                        <div class="col-md-10">
                                            <textarea id="description" name="description" class="form-control" rows="4"
                                                placeholder="Enter Description">{{ old('description', $ticket->description) }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Prices -->
                                    <div class="form-group row">
                                        <label for="discount_price" class="col-md-2 col-form-label">Discount Price</label>
                                        <div class="col-md-4">
                                            <input type="number" id="discount_price" name="discount_price" class="form-control"
                                                placeholder="Enter Discount Price"
                                                value="{{ old('discount_price', $ticket->discount_price) }}">
                                        </div>
                                        <label for="selling_price" class="col-md-2 col-form-label">Selling Price</label>
                                        <div class="col-md-4">
                                            <input type="number" id="selling_price" name="selling_price" class="form-control"
                                                placeholder="Enter Selling Price"
                                                value="{{ old('selling_price', $ticket->selling_price) }}">
                                        </div>
                                    </div>

                                    <!-- Ticket Quantity -->
                                    <div class="form-group row">
                                        <label for="ticket_quantity" class="col-md-2 col-form-label">Ticket Quantity</label>
                                        <div class="col-md-10">
                                            <input type="number" id="ticket_quantity" name="ticket_quantity" class="form-control"
                                                placeholder="Enter Ticket Quantity"
                                                value="{{ old('ticket_quantity', $ticket->ticket_quantity) }}">
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>


                    <div class="card shadow-lg border-0 rounded-3 mt-4">
                        <div class="card-header bg-primary text-white text-center">
                            <h5 class="mb-0">Variations</h5>
                        </div>
                        <div class="card-body">
                            <!-- Children Variation -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label>Children Quantity</label>
                                    <input type="number" name="child_quantity" class="form-control"
                                        value="{{ old('child_quantity', optional($ticket->variations->where('type', 'child')->first())->quantity ?? 1) }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Children Price</label>
                                    <input type="text" name="child_price" class="form-control"
                                        value="{{ old('child_price', optional($ticket->variations->where('type', 'child')->first())->price ?? 0) }}">
                                </div>
                                <div class="col-md-3">
                                    <label>From Date</label>
                                    <input type="date" name="child_from_date" class="form-control"
                                        value="{{ old('child_from_date', optional($ticket->variations->where('type', 'child')->first())->from_date ?? now()->format('Y-m-d')) }}">
                                </div>
                                <div class="col-md-3">
                                    <label>To Date</label>
                                    <input type="date" name="child_to_date" class="form-control"
                                        value="{{ old('child_to_date', optional($ticket->variations->where('type', 'child')->first())->to_date ?? now()->addDay()->format('Y-m-d')) }}">
                                </div>
                            </div>

                            <!-- Adult Variation -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label>Adult Quantity</label>
                                    <input type="number" name="adult_quantity" class="form-control"
                                        value="{{ old('adult_quantity', optional($ticket->variations->where('type', 'adult')->first())->quantity ?? 1) }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Adult Price</label>
                                    <input type="text" name="adult_price" class="form-control"
                                        value="{{ old('adult_price', optional($ticket->variations->where('type', 'adult')->first())->price ?? 0) }}">
                                </div>
                                <div class="col-md-3">
                                    <label>From Date</label>
                                    <input type="date" name="adult_from_date" class="form-control"
                                        value="{{ old('adult_from_date', optional($ticket->variations->where('type', 'adult')->first())->from_date ?? now()->format('Y-m-d')) }}">
                                </div>
                                <div class="col-md-3">
                                    <label>To Date</label>
                                    <input type="date" name="adult_to_date" class="form-control"
                                        value="{{ old('adult_to_date', optional($ticket->variations->where('type', 'adult')->first())->to_date ?? now()->addDay()->format('Y-m-d')) }}">
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Add-ons Section -->
                    <div class="card shadow-lg border-0 rounded-3 mt-4">
                        <div class="card-header text-white text-center" style="background-color: #6b0909">
                            <h5 class="mb-0">Add-ons</h5>
                        </div>
                        <div class="card-body">
                            <div id="addons-container">
                                @foreach(json_decode($ticket->add_ons, true) ?? [] as $index => $addon)
                                    <div class="row mb-3 addon-entry">
                                        <div class="col-md-3">
                                            <input type="text" name="addon_name[]" class="form-control" value="{{ $addon['name'] }}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="addon_description[]" class="form-control" value="{{ $addon['description'] }}">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="addon_price[]" class="form-control" value="{{ $addon['price'] }}">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="addon_quantity[]" class="form-control" value="{{ $addon['quantity'] }}">
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <button type="button" class="btn btn-danger remove-addon">Remove</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Add Button -->
                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-primary" id="add-addon">
                                    <i class="bi bi-plus-lg"></i> Add More
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success">Update Ticket</button>
                    </div>
                </form>

            </div>
        </section>
    </div>
</div>



</div>
<!-- /.modal -->

@endsection

@section('js')



<script src="{{asset('admin/assets/node_modules/switchery/dist/switchery.min.js')}}"></script>
<script src="{{asset('admin/assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}">
</script>
<script src="{{asset('admin/assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup.min.js')}}">
</script>
<script src="{{asset('admin/assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup-init.js')}}"></script>
<script src="{{asset('admin/assets/node_modules/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("add-addon").addEventListener("click", function () {
            let addonContainer = document.getElementById("addons-container");
            let newAddon = document.createElement("div");
            newAddon.classList.add("row", "mb-3", "addon-entry");
            newAddon.innerHTML = `
                <div class="col-md-3">
                    <input type="text" name="addon_name[]" class="form-control" placeholder="Add-on Name">
                </div>
                <div class="col-md-3">
                    <input type="text" name="addon_description[]" class="form-control" placeholder="Description">
                </div>
                <div class="col-md-2">
                    <input type="number" name="addon_price[]" class="form-control" placeholder="Price">
                </div>
                <div class="col-md-2">
                    <input type="number" name="addon_quantity[]" class="form-control" placeholder="Quantity">
                </div>
                <div class="col-md-2 text-end">
                    <button type="button" class="btn btn-danger remove-addon">Remove</button>
                </div>
            `;
            addonContainer.appendChild(newAddon);

            newAddon.querySelector(".remove-addon").addEventListener("click", function () {
                this.closest(".addon-entry").remove();
            });
        });

        document.querySelectorAll(".remove-addon").forEach(button => {
            button.addEventListener("click", function () {
                this.closest(".addon-entry").remove();
            });
        });
    });
</script>

@endsection
