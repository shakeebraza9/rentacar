@extends('admin.layout')
@section('css')
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css" />

<style>
    .invalid-feedback{
      display: block;
   }
</style>
@endsection

@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">EDIT YOUR PAGES
        </h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Pages</li>
            </ol>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <header class="card-header" style="background-color: #6b0909">
                <h4 class="mb-0 text-white" >Edit Pages</h4>
            </header>
            <div class="card-body">
                <form method="post" action="{{URL::to('admin/page/update/'.Crypt::encryptString($model->id))}}" >
                    @csrf
                    <div class="form-group">
                        <label class="form-label" >Title</label>
                        <input required type="text" value="{{$model->title}}" name="title" class="form-control title"
                        placeholder="Title">
                        @if($errors->has('title'))
                         <p class="invalid-feedback" >{{ $errors->first('title') }}</p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-label" >Slug</label>
                        <input required type="text" value="{{$model->slug}}" name="slug" class="form-control slug"
                        placeholder="slug">
                        @if($errors->has('slug'))
                         <p class="invalid-feedback" >{{ $errors->first('slug') }}</p>
                        @endif
                    </div>

                    {{--  <div class="form-group">
                        <label class="form-label">Short Details</label>
                         <textarea placeholder="Short Details" name="shortdetails" class="form-control" >{{$model->shortdetails}}</textarea>
                          @if($errors->has('details'))
                          <p class="invalid-feedback" >{{ $errors->first('details') }}</p>
                          @endif
                    </div>  --}}

                    <div class="form-group">
                        <label class="form-label">Long Details</label>
                        <textarea id="long_description_editor" class="form-control" name="content">{{ old('content', $model->content) }}</textarea>
                        @error('content')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    

                      <div class="form-group">
                        <label class="form-label">Meta Title</label>
                        <input placeholder="Meta Title" type="text" value="{{$model->meta_title}}" name="meta_title" class="form-control" />
                        @if($errors->has('meta_title'))
                         <p class="invalid-feedback" >{{ $errors->first('meta_title') }}</p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-label">Meta Description</label>
                        <input type="text" placeholder="Meta Description"
                            value="{{ old('meta_description', $model->meta_description) }}" name="meta_description" class="form-control" />
                        @error('meta_description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    

                    {{--  <div class="form-group">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" placeholder="Meta Keywords"
                        value="{{$model->meta_keywords}}" name="meta_keywords"
                        class="form-control" />
                        @if($errors->has('meta_keywords'))
                         <p class="invalid-feedback" >{{ $errors->first('meta_keywords') }}</p>
                        @endif
                    </div>  --}}

                    <div class="form-group row">
                        <div class="col-md-12 text-left">
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                     </div>

                </form>
            </div>
        </section>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
<script>

   $(function () {
    $(".title").keyup(function() {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
            $(".slug").val(Text);
        });

    });
    var longDetailsEditor = new EasyMDE({
        element: document.getElementById("long_description_editor"),
        spellChecker: false,
        tabSize: 4,
        placeholder: "Write your article or code here...",
        toolbar: [
            "bold", "italic", "heading", "|",
            "code", "quote", "unordered-list", "ordered-list", "|",
            "link", "image", "|",
            "preview", "side-by-side", "fullscreen", "|", "guide"
        ],
        renderingConfig: {
            codeSyntaxHighlighting: true
        }
    });

</script>

@endsection
