@extends('admin.layout')
@section('css')
<link href="{{asset('admin/assets/node_modules/switchery/dist/switchery.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin/assets/node_modules/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
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

   

   .gallery-box{

   }

   .select2-container{
    width: 100%!important;
   }

   .select2-dropdown {
    z-index: 1124!important;
   }

</style>
<?php 
// dd()
?>
<link href="{{asset('admin/assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" />
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<link href="{{asset('admin/assets/css/pages/user-card.css')}}" rel="stylesheet">
<link href="{{asset('admin/assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">ADD YOUR PRODUCT 
        </h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <form method="post" action="{{URL::to('admin/products/update/'.Crypt::encryptString($product->id))}}" >
            @csrf

            <div class="row">
                <div class="col-md-9">
                    <section class="card">
                        <header class="card-header bg-info">
                            <h4 class="mb-0 text-white" >General Details</h4>
                        </header>
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" >Title</label>
                                            <input type="text" value="{{$product->title}}" name="title" class="title form-control" 
                                            placeholder="Title">
                                            @if($errors->has('title'))
                                             <p class="invalid-feedback" >{{ $errors->first('title') }}</p>
                                            @endif 
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Slug</label>
                                            <input type="text" value="{{$product->slug}}" name="slug" class="slug form-control" 
                                            placeholder="Slug">
                                            @if($errors->has('slug'))
                                             <p class="invalid-feedback" >{{ $errors->first('slug') }}</p>
                                            @endif 
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Price</label>
                                            <input type="text" value="{{$product->price}}" name="price" class="form-control" 
                                            placeholder="Price">
                                            @if($errors->has('price'))
                                            <p class="invalid-feedback" >{{ $errors->first('price') }}</p>
                                            @endif 
                                        </div>
                                    </div>
    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Selling Price</label>
                                            <input type="text" value="{{$product->selling_price}}" name="selling_price" class="form-control" 
                                            placeholder="Selling Price">
                                            @if($errors->has('selling_price'))
                                            <p class="invalid-feedback" >{{ $errors->first('selling_price') }}</p>
                                            @endif 
                                        </div>
                                    </div>

                             </div>
                        </div>
                    </section>


            
                 <section class="card variation_box">
                        <header class="card-header bg-info">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="mb-0 text-white">Variations</h4>
                                </div>
                                <div class="col-6">
                                    <div class="button-box text-end">
                                        <button style="background: transparent;
                                        border: none;" type="button" class="text-white menu-button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-whatever="@mdo">Add variations</button>
                                    </div>
                                </div>
                            </div>
                        </header>
                        <div class="card-body variations ">
                            <div class="table-responsive">

                            
                           <table class="table" >
                            <thead>
                                <tr>
                                    <th>Sku</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Thumbnail</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->variations as $key => $variation)
                                <tr>
                                    <td>
                                        <input type="hidden" 
                                           name="variation[{{$key}}][id]" 
                                           class="form-control" 
                                           value="{{$variation->id}}" />
                                        <input style="width: 124px;" readonly name="variation[{{$key}}][sku]" 
                                           class="form-control" 
                                           value="{{$variation->sku}}" />
                                    </td>
                                    <td><input required name="variation[{{$key}}][quantity]" class="form-control" 
                                        style="width: 70px;" value="{{$variation->quantity}}" /></td>
                                    <td><input style="width: 70px;" required name="variation[{{$key}}][price]" class="form-control" 
                                        value="{{$variation->price}}" /></td>
                                    <td><input style="width: 70px;" name="variation[{{$key}}][thumbnail]" class="form-control" 
                                        value="{{$variation->image}}" /></td>
                                    <td>
                                        <a class="btn btn-danger" 
                                         href="{{URL::to('admin/products/remove-variation/'.$variation->id)}}" 
                                         >Remove</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                           </table>
                        </div>
                        </div>
                    </section>

                    @include('admin.products.description')
                    @include('admin.products.gallery')
                    @include('admin.products.seo')                    

                </div>
                <div class="col-md-3">
                
                    @include('admin.products.thumbnail')
                    @include('admin.products.collections')
                    @include('admin.products.category')
                    @include('admin.products.tags')
                    @include('admin.products.details')
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


<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{URL::to('/admin/products/variations/'.Crypt::encryptString($product->id))}}">
                @csrf
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Generate Variations</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                    @foreach ($attributes as $attribute)
                        <div class="">
                            <label class="form-label">{{$attribute->title}}:</label>
                            <select  multiple 
                            class="attributes select2" 
                            name="attr[{{$attribute->id}}][]" >
                                @foreach ($attribute->values as $option)
                                <option value="{{$option->id}}">{{$option->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                    
                    <div class="f pt-3">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success text-white">Update</button>
                    </div>
              </div>
             </div>
          </form>
        </div>
    </div>
</div>
<!-- /.modal -->

@endsection

@section('js')



<script src="{{asset('admin/assets/node_modules/switchery/dist/switchery.min.js')}}"></script>
<script src="{{asset('admin/assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}">
</script>
<script src="{{asset('admin/assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup.min.js')}}">
</script>
<script src="{{asset('admin/assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup-init.js')}}"></script>
<script src="{{asset('admin/assets/node_modules/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>

<script>
     $(function () {
        

           $(".select2").select2();

            ClassicEditor.create(document.querySelector('#long_description')).catch(error => {
                console.error(error);
            });
           

            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function () {
                new Switchery($(this)[0], $(this).data());
            });


            $('.add_image').click(function(){
                     var id = Math.random().toString(16).slice(2);
                     $('.gallery-box').append(`<div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="el-card-item mb-0 pb-0">
                                <label class="form-label" >File Code</label>
                                <input class="form-control" type="text" 
                                name="gallery[${id}]" />                     
                                </div>
                            </div>
                    </div>`);
            });

        $(".title").keyup(function() {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
            $(".slug").val(Text);        
        });

        // $(".type").change(function() {

        //     var type = $(this).val();
        //     if(type == 'single'){
        //         $('.variation_box').hide();
        //         $('.single_box').show();
        //     }else{
        //         $('.variation_box').show();
        //         $('.single_box').hide();
        //     }
        // }).trigger('change');

        
            
    });  
    function handleCategoryChange(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];

 
        const categorySlug = selectedOption.getAttribute('data-slug');

    
        if (categorySlug === 'car') {
            console.log("Car category selected. Perform the desired action here.");
            getSubCategories();
        } else {
            console.log("Other category selected.");
        }
    }  

    function getSubCategories() {
        let categoryId = document.getElementById("category_id").value;
        let additionalFields = document.getElementById("additional-fields");
        console.log(categoryId,additionalFields);
        // Hide all additional fields by default
        additionalFields.style.display = "block";

    }
</script>
    
@endsection