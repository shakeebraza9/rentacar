@extends('admin.layout')
@section('css')

<link href="{{asset('admin/assets/summernote/summernote-bs4.css')}}" rel="stylesheet">
<style>
    .error{
        color:red;
    }
</style>

@endsection
@section('content')

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{ ucwords(str_ireplace("_", " ",$group))}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Settings</li>
            </ol>
        </div>
    </div>
</div>

@foreach ($data as $kk => $settings)

<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <header class="card-header bg-info">
                <h4 class="mb-0 text-white">{{ ucwords(str_ireplace("_", " ",$kk))}}</h4>
                </header>
            <div class="card-body">
                <form method="post"
                enctype="multipart/form-data"
                action="{{URL::to('admin/settings/update/')}}" >
                    @csrf
                    <div class="row">
                        @foreach ($settings as $key => $item)
                        @switch($item->type)
                            @case('keywords')
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ ucwords(str_ireplace("_", " ",$item->field))}}</label>
                                    <input
                                      id="tagsinput"
                                      class="tagsinput"
                                      type="text"
                                      value="{{$item->value}}"
                                      placeholder="{{ ucwords(str_ireplace("_", " ",$item->field))}}"
                                      name="[fields][{{$key}}]{{$item->field}}" >

                                </div>
                            </div>
                            @break


                            @case('image')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ ucwords(str_ireplace("_", " ", $item->field)) }} :</label>
                                    <select
                                        id="hover-image-selector-{{$item->field}}"
                                        class="form-control select2 image-selector"
                                        name="{{$item->field}}[value]">
                                        <option value="">Select an Image</option>
                                        @foreach($fileManager as $file)
                                            <option
                                                value="{{ $file->path }}"
                                                data-image="{{ asset($file->path) }}"
                                                @if($file->path == $item->value) selected @endif>
                                                {{ $file->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="{{$item->field}}[type]" value="{{$item->type}}">
                                </div>
                            </div>
                            <div class="col-md-6 text-center">
                                @if($item->image)
                                    <img id="image-preview-{{$item->field}}"
                                        style="width:100px;height:100px;"
                                        src="{{ asset('public/'.$item->image->path) }}" />
                                @else
                                    <p id="image-preview-{{$item->field}}">No Image Selected</p>
                                @endif
                            </div>


                            @break


                            @case('textarea')
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ ucwords(str_ireplace("_", " ",$item->field))}}</label>
                                    <textarea class="summernote form-control"
                                      placeholder="{{ ucwords(str_ireplace("_", " ",$item->field))}}"
                                      name="{{$item->field}}[value]">{!!$item->value!!}</textarea>
                                      <input type="hidden" name="{{$item->field}}[type]"
                                      value="{{$item->type}}" >
                                </div>
                            </div>
                            @break

                            @default
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ ucwords(str_ireplace("_", " ",$item->field))}}</label>
                                    <input
                                      type="text"
                                      value="{{$item->value}}"
                                      class="form-control"
                                      placeholder="{{ ucwords(str_ireplace("_", " ",$item->field))}}"

                                      name="{{$item->field}}[value]" >

                                      <input type="hidden" name="{{$item->field}}[type]"
                                      value="{{$item->type}}" >

                                </div>
                            </div>
                          @endswitch

                        @endforeach

                        <div class="col-md-12 text-center pt-5">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
              </div>
          </section>
        </div>
    </div>

@endforeach
@endsection

@section('js')
<script src="{{asset('admin/js/jquery.tagsinput.js')}}"></script>
<script src="{{asset('admin/assets/summernote/summernote-bs4.min.js')}}"></script>
<script>

    jQuery(document).ready(function(){

        $('.summernote').summernote({
            height: 200,                 // set editor height

            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor

            focus: true                 // set focus to editable area after initializing summernote
        });
        $(".tagsinput").tagsInput();
    });

    $(document).ready(function () {
        // Initialize Select2 with image dropdown
        $('.image-selector').select2({
            templateResult: formatOption, // Use custom formatting for dropdown options
            templateSelection: formatOption, // Use custom formatting for selected item
            escapeMarkup: function (markup) {
                return markup; // Prevent escaping of HTML
            }
        });

        // Format dropdown options with image and text
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

        // Update image preview dynamically when selecting a new image
        $('.image-selector').on('change', function () {
            const selectedOption = $(this).find(':selected');
            const imageUrl = selectedOption.data('image');
            const previewId = '#image-preview-' + $(this).attr('id').replace('hover-image-selector-', '');

            if (imageUrl) {
                $(previewId).attr('src', imageUrl).show();
            } else {
                $(previewId).hide().text('No Image Selected');
            }
        });
    });


</script>

@endsection
