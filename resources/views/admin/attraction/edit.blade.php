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

   .gallery-item .delete-gallery-img {
    display: none;
}
.gallery-item:hover .delete-gallery-img {
    display: block;
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
        <h4 class="text-themecolor">ADD YOUR PRODUCT
        </h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <form method="post" action="{{URL::to('admin/attractions/update/'.Crypt::encryptString($product->id))}}" >
            @csrf

            <div class="row">
                <div class="col-md-9">
                    <section class="card">
                        <header class="card-header" style="background-color: #6b0909">
                            <h4 class="mb-0 text-white" >General Details</h4>
                        </header>
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" >Title</label>
                                            <input type="text" value="{{$product->title}}" name="title" class="title form-control"
                                            placeholder="Title">
                                            @if($errors->has('title'))
                                             <p class="invalid-feedback" >{{ $errors->first('title') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Slug</label>
                                            <input type="text" value="{{$product->slug}}" name="slug" class="slug form-control"
                                            placeholder="Slug">
                                            @if($errors->has('slug'))
                                             <p class="invalid-feedback" >{{ $errors->first('slug') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Discount price</label>
                                            <input type="text" value="{{$product->discount_price}}" name="price" class="form-control"
                                            placeholder="Price">
                                            @if($errors->has('price'))
                                            <p class="invalid-feedback" >{{ $errors->first('price') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Selling Price</label>
                                            <input type="text" value="{{$product->selling_price}}" name="selling_price" class="form-control"
                                            placeholder="Selling Price">
                                            @if($errors->has('selling_price'))
                                            <p class="invalid-feedback" >{{ $errors->first('selling_price') }}</p>
                                            @endif
                                        </div>
                                    </div>

                             </div>
                        </div>
                    </section>

                    <section class="card">
                        <header class="card-header bg-info">
                            <h4 class="mb-0 text-white">Description</h4>
                        </header>
                        <div class="card-body">
                            <div class="editor-container">
                            <textarea id="long_description"  class="form-control"
                            name="description">{{$product->description}}</textarea>
                            </div>
                        </div>
                    </section>
                    <section class="card">
                        <header class="card-header bg-info">
                            <h4 class="mb-0 text-white">Gallery Images</h4>
                        </header>
                        <div class="card-body">
                            <!-- Display Existing Gallery Images -->
                            <div class="form-group my-2">
                                <label class="form-label" for="">Current Gallery Images:</label>
                                <div class="row">
                                    @foreach($product->get_images() as $key => $item)
                                    <div class="col-md-3 text-center mb-3 position-relative gallery-item" data-id="{{ $item->id }}">
                                        <img src="{{ asset($item->path) }}" alt="Gallery Image" class="img-fluid img-thumbnail" />
                                        <p class="mt-2">{{ $item->title }}</p>

                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 delete-gallery-img" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>

                                    @endforeach
                                </div>
                            </div>

                            <hr>

                            <!-- Add New Gallery Images -->
                            <div class="form-group my-2">
                                <label class="form-label" for="gallery-selector">Add Images to Gallery:</label>
                                @php
                                $selectedGalleryIds = explode(',', $product->gallery_id ?? '');
                                @endphp
                                <select name="gallery[]" id="gallery-selector" class="form-control select2" multiple>
                                    @foreach($filemanager as $file)
                                        <option value="{{ $file->id }}"
                                            data-image="{{ asset($file->path) }}"
                                            {{ in_array($file->id, $selectedGalleryIds) ? 'selected' : '' }}>
                                            {{ $file->title }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </section>




                </div>
                <div class="col-md-3">

                    <section class="card">
                        <header class="card-header bg-info">
                            <h4 class="mb-0 text-white">Image</h4>
                        </header>
                        <div class="card-body">

                            <!-- Thumbnail Selection -->
                            <div class="form-group my-2">
                                <label class="form-label" for="image-selector">Thumbnail:</label>
                                <select name="image" class="form-control" id="image-selector">
                                    <option value="">Select Image</option>
                                    @foreach($filemanager as $file)
                                        <option value="{{ $file->id }}" data-image="{{ asset($file->path) }}"
                                            @if($file->id == $product->image_id) selected @endif>
                                            {{ $file->title }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="selected-image-preview">
                                    @if($product->get_thumbnail && file_exists(public_path($product->get_thumbnail->path)))
                                        <img class="pt-3" style="width: 100px; height: 100px;" src="{{ asset($product->get_thumbnail->path) }}" alt="Thumbnail" />
                                    @else
                                        <p class="pt-3">No thumbnail available</p>
                                    @endif
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
     $(function () {


           $(".select2").select2();

            ClassicEditor.create(document.querySelector('#long_description')).catch(error => {
                console.error(error);
            });


            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function () {
                new Switchery($(this)[0], $(this).data());
            });


            $('.add_image').click(function(){
                     var id = Math.random().toString(16).slice(2);
                     $('.gallery-box').append(`<div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="el-card-item mb-0 pb-0">
                                <label class="form-label" >File Code</label>
                                <input class="form-control" type="text"
                                name="gallery[${id}]" />
                                </div>
                            </div>
                    </div>`);
            });

        $(".title").keyup(function() {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
            $(".slug").val(Text);
        });

        // $(".type").change(function() {

        //     var type = $(this).val();
        //     if(type == 'single'){
        //         $('.variation_box').hide();
        //         $('.single_box').show();
        //     }else{
        //         $('.variation_box').show();
        //         $('.single_box').hide();
        //     }
        // }).trigger('change');



    });
    function handleCategoryChange(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];


        const categorySlug = selectedOption.getAttribute('data-slug');


        if (categorySlug === 'car') {
            console.log("Car category selected. Perform the desired action here.");
            getSubCategories();
        } else {
            console.log("Other category selected.");
        }
    }

    function getSubCategories() {
        let categoryId = document.getElementById("category_id").value;
        let additionalFields = document.getElementById("additional-fields");
        console.log(categoryId,additionalFields);
        // Hide all additional fields by default
        additionalFields.style.display = "block";

    }
    $(document).ready(function () {
        // Thumbnail Selector with Image
        $('#image-selector').select2({
            templateResult: formatOption,
            templateSelection: formatOption,
            escapeMarkup: function (markup) {
                return markup;
            }
        });

        // Hover Image Selector with Image
        $('#hover-image-selector').select2({
            templateResult: formatOption,
            templateSelection: formatOption,
            escapeMarkup: function (markup) {
                return markup;
            }
        });

        // Format dropdown options with image
        function formatOption(option) {
            if (!option.id) {
                return option.text;
            }
            const imageUrl = $(option.element).data('image');
            return `<div style="display: flex; align-items: center;">
                        <img src="${imageUrl}" style="width: 30px; height: 30px; margin-right: 10px; border-radius: 4px;" />
                        <span>${option.text}</span>
                    </div>`;
        }
    });
    $(document).ready(function () {
        // Initialize Select2 with Image Preview
        $('#gallery-selector').select2({
            templateResult: formatState, // For dropdown options
            templateSelection: formatState, // For selected items
            escapeMarkup: function (markup) {
                return markup;
            },
        });

        // Format images for Select2 dropdown
        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            let imageUrl = $(state.element).data('image');
            return `<div style="display: flex; align-items: center;">
                        <img src="${imageUrl}" style="width: 30px; height: 30px; margin-right: 10px;" />
                        <span>${state.text}</span>
                    </div>`;
        }
    });



    $('.delete-gallery-img').on('click', function () {
        const galleryItem = $(this).closest('.gallery-item');
        const imageId = galleryItem.data('id');
        const productId = "{{ $product->id }}"; // Pass product ID

        $.ajax({
            url: "{{ route('admin.galleryattractions.remove') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                product_id: productId,
                image_id: imageId
            },
            success: function (response) {
                if (response.success) {
                    galleryItem.remove(); // Remove from DOM
                } else {
                    alert('Failed to remove image.');
                }
            },
            error: function () {
                alert('Error occurred during deletion.');
            }
        });
    });


</script>

@endsection
