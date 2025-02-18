@extends('admin.layout')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
<link href="{{ asset('public/admin/assets/node_modules/switchery/dist/switchery.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container" style="margin-top: 30px; max-width: 1200px; margin-left: auto; margin-right: auto;">
    <div style="display: flex; justify-content: space-between; gap: 30px;">
        <!-- Add Subcategory Section -->
        <div style="width: 48%; background-color: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <h4 style="font-family: 'Arial', sans-serif; color: #4A90E2; margin-bottom: 30px; font-weight: 600; font-size: 24px;">Add Subcategory</h4>

            <form action="{{ route('storesubcate') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Category Field -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="category" style="font-weight: 500; color: #333;">Category</label>
                    <input type="text" class="form-control" value="{{ $category->title }}" readonly style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; font-size: 16px; width: 100%; transition: border-color 0.3s ease;">
                    <input type="hidden" name="cateid" value="{{ $category->id }}" >
                </div>

                <!-- Title Field -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="title" style="font-weight: 500; color: #333;">Subcategory Title</label>
                    <input type="text" name="title" id="title" class="form-control" required placeholder="Enter Subcategory Title" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; font-size: 16px; width: 100%; transition: border-color 0.3s ease;">
                </div>

                <!-- Slug Field -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="slug" style="font-weight: 500; color: #333;">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control" required placeholder="Enter Slug" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; font-size: 16px; width: 100%; transition: border-color 0.3s ease;">
                </div>



                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="title" style="font-weight: 500; color: #333;">Subcategory Image</label>
                    <input type="number" name="image" id="image" class="form-control" required placeholder="Enter Subcategory Title" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; font-size: 16px; width: 100%; transition: border-color 0.3s ease;">
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="meta_title" style="font-weight: 500; color: #333;">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" class="form-control" required placeholder="Enter Meta Title" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; font-size: 16px; width: 100%; transition: border-color 0.3s ease;">
                </div>


                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="meta_description" style="font-weight: 500; color: #333;">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" class="form-control" required placeholder="Enter Meta Description" rows="4" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; font-size: 16px; width: 100%; transition: border-color 0.3s ease;"></textarea>
                </div>

                <!-- Meta Keywords Field -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="meta_keywords" style="font-weight: 500; color: #333;">Meta Keywords</label>
                    <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" required placeholder="Enter Meta Keywords" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; font-size: 16px; width: 100%; transition: border-color 0.3s ease;">
                </div>

                <!-- Details Field -->
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="details" style="font-weight: 500; color: #333;">Details</label>
                    <textarea name="details" id="details" class="form-control" required placeholder="Enter Details" rows="6" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; font-size: 16px; width: 100%; transition: border-color 0.3s ease;"></textarea>
                </div>

                <button type="submit" class="btn btn-success" style="background-color: #4A90E2; color: white; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; width: 100%; transition: background-color 0.3s ease;">Add Subcategory</button>
            </form>
        </div>

        <!-- Show Subcategory Section -->
        <div style="background-color: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 1200px; margin: 0 auto;">
            <h4 style="font-family: 'Arial', sans-serif; color: #4A90E2; margin-bottom: 30px; font-weight: 600; font-size: 24px;">All Subcategories</h4>

            <!-- Loop through all subcategories -->
            @foreach($subcategories as $subcategory)
                <div style="display: flex; flex-wrap: wrap; justify-content: space-between; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin-bottom: 20px; width: 48%;">
                    <div style="flex: 1; padding-right: 20px;">
                        <h5 style="font-weight: 500; color: #333; font-size: 18px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Subcategory Title: {{ $subcategory->title }}</h5>
                        <p style="font-weight: 400; color: #555; font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Slug: {{ $subcategory->slug }}</p>

                    </div>

                    <!-- Image -->
                    <div style="flex: 1; max-width: 200px; margin-bottom: 20px;">
                        <img src="{{ asset('storage/'.$subcategory->image) }}" alt="Subcategory Image" style="max-width: 100%; height: auto; border-radius: 5px;">
                    </div>

                    <!-- Edit and Delete buttons -->
                    <div style="width: 100%; display: flex; justify-content: space-between; margin-top: 20px;">
                        <!-- Edit Button -->
                        <a href="{{ route('editSubcategories', Crypt::encryptString($subcategory->id)) }}"
                            style="padding: 10px 20px; background-color: #4A90E2; color: white; border-radius: 5px; text-decoration: none; font-weight: 600;">
                            Edit
                         </a>


                        <!-- Delete Button -->
                        <form action="{{ route('admin.subcategory.destroy', Crypt::encryptString($subcategory->id)) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subcategory?')" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="padding: 10px 20px; background-color: #E94E77; color: white; border-radius: 5px; border: none; font-weight: 600;">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>


    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('public/admin/assets/node_modules/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/admin/assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/admin/assets/node_modules/switchery/dist/switchery.min.js') }}"></script>
<script>
     $("#title").keyup(function() {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
            $("#slug").val(Text);
        });
</script>

@endsection

