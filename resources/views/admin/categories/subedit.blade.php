@extends('admin.layout')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
<link href="{{ asset('public/admin/assets/node_modules/switchery/dist/switchery.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container" style="margin-top: 30px; max-width: 1200px; margin-left: auto; margin-right: auto;">
    <div style="display: flex; justify-content: space-between; gap: 30px;">
        <!-- Edit Subcategory Section -->
        <div style="width: 48%; background-color: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <h4 style="font-family: 'Arial', sans-serif; color: #4A90E2; margin-bottom: 30px; font-weight: 600; font-size: 24px;">Edit Subcategory</h4>

            <form action="{{ route('updatesubcate', Crypt::encryptString($subcategory->id)) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Category Field -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="category" style="font-weight: 500; color: #333;">Category</label>
                    <input type="text" class="form-control" value="{{ $subcategory->category->title }}" readonly>
                    <input type="hidden" name="cateid" value="{{ $subcategory->category_id }}">
                </div>

                <!-- Title Field -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="title" style="font-weight: 500; color: #333;">Subcategory Title</label>
                    <input type="text" name="title" id="title" class="form-control" required value="{{ $subcategory->title }}">
                </div>

                <!-- Slug Field -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="slug" style="font-weight: 500; color: #333;">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control" required value="{{ $subcategory->slug }}">
                </div>



                <!-- Meta Title -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="meta_title" style="font-weight: 500; color: #333;">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" class="form-control" required value="{{ $subcategory->meta_title }}">
                </div>

                <!-- Meta Description -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="meta_description" style="font-weight: 500; color: #333;">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" class="form-control" required rows="4">{{ $subcategory->meta_description }}</textarea>
                </div>

                <!-- Meta Keywords -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="meta_keywords" style="font-weight: 500; color: #333;">Meta Keywords</label>
                    <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" required value="{{ $subcategory->meta_keywords }}">
                </div>

                <!-- Details Field -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="details" style="font-weight: 500; color: #333;">Details</label>
                    <textarea name="details" id="details" class="form-control" required rows="6">{{ $subcategory->details }}</textarea>
                </div>

                <button type="submit" class="btn btn-success" style="background-color: #4A90E2; color: white; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; width: 100%;">Update Subcategory</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $("#title").keyup(function() {
        var Text = $(this).val();
        Text = Text.toLowerCase().replace(/[^a-zA-Z0-9]+/g, '-');
        $("#slug").val(Text);
    });
</script>
@endsection
