@extends('theme.layout')

@php

@endphp

@section('metatags')
    <title>{{$product->title}}</title>
    <meta name="description" content="{{$global_d['blog_meta_description'] ?? ''}}">
    <meta name="keywords" content="{{$global_d['blog_keywords'] ?? ''}}">

    
@endsection
@section('css')

<style>
    .product-info p span {
       padding-left: 0px!important;   
    }
</style>
  

@endsection
@section('content')
<div id="page-content" class="template-product">

   <!-- Bredcrumbs -->
   <div class="bredcrumbWrap bredcrumb-style2">
      <div class="container breadcrumbs">
          <a href="{{URL::to('/')}}" title="Back to the home page">Home</a>
          <span aria-hidden="true">|</span>
          <a href="{{URL::to('/shop')}}" title="Back to the home page">Shop</a>
          <span aria-hidden="true">|</span>
          <span class="title-bold">{{$product->title}}</span>
      </div>
   </div>
  <!-- End Bredcrumbs -->

  <div class="container">

  <div id="ProductSection-product-template" class="product-template__container prstyle2">
   
    <!-- #ProductSection product template -->
    <div class="product-single product-single-1">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="product-details-img product-single__photos bottom">
                  
                  <!-- Product Images -->
                    <div class="zoompro-wrap product-zoom-right pl-20">
                        <div class="zoompro-span">
                            <img class="blur-up lazyload zoompro" 
                            data-zoom-image="{{asset($product->get_thumbnail ? 'public/'.$product->get_thumbnail->path : '')}}"  
                            src="{{asset($product->get_thumbnail ? 'public/'.$product->get_thumbnail->path : '')}}" />               
                        </div>
                   
                        <div class="product-buttons">
                            <a href="https://www.youtube.com/watch?v=93A2jOW5Mog" class="btn popup-video" data-bs-toggle="tooltip" data-bs-placement="left" title="Watch Video"><i class="icon an an-play" aria-hidden="true"></i></a>
                            
                            <a href="#" class="btn prlightbox" data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom Image"><i class="icon an an-expand-arrows-alt" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="product-thumb product-thumb-1">
                        <div id="gallery" class="product-dec-slider-1 product-tab-left">
                       
                          @foreach ($product->get_gallery() as $img) 
                            <a  data-image="{{asset('public/'.$img->path)}}" 
                                data-zoom-image="{{asset('public/'.$img->path)}}" 
                                class="slick-slide slick-cloned active" 
                                data-slick-index="-4" 
                                aria-hidden="true" 
                                tabindex="-1">
                                <img class="blur-up lazyload" src="{{asset('public/'.$img->path)}}"/>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="lightboximages">
                        @foreach ($product->get_gallery() as $img) 
                        <a href="{{asset('public/'.$img->path)}}" data-size="1462x2048"></a>
                        @endforeach
                    </div>
                    <!-- End Product Images -->


                    <!-- Wishlist - Share -->
                    <div class="display-table shareRow pt-3 pb-0 d-table">
                        <div class="display-table-cell text-center align-top">
                            <div class="social-sharing">
                                <a class="btn btn--small btn--secondary btn--share share-facebook" data-bs-toggle="tooltip" data-bs-placement="top" title="Share on Facebook">
                                    <i class="icon an an-facebook" aria-hidden="true"></i><span class="share-title" aria-hidden="true">Facebook</span>
                                </a>
                                <a class="btn btn--small btn--secondary btn--share share-twitter" data-bs-toggle="tooltip" data-bs-placement="top" title="Tweet on Twitter">
                                    <i class="icon an an-twitter" aria-hidden="true"></i><span class="share-title" aria-hidden="true">Tweet</span>
                                </a>
                                <a class="btn btn--small btn--secondary btn--share share-google" data-bs-toggle="tooltip" data-bs-placement="top" title="Share on google+">
                                    <i class="icon an an-google-plus" aria-hidden="true"></i><span class="share-title" aria-hidden="true">Google+</span>
                                </a>
                                <a class="btn btn--small btn--secondary btn--share share-pinterest" data-bs-toggle="tooltip" data-bs-placement="top" title="Pin on Pinterest">
                                    <i class="icon an an-pinterest-p" aria-hidden="true"></i><span class="share-title" aria-hidden="true">Pin it</span>
                                </a>
                                <a class="btn btn--small btn--secondary btn--share share-email" data-bs-toggle="tooltip" data-bs-placement="top" title="Share by Email">
                                    <i class="icon an an-envelope" aria-hidden="true"></i><span class="share-title" aria-hidden="true">Email</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- End Wishlist - Share -->
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <!-- Product Info -->
                <div class="product-single__meta">
                    <h1 class="product-single__title">{{$product->title}}</h1>
                    
                    <!-- Product Reviews -->
                    <div class="prInfoRow d-flex flex-wrap">
                        <div class="product-review">
                            <a class="reviewLink d-flex flex-wrap align-items-center" >
                                <i class="an an-star"></i>
                                <i class="an an-star"></i>
                                <i class="an an-star"></i>
                                <i class="an an-star"></i>
                                <i class="an an-star-half-alt"></i>
                                <span class="spr-badge-caption">6 reviews</span>
                            </a>
                        </div>
                    </div>
                    <!-- End Product Reviews -->

                    <!-- Product Price -->
                    <div class="product-single__price product-single__price-product-template">
                        <span class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
                            <span id="ProductPrice-product-template">
                              <span class="money">
                                @if($product->selling_price)
                                    <span class="old-price" style="font-size: 20px;">
                                        {{$global_d['site_currency']}} {{$product->selling_price}}
                                    </span>
                                @endif
                                <span class="r-price" >{{$product->price}}</span>
                              </span>
                            </span>
                        </span>
                    </div>
                    <!-- End Product Price -->

                    <!-- Product Description -->
                    <div class="product-single__description rte">
                        <p class="mb-2">{{$product->short_des}}</p>
                    </div>
                    <!-- End Product Description -->

                    <!-- Product Intro -->
                    <div class="product-info">
                      <p class="product-stock">Availability: 
                        <span class="instock">In Stock</span>
                        <span class="outstock hide">Unavailable</span>
                      </p> 
                      <p class="product-sku">SKU: 
                        <span class="variant-sku">.</span>
                      </p>
                    </div>
                   <!-- End Product Intro -->
          
                    <!-- Form -->
                    <form method="post" 
                     action="{{URL::to('/cart/add_to_cart')}}" 
                     id="product_form_10508262282" 
                     accept-charset="UTF-8" 
                     class="product-form product-form-product-template product-form-border hidedropdown" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="product_id" value="{{Crypt::encryptString($product->id)}}" />
                        <input type="hidden" name="sku" />
                        <input type="hidden" name="price" />

                    
                          @foreach ($attributes as $key => $attribute)
                          <?php 
                            $rowKey = 0;
                           ?>
                            <div class="swatch clearfix swatch-1 option2 w-100" 
                                data-option-index="1">
                              <div class="product-form__item" 
                                 data-attribute-id="{{$attribute['id']}}">
                                  <label>{{$attribute['title']}}:</label>
                                  @foreach ($values as $value)
                                  @if($value['attribute_id'] == $attribute['id'])
                                    <div data-value="{{$value['id']}}" 
                                         class="swatch-element {{$value['title']}} available">
                                         
                                         <input 
                                           class="variation_change swatchInput"
                                           @if($rowKey == 0) checked @endif 
                                           id="variation_id-{{$value['id']}}" 
                                           type="radio" 
                                           name="attr[{{$attribute['id']}}]" 
                                           value="{{$value['id']}}" />
                                            
                                         <label class="swatchLbl medium" 
                                            for="variation_id-{{$value['id']}}" 
                                            data-bs-toggle="tooltip" 
                                            data-bs-placement="top" 
                                            title="{{$value['title']}}">{{$value['title']}}</label>
                                    
                                    </div>
                                    <?php 
                                      $rowKey += 1;
                                    ?>
                                    @endif
                                  @endforeach
                              </div>
                          </div>    
                          @endforeach
                                              
                        <!-- Product Action -->
                        <div class="product-action clearfix">
                            <div class="product-form__item--quantity">
                                <div class="wrapQtyBtn">
                                    <div class="qtyField">
                                        <a class="qtyBtn minus" 
                                             href="javascript:void(0);">
                                            <i class="icon an an-minus" aria-hidden="true"></i>
                                        </a>
                                        <input 
                                            type="text" 
                                            name="quantity" 
                                            value="1" 
                                            class="variation_change product-form__input qty" />
                                           <a class="qtyBtn plus" href="javascript:void(0);">
                                            <i class="icon an an-plus" aria-hidden="true"></i>
                                           </a>
                                    </div>
                                </div>
                            </div>                                
                            <div class="product-form__item--submit">
                                    <button 
                                    name="cart-type"
                                    type="button" 
                                    value="cart"
                                    class="btn product-form__cart-submit">
                                    <span>Add to cart</span>
                                    </button>
                            </div>
                            <div class="payment-button" data-shopify="payment-button">
                                    <button 
                                        name="cart-type" 
                                        value="buy" 
                                        type="button" 
                                        class="payment-button__button payment-button__button--unbranded">
                                        Buy it now
                                    </button>
                            </div>
                        </div>
                    </form>
                    <!-- End Form -->


                    <!-- Product Feature -->
                    <div class="safecheckout row my-3">
                        <div class="item col-lg-3 mb-1 mb-sm-0">
                            <div class="icon"><i class="icon an an-truck"></i></div>
                            <div class="content">Free & fast shipping</div>
                        </div>
                        <div class="item col-lg-3 mb-1 mb-sm-0">
                            <div class="icon"><i class="icon an an-certificate"></i></div>
                            <div class="content">Secure checkout</div>
                        </div>
                        <div class="item col-lg-3">
                            <div class="icon"><i class="icon an an-thumbs-up"></i></div>
                            <div class="content">Satisfaction guarantee</div>
                        </div>
                        <div class="item col-lg-3">
                            <div class="icon"><i class="icon an an-lock"></i></div>
                            <div class="content">Privacy protected</div>
                        </div>
                    </div>
                    <!-- End Product Feature -->

                </div>
            </div>
        </div>
        <!-- End Product single -->

                @include('theme.product.tabs')

            </div>
        </div>
        <!-- End Main Content -->

        @include('theme.product.releated')

  </div>
</div>
@endsection
@section('js')

<script> 


   let arrays = [];
   let json  = '<?php echo json_encode($variations);?>';
   const variations = JSON.parse(json);
  


    $(".qtyBtn").on("click", function () {
           
        var qtyField = $(this).parent(".qtyField");
        var oldValue = $(qtyField).find(".qty").val();
        var newVal = 1;

            if ($(this).is(".plus")) {
                newVal = parseInt(oldValue) + 1;
            } else if (oldValue > 1) {
                newVal = parseInt(oldValue) - 1;
            }
            $(qtyField).find(".qty").val(newVal);
            $(qtyField).find(".qty").trigger('change');
    });

</script>

        <!-- Photoswipe Gallery -->
        <script src="{{asset('public/theme/assets/js/vendor/photoswipe.min.js')}}"></script>
        <script src="{{asset('public/theme/assets/js/vendor/photoswipe-ui-default.min.js')}}"></script>
        <script>
            $(function () {


                var $pswp = $('.pswp')[0],
                        image = [],
                        getItems = function () {
                            var items = [];
                            $('.lightboximages a').each(function () {
                                var $href = $(this).attr('href'),
                                        $size = $(this).data('size').split('x'),
                                        item = {
                                            src: $href,
                                            w: $size[0],
                                            h: $size[1]
                                        }
                                items.push(item);
                            });
                            return items;
                        }
                var items = getItems();

                $.each(items, function (index, value) {
                    image[index] = new Image();
                    image[index].src = value['src'];
                });
                $('.prlightbox').on('click', function (event) {
                    event.preventDefault();

                    var $index = $(".active-thumb").parent().attr('data-slick-index');
                    $index++;
                    $index = $index - 1;

                    var options = {
                        index: $index,
                        bgOpacity: 0.9,
                        showHideOpacity: true
                    }
                    var lightBox = new PhotoSwipe($pswp, PhotoSwipeUI_Default, items, options);
                    lightBox.init();
                });
            });
        </script>

        <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="pswp__bg"></div>
            <div class="pswp__scroll-wrap"><div class="pswp__container"><div class="pswp__item"></div><div class="pswp__item"></div><div class="pswp__item"></div></div><div class="pswp__ui pswp__ui--hidden"><div class="pswp__top-bar"><div class="pswp__counter"></div><button class="pswp__button pswp__button--close" title="Close (Esc)"></button><button class="pswp__button pswp__button--share" title="Share"></button><button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button><button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button><div class="pswp__preloader"><div class="pswp__preloader__icn"><div class="pswp__preloader__cut"><div class="pswp__preloader__donut"></div></div></div></div></div><div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap"><div class="pswp__share-tooltip"></div></div><button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button><button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button><div class="pswp__caption"><div class="pswp__caption__center"></div></div></div></div>
        </div>



        <script>
            $(function(){

                $('.variation_change').change(function(e){ 
                   
                   let forms = {
                     qty:$('.qty').val(),
                     variations:[],
                   };
 
                    $('.product-form__item').each(function () {
                        let el = $(this);
                        let attribute_id =  el.attr('data-attribute-id');
                        var selectedValue = $(this).find('input[type="radio"]:checked').val();
                        forms.variations.push({
                            'attribute':attribute_id,
                            'value':selectedValue,
                         });
                    });

                    var groupedBySku = variations.reduce(function (result, obj) {
                        var key = obj.sku;
                        result[key] = result[key] || [];
                        result[key].push(obj);
                        return result;
                    }, {});

                    var findSku = false;
                    var selectedAtributes = forms.variations.map(obj =>  Number(obj.value));
                    for (const key in groupedBySku) {

                        if (groupedBySku.hasOwnProperty(key)) {
                          
                            const item = groupedBySku[key];
                            let is_found_sku = [];
                            item.forEach(element => {  
                                
                                if(selectedAtributes.includes(element.value_id)){
                                    is_found_sku.push(1);
                                }else{
                                    is_found_sku.push(0);
                                } 
                            });
                            if(is_found_sku.includes(0) == false){
                                findSku = item.pop();
                            }
                       }
                    }

                    if(findSku){

                        $('.variant-sku').text(findSku.sku);
                        $('.r-price').text("{{$global_d['site_currency']}} "+findSku.price);
                        $('.instock').text('In Stock');
                        $('.instock').css('color','green');
                        $('.product-form__item--quantity').show();
                        $("[name='price']").val(findSku.price);
                        $("[name='sku']").val(findSku.variation_id);

                    }else{
                        
                        $('.product-form__item--quantity').hide();
                        $('.product-form__item--quantity .qty').val(0);
                        $('.instock').text('Out Of Stock');
                        $('.instock').css('color','red');
                        $('.variant-sku').text('-');
                        $('.r-price').text('-');
                        $("[name='price']").val('');
                        $("[name='sku']").val('');
                    }


                });

                $('.variation_change').trigger('change');



               



            });
        </script>

@endsection