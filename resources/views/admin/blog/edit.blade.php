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
            <h4 class="text-themecolor">Edit  Blog
            </h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Blog</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form method="post" action="{{ URL::to('admin/blog/update', $blog->id) }}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <section class="card">
                            <header class="card-header bg-dark text-white">
                                <h4 class="mb-0">Edit Blog</h4>
                            </header>
                            <div class="card-body">

                                <!-- Title -->
                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <input required type="text" value="{{ old('title', $blog->title) }}" name="title" class="form-control title">
                                    @error('title')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Slug -->
                                <div class="form-group">
                                    <label class="form-label">Slug</label>
                                    <input required type="text" value="{{ old('slug', $blog->slug) }}" name="slug" class="form-control slug">
                                    @error('slug')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Image Selector (Select2) -->
                                <div class="form-group my-2">
                                    <label class="form-label" for="image-selector">Thumbnail:</label>
                                    <select name="image_id" class="form-control select2" id="image-selector">
                                        <option value="">Select Image</option>
                                        @foreach($filemanager as $file)
                                            <option value="{{ $file->id }}" data-image="{{ asset($file->path) }}"
                                                @if($file->id == $blog->image_id) selected @endif>
                                                {{ $file->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="selected-image-preview mt-2">
                                        @if($blog->image_id)
                                            <img class="pt-3" id="preview-img" style="width: 100px; height: 100px;" src="{{ asset($filemanager->where('id', $blog->image_id)->first()->path ?? '') }}" alt="Thumbnail" />
                                        @else
                                            <p class="pt-3">No thumbnail available</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Short Description -->
                                <div class="form-group">
                                    <label class="form-label">Short Description</label>
                                    <textarea name="short_description" class="form-control" rows="2">{{ old('short_description', $blog->short_description) }}</textarea>
                                    @error('short_description')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="4">{{ old('description', $blog->description) }}</textarea>
                                    @error('description')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Location -->
                                <div class="form-group">
                                    <label class="form-label">Location</label>
                                    <input type="text" name="location" class="form-control" value="{{ old('location', $blog->location) }}">
                                    @error('location')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                        </section>
                    </div>
                </div>

                <div class="pt-3 form-group row">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-info">Update</button>
                        <a href="{{ route('blog.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

      </div>

@endsection
 @section('js')
<script>
    $(document).ready(function () {
        $('#image-selector').select2({
            templateResult: formatImageOption,
            templateSelection: formatImageOption
        });

        function formatImageOption(option) {
            if (!option.id) {
                return option.text;
            }
            var imageUrl = $(option.element).data('image');
            return $('<span><img src="' + imageUrl + '" style="width:30px; height:30px; object-fit:cover; margin-right:10px;" /> ' + option.text + '</span>');
        }

        $('#image-selector').change(function () {
            var imageUrl = $(this).find(':selected').data('image');
            if (imageUrl) {
                $('#preview-img').attr('src', imageUrl).show();
            } else {
                $('#preview-img').hide();
            }
        });
    });

    $(function () {

        $(".title").keyup(function() {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
            $(".slug").val(Text);
        });

    });
</script>

@endsection
