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
            <header class="card-header bg-info">
                <h4 class="mb-0 text-white">Edit Ticket</h4>
            </header>
            <div class="card-body">
                <form method="POST" action="{{ route('ticket.update', Crypt::encryptString($ticket->id)) }}">
                    @csrf
                    <div class="form-group row">
                        <label for="title" class="col-md-2 col-form-label">Title</label>
                        <div class="col-md-10">
                            <input type="text" id="title" name="title" class="form-control" value="{{ $ticket->title }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-md-2 col-form-label">Description</label>
                        <div class="col-md-10">
                            <textarea id="description" name="description" class="form-control" rows="4">{{ $ticket->description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="discount_price" class="col-md-2 col-form-label">Discount Price</label>
                        <div class="col-md-4">
                            <input type="text" id="discount_price" name="discount_price" class="form-control" value="{{ $ticket->discount_price }}">
                        </div>
                        <label for="selling_price" class="col-md-2 col-form-label">Selling Price</label>
                        <div class="col-md-4">
                            <input type="text" id="selling_price" name="selling_price" class="form-control" value="{{ $ticket->selling_price }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ticket_quantity" class="col-md-2 col-form-label">Ticket Quantity</label>
                        <div class="col-md-4">
                            <input type="number" id="ticket_quantity" name="ticket_quantity" class="form-control" value="{{ $ticket->ticket_quantity }}" required>
                        </div>
                        <label for="status" class="col-md-2 col-form-label">Status</label>
                        <div class="col-md-4">
                            <select id="status" name="status" class="form-control">
                                <option value="active" {{ $ticket->status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $ticket->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row text-center">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">Update Ticket</button>
                            <a href="{{ route('ticket.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
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


</script>

@endsection
