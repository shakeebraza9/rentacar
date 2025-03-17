@extends('admin.layout')
@section('css')

<link rel="stylesheet" type="text/css"
href="{{asset('public/admin/assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" type="text/css"
href="{{asset('public/admin/assets/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css')}}">
<link href="{{asset('public/admin/assets/node_modules/switchery/dist/switchery.min.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css" />
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
            <h4 class="text-themecolor">Create  Article
            </h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Article</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form method="post" action="{{ URL::to('admin/artical/store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <section class="card">
                            <header class="card-header text-white" style="background-color: #6b0909;">
                                <h4 class="mb-0">Create Article</h4>
                            </header>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Select Category</label>
                                    <select name="category_id" class="form-control" required>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                

                                <!-- Title -->
                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <input required type="text" value="{{ old('title') }}" name="title" class="form-control title" placeholder="Title">
                                    @error('title')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <textarea id="easymde-editor" name="description" class="form-control">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
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

@endsection
 @section('js')
 <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>

 <!-- Init EasyMDE -->
 <script>
     var easyMDE = new EasyMDE({
         element: document.getElementById("easymde-editor"),
         spellChecker: false,
         tabSize: 4,
         lineNumbers: true,
         placeholder: "Write your article... code blocks supported!",
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
