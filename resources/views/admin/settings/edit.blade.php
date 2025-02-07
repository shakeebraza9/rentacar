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
                                        <label>{{ ucwords(str_ireplace("_", " ",$item->field))}} :</label>
                                        <input 
                                        class="image form-control"
                                        type="text" 
                                        value="{{$item->value}}"  
                                        placeholder="{{ ucwords(str_ireplace("_", " ",$item->field))}}" 
                                        name="{{$item->field}}[value]" >
                                        <input type="hidden" name="{{$item->field}}[type]"
                                        value="{{$item->type}}" >
                                    </div>
                                </div>
                                <div class="col-md-6 text-center">
                                        @if($item->image)
                                        <img style="width:100px;height:100px;" 
                                        src="{{asset('public/'.$item->image->path)}}" />
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

</script>
    
@endsection