@extends('admin.layout')
@section('css')
<style>



</style>
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{$model->menu->title}}</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Menus</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- page start-->
        <div class="menues-section row">
            <div class="col-sm-12">
                <section class="card">
                     <header class="card-header bg-info">
                         <h4 class="mb-0 text-white" >Edit Page</h4>
                     </header>
                     <div class="card-body">  
                         <form method="post" action="{{URL::to('/admin/menus_items/update/'.Crypt::encryptString($model->id))}}">
                             @csrf
                                
                                    <div class="form-group">
                                        <label class="form-label">Parent Menu</label>
                                        <select disabled class="form-control" name="parent_id">
                                            <option value="">None</option>
                                            {!! $dropdowns !!}
                                        </select>
                                    </div>
                
                                     <div class="form-group">
                                         <label class="form-label" >Title</label>
                                         <input required name="title" 
                                           class="form-control" 
                                           value="{{$model->title}}"
                                           placeholder="Title">
                                     </div>

                                     <div class="form-group">
                                        <label class="form-label" >Sort</label>
                                        <input required type="number" name="sort" value="{{$model->sort}}" 
                                        class="form-control" placeholder="sort" />
                                    </div>

                                     <div class="form-group">
                                        <label class="form-label" >Link</label>
                                        <input required name="link" 
                                        value="{{$model->link}}"
                                        class="form-control" placeholder="Link" /> 
                                    </div>

                                     <div class="form-group">
                                        <label class="form-label">SubTitle</label>
                                        <input name="subtitle" 
                                          class="form-control" 
                                          value="{{$model->subtitle}}"
                                          placeholder="SubTitle">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Open In</label>
                                        <select class="form-control" name="target" >
                                            <option  value="">Existing</option>
                                            <option @if($model->target == "_blank") {{'selected'}} @endif value="_blank">New Tab</option>
                                        </select>
                                    </div>
                                                         
                                    <div class="text-center" >
                                        <button type="submit" class="btn btn-info text-white">Update</button>
                                    </div>
                             </form>
                          </div>
                       </section>
                  </div>
                 
            </div> 

      

 @endsection
 @section('js')



       <script>

        let level = "{{request()->level}}";
    
        $(function () {

            // if(level == 1){

            //     $('[data-level="3"]').attr('disabled', 'true');
            // }else if(level == 2){
                
            //     $('[data-level="3"]').attr('disabled', 'true');
            // }else{

            //     $('[data-level="3"]').attr('disabled', 'true');

            // }       
           
    
      });
    </script>
@endsection