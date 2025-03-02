@extends('admin.layout')
@section('css')
<link href="{{asset('admin/assets/node_modules/switchery/dist/switchery.min.css')}}" rel="stylesheet" />
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

</style>
<link href="{{asset('admin/assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" />
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
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
    <div class="col-lg-12">
        <form method="post" action="{{ URL::to('admin/ticket/store') }}">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <section class="card">
                        <header class="card-header bg-info">
                            <h4 class="mb-0 text-white">General Details</h4>
                        </header>
                        <div class="card-body">
                            <!-- Select Attraction -->
                            <div class="form-group row">
                                <label for="attraction" class="col-md-2 col-form-label">Select Attraction</label>
                                <div class="col-md-10">
                                    <select id="attraction" name="attraction_id" class="form-control">
                                        <option value="">Select an Attraction</option>
                                        @foreach($attractions as $attraction)
                                            <option value="{{ $attraction->id }}" {{ old('attraction_id') == $attraction->id ? 'selected' : '' }}>
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
                                    <input type="text" id="title" name="title" class="form-control" placeholder="Enter Title" value="{{ old('title') }}">
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="form-group row">
                                <label for="description" class="col-md-2 col-form-label">Description</label>
                                <div class="col-md-10">
                                    <textarea id="description" name="description" class="form-control" rows="4" placeholder="Enter Description">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <!-- Prices -->
                            <div class="form-group row">
                                <label for="discount_price" class="col-md-2 col-form-label">Discount Price</label>
                                <div class="col-md-4">
                                    <input type="number" id="discount_price" name="discount_price" class="form-control" placeholder="Enter Discount Price" value="{{ old('discount_price') }}">
                                </div>
                                <label for="selling_price" class="col-md-2 col-form-label">Selling Price</label>
                                <div class="col-md-4">
                                    <input type="number" id="selling_price" name="selling_price" class="form-control" placeholder="Enter Selling Price" value="{{ old('selling_price') }}">
                                </div>
                            </div>

                            <!-- Ticket Quantity -->
                            <div class="form-group row">
                                <label for="ticket_quantity" class="col-md-2 col-form-label">Ticket Quantity</label>
                                <div class="col-md-10">
                                    <input type="number" id="ticket_quantity" name="ticket_quantity" class="form-control" placeholder="Enter Ticket Quantity" value="{{ old('ticket_quantity') }}">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <!-- Variations Section -->
            <div class="card shadow-lg border-0 rounded-3 mt-4">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">Variations</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <!-- Children Quantity -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="number" id="child-quantity" name="child_quantity" class="form-control" placeholder="1" min="1" value="{{ old('child_quantity', 1) }}">
                                <label for="child-quantity">Children Quantity</label>
                            </div>
                        </div>
                        <!-- Children Price -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" id="child-price" name="child_price" class="form-control" placeholder="10.00" value="{{ old('child_price', 10.00) }}">
                                <label for="child-price">Price for Children (RM)</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Adults Quantity -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="number" id="adult-quantity" name="adult_quantity" class="form-control" placeholder="1" min="1" value="{{ old('adult_quantity', 1) }}">
                                <label for="adult-quantity">Adult Quantity</label>
                            </div>
                        </div>
                        <!-- Adults Price -->
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" id="adult-price" name="adult_price" class="form-control" placeholder="20.00" value="{{ old('adult_price', 20.00) }}">
                                <label for="adult-price">Price for Adults (RM)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add-ons Section -->
            <div class="card shadow-lg border-0 rounded-3 mt-4">
                <div class="card-header bg-info text-white text-center">
                    <h5 class="mb-0">Add-ons</h5>
                </div>
                <div class="card-body">
                    <div id="addons-container">
                        @if(old('addon_name'))
                            @foreach(old('addon_name') as $index => $name)
                                <div class="row addon-entry mb-3">
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="text" name="addon_name[]" class="form-control" placeholder="Add-on Name" value="{{ $name }}">
                                            <label>Add-on Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="text" name="addon_description[]" class="form-control" placeholder="Description" value="{{ old('addon_description')[$index] }}">
                                            <label>Description</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-floating">
                                            <input type="number" name="addon_price[]" class="form-control" placeholder="Price" min="0" step="0.01" value="{{ old('addon_price')[$index] }}">
                                            <label>Price (RM)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-floating">
                                            <input type="number" name="addon_quantity[]" class="form-control" placeholder="Quantity" min="1" value="{{ old('addon_quantity')[$index] }}">
                                            <label>Quantity</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <button type="button" class="btn btn-danger remove-addon">Remove</button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
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
            <div class="pt-3 form-group row">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </div>
        </form>


    </div>
</div>
@endsection

@section('js')



<script src="{{asset('admin/assets/node_modules/switchery/dist/switchery.min.js')}}"></script>
<script src="{{asset('admin/assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let addonsContainer = document.getElementById("addons-container");
        let addAddonBtn = document.getElementById("add-addon");

        addAddonBtn.addEventListener("click", function () {
            let newAddon = document.createElement("div");
            newAddon.classList.add("row", "addon-entry", "mb-3");

            newAddon.innerHTML = `
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" name="addon_name[]" class="form-control" placeholder="Add-on Name">
                        <label>Add-on Name</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" name="addon_description[]" class="form-control" placeholder="Description">
                        <label>Description</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating">
                        <input type="number" name="addon_price[]" class="form-control" placeholder="Price" min="0" step="0.01">
                        <label>Price (RM)</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating">
                        <input type="number" name="addon_quantity[]" class="form-control" placeholder="Quantity" min="1">
                        <label>Quantity</label>
                    </div>
                </div>
                <div class="col-md-2 text-end">
                    <button type="button" class="btn btn-danger remove-addon">Remove</button>
                </div>
            `;

            addonsContainer.appendChild(newAddon);
        });

        // Remove Add-on Entry
        addonsContainer.addEventListener("click", function (event) {
            if (event.target.classList.contains("remove-addon")) {
                event.target.closest(".addon-entry").remove();
            }
        });
    });
    </script>


@endsection
