@extends('admin.layout')
@section('css')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

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
            <header class="card-header" style="background-color: #6b0909">
                <h4 class="mb-0 text-white">{{ ucwords(str_ireplace("_", " ",$settings[0]['grouping'] ?? null))}}</h4>
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
                                    <label class="form-label fw-semibold text-muted">
                                      {{ ucwords(str_ireplace("_", " ",$item->field)) }}
                                    </label>
                                    <textarea
                                      class="form-control shadow-sm border-2 rounded-3"
                                      style="min-height: 150px;"
                                      placeholder="✏️ {{ ucwords(str_ireplace("_", " ",$item->field)) }}"
                                      name="{{$item->field}}[value]"
                                    >{!!$item->value!!}</textarea>
                                    <input type="hidden" name="{{$item->field}}[type]" value="{{$item->type}}">
                                </div>
                            </div>
                            @break

                            @case('code')
                            <div class="col-md-12 mb-12">
                                <label class="form-label fw-semibold text-muted">
                                    {{ ucwords(str_ireplace("_", " ", $item->field)) }}
                                </label>
                                <input type="hidden" name="{{$item->field}}[type]" value="{{$item->type}}">
                                <textarea style="display:none;" name="{{$item->field}}[value]" id="{{$item->field}}">{!! htmlspecialchars($item->value) !!}</textarea>
                                <div id="{{$item->field}}_quill_editor" style="min-height:200px; background-color:#fff;"></div>
                            </div>

                            <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                var quill = new Quill('#{{$item->field}}_quill_editor', {
                                    theme: 'snow',
                                    placeholder: 'Type your content here...',
                                    modules: { toolbar: true }
                                });

                                // Load initial content from textarea
                                quill.root.innerHTML = document.getElementById('{{$item->field}}').value;

                                // Submit form handler to transfer content back to textarea
                                document.getElementById('{{$item->field}}').form.addEventListener('submit', function() {
                                    document.getElementById('{{$item->field}}').value = quill.root.innerHTML;
                                });
                            });
                            </script>
                            @break





                                {{-- Date Field --}}
                            @case('date')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ ucwords(str_ireplace("_", " ", $item->field)) }}</label>
                                    <input
                                        type="date"
                                        value="{{ $item->value }}"
                                        class="form-control"
                                        placeholder="Select Date"
                                        name="{{ $item->field }}[value]">
                                    <input type="hidden" name="{{ $item->field }}[type]" value="{{ $item->type }}">
                                </div>
                            </div>
                            @break

                        {{-- Time Field --}}
                        @case('time')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ ucwords(str_ireplace("_", " ", $item->field)) }}</label>
                                    <input
                                        type="time"
                                        value="{{ $item->value }}"
                                        class="form-control"
                                        placeholder="Select Time"
                                        name="{{ $item->field }}[value]">
                                    <input type="hidden" name="{{ $item->field }}[type]" value="{{ $item->type }}">
                                </div>
                            </div>
                            @break

                        {{-- Enable/Disable Toggle --}}
                        @case('enable')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ ucwords(str_ireplace("_", " ", $item->field)) }}</label>
                                    <select
                                        class="form-control"
                                        name="{{ $item->field }}[value]">
                                        <option value="1" @if($item->value == '1') selected @endif>Enable</option>
                                        <option value="0" @if($item->value == '0') selected @endif>Disable</option>
                                    </select>
                                    <input type="hidden" name="{{ $item->field }}[type]" value="{{ $item->type }}">
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

                        <div class="col-md-12 text-center pt-5" style="margin-top: 30px;">
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
