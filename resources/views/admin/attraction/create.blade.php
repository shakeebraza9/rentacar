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
        <h4 class="text-themecolor">ADD YOUR Attractions
        </h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Attractions</li>
            </ol>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <form method="post" action="{{URL::to('admin/attractions/store')}}" >
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <section class="card">
                        <header class="card-header" style="background-color: #6b0909">
                            <h4 class="mb-0 text-white" >General Details</h4>
                        </header>
                        <div class="card-body">

                                <div class="form-group">
                                    <label class="form-label" >Title</label>
                                    <input required type="text" value="{{old('title')}}" name="title" class="form-control title"
                                    placeholder="Title">
                                    @if($errors->has('title'))
                                     <p class="invalid-feedback" >{{ $errors->first('title') }}</p>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="form-label" >Slug</label>
                                    <input required type="text" value="{{old('slug')}}" name="slug" class="form-control slug"
                                    placeholder="Slug">
                                    @if($errors->has('slug'))
                                     <p class="invalid-feedback" >{{ $errors->first('slug') }}</p>
                                    @endif
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
     $(function () {

        $(".title").keyup(function() {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
            $(".slug").val(Text);
        });

        ClassicEditor
            .create(document.querySelector('#long_description')).catch(error => {
                console.error(error);
            });

            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function () {
                new Switchery($(this)[0], $(this).data());
            });
    });
</script>

@endsection
