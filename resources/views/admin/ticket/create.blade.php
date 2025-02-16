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
                            <div class="form-group row">
                                <label for="attraction" class="col-md-2 col-form-label">Select Attraction</label>
                                <div class="col-md-10">
                                    <select id="attraction" name="attraction_id" class="form-control">
                                        <option value="">Select an Attraction</option>
                                        @foreach($attractions as $attraction)
                                            <option value="{{ $attraction->id }}">{{ $attraction->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="title" class="col-md-2 col-form-label">Title</label>
                                <div class="col-md-10">
                                    <input type="text" id="title" name="title" class="form-control" placeholder="Enter Title">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-md-2 col-form-label">Description</label>
                                <div class="col-md-10">
                                    <textarea id="description" name="description" class="form-control" rows="4" placeholder="Enter Description"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="discount_price" class="col-md-2 col-form-label">Discount Price</label>
                                <div class="col-md-4">
                                    <input type="number" id="discount_price" name="discount_price" class="form-control" placeholder="Enter Discount Price">
                                </div>
                                <label for="selling_price" class="col-md-2 col-form-label">Selling Price</label>
                                <div class="col-md-4">
                                    <input type="number" id="selling_price" name="selling_price" class="form-control" placeholder="Enter Selling Price">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ticket_quantity" class="col-md-2 col-form-label">Ticket Quantity</label>
                                <div class="col-md-10">
                                    <input type="number" id="ticket_quantity" name="ticket_quantity" class="form-control" placeholder="Enter Ticket Quantity">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

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

</script>

@endsection
