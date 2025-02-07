@extends('admin.layout')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.css">
<style>
    .invalid-feedback{
      display: block;
   }
</style>
@endsection

@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Manage Hierarchy
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
                <h4 class="mb-0 text-white" >Manage Hierarchy</h4>
            </header>
            <div class="card-body">
                <div class="dd">
                    <ol class="dd-list">
                        @foreach ($categories as $item)
                            <li class="dd-item" data-id="{{$item->id}}">
                                <div class="dd-handle">
                                    {{$item->title}}
                                </div>
                                <ol class="dd-list">
                                    @foreach ($item->children as $child)
                                        <li class="dd-item" data-id="{{$child->id}}">
                                            <div class="dd-handle">{{$child->title}}</div>
                                            <ol class="dd-list">
                                                @foreach ($child->children as $sub)
                                                <li class="dd-item" data-id="{{$sub->id}}">
                                                    <div class="dd-handle">{{$sub->title}}</div>
                                                </li>
                                                @endforeach
                                            </ol>
                                        </li>
                                    @endforeach
                               </ol>
                            </li>
                        @endforeach
                    </ol>
                </div>

                
                <div class="box text-center">
                    <button class="save_btn btn btn-info" type="button" >Save</button>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.js"></script>
<script>
    
    $(function () {

        $('.dd').nestable({
            maxDepth:3,
        });

  
        $(".save_btn").click(function (e) { 
        
           
            $.ajax({
                type: "get",
                url: "{{URL::to('/admin/categories/sort')}}",
                data: {
                   data:$('.dd').nestable('serialize'),
                },
                dataType: "json",
                success: function (response) {
                    location.reload();

                }
            });

            
         

        });
  
   });
</script>
    
@endsection