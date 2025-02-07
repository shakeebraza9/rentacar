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
        <h4 class="text-themecolor">EDIT YOUR CATEGORY
        </h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <header class="card-header bg-info">
                <h4 class="mb-0 text-white" >Edit Category</h4>
            </header>
            <div class="card-body">
                <form method="post" action="{{URL::to('admin/categories/update/'.Crypt::encryptString($model->id))}}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Title</label>
                                <input required type="text" value="{{$model->title}}" name="title" class="form-control title" 
                                placeholder="Title">
                                @if($errors->has('title'))
                                 <p class="invalid-feedback" >{{ $errors->first('title') }}</p>
                                @endif 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" >Slug</label>
                                  <input required type="text" value="{{$model->slug}}" name="slug" class="slug form-control" placeholder="Slug"> 
                                  @if($errors->has('slug'))
                                  <p class="invalid-feedback" >{{ $errors->first('slug') }}</p>
                                  @endif 
                              </div>
                        </div>
                        
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Parent Category</label>
                            <input readonly class="form-control" type="text" value="{{$model->parent ? $model->parent->title : 'None' }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Sort</label>
                            <input readonly type="number" required value="{{$model->sort}}" name="sort" class="form-control" placeholder="Sort"> 
                        </div>
                    </div> 
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" >Image</label>
                              <input type="text" value="{{$model->image_id}}" name="image_id" class="form-control" placeholder="Image"> 
                              @if($errors->has('image_id'))
                              <p class="invalid-feedback" >{{ $errors->first('image_id') }}</p>
                              @endif 
                          </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Details</label>
                             <textarea placeholder="Details" name="details" class="form-control" >{{$model->details}}</textarea>
                              @if($errors->has('details'))
                              <p class="invalid-feedback" >{{ $errors->first('details') }}</p>
                              @endif 
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Description</label>
                             <textarea placeholder="Description" name="description" class="form-control" >{{$model->details}}</textarea>
                              @if($errors->has('description'))
                              <p class="invalid-feedback" >{{ $errors->first('description') }}</p>
                              @endif 
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Meta Title</label>
                            <input placeholder="Meta Title" type="text" value="{{$model->meta_title}}" name="meta_title" class="form-control" />
                            @if($errors->has('meta_title'))
                             <p class="invalid-feedback" >{{ $errors->first('meta_title') }}</p>
                            @endif
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Meta Description</label>
                            <input type="text" placeholder="Meta Description" 
                            value="{{$model->meta_description}}" name="meta_description" class="form-control" />
                            @if($errors->has('meta_description'))
                             <p class="invalid-feedback" >{{ $errors->first('meta_description') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" placeholder="Meta Keywords" 
                            value="{{$model->meta_keywords}}" name="meta_keywords" 
                            class="form-control" />
                            @if($errors->has('meta_keywords'))
                             <p class="invalid-feedback" >{{ $errors->first('meta_keywords') }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-12 text-center">
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

        $(".title").keyup(function() {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
            $(".slug").val(Text);        
        });

</script>
    
@endsection