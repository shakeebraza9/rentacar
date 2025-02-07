@extends('admin.layout')
@section('css')
<style>
    .invalid-feedback{
      display: block;
   }
</style>
@endsection

@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">ADD YOUR COLLECTIONS
        </h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Collections</li>
            </ol>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <header class="card-header bg-info">
                <h4 class="mb-0 text-white" >Create Collection</h4>
            </header>
            <div class="card-body">
                <form method="post" action="{{URL::to('admin/collections/store')}}" >
                    @csrf

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
                        placeholder="slug">
                        @if($errors->has('slug'))
                         <p class="invalid-feedback" >{{ $errors->first('slug') }}</p>
                        @endif 
                    </div>

                    <div class="form-group">
                        <label class="form-label">Details</label>
                         <textarea placeholder="Details" name="details" class="form-control" >{{old('details')}}</textarea>
                          @if($errors->has('details'))
                          <p class="invalid-feedback" >{{ $errors->first('details') }}</p>
                          @endif 
                    </div>

                     <div class="form-group">
                        <label class="form-label" >Image</label>
                          <input type="text" value="{{old('image_id')}}" name="image_id" class="form-control" placeholder="Image"> 
                          @if($errors->has('image_id'))
                          <p class="invalid-feedback" >{{ $errors->first('image_id') }}</p>
                          @endif 
                      </div>

                      <div class="form-group">
                          <label class="form-label">Sort</label>
                          <input type="number" required value="{{old('sort')}}" name="sort" class="form-control" placeholder="Sort"> 
                          @if($errors->has('sort'))
                          <p class="invalid-feedback" >{{ $errors->first('sort') }}</p>
                          @endif 
                      </div>

                      <div class="form-group">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="is_enable" >
                            <option {{old('is_enable') ==  '1' ? 'selected' : ''}} value="1">Approve</option>
                            <option {{old('is_enable') ==  '0' ? 'selected' : ''}} value="0">Pending</option>
                        </select>
                        @if($errors->has('is_enable'))
                        <p class="invalid-feedback" >{{ $errors->first('is_enable') }}</p>
                        @endif 
                      </div>

                      <div class="form-group">
                        <label class="form-label">Featured</label>
                        <select class="form-control" name="is_featured" >
                            <option {{old('is_featured') ==  '1' ? 'selected' : ''}} value="1">Yes</option>
                            <option {{old('is_featured') ==  '0' ? 'selected' : ''}} value="0">No</option>
                        </select>
                        @if($errors->has('is_featured'))
                        <p class="invalid-feedback" >{{ $errors->first('is_featured') }}</p>
                        @endif 
                      </div>


                      <div class="form-group">
                        <label class="form-label">Meta Title</label>
                        <input placeholder="Meta Title" type="text" value="{{old('meta_title')}}" name="meta_title" class="form-control" />
                        @if($errors->has('meta_title'))
                         <p class="invalid-feedback" >{{ $errors->first('meta_title') }}</p>
                        @endif
                    </div>
            
                    <div class="form-group">
                        <label class="form-label">Meta Description</label>
                        <input type="text" placeholder="Meta Description" 
                        value="{{old('meta_description')}}" name="meta_description" class="form-control" />
                        @if($errors->has('meta_description'))
                         <p class="invalid-feedback" >{{ $errors->first('meta_description') }}</p>
                        @endif
                    </div>
            
                    <div class="form-group">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" placeholder="Meta Keywords" 
                        value="{{old('meta_keywords')}}" name="meta_keywords" 
                        class="form-control" />
                        @if($errors->has('meta_keywords'))
                         <p class="invalid-feedback" >{{ $errors->first('meta_keywords') }}</p>
                        @endif
                    </div>
                    

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

<script>

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