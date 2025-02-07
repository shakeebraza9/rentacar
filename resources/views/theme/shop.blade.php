@extends('theme.layout')

@php
  //dd($product)
    
@endphp

@section('metatags')
    <title>Shop</title>
    <meta name="description" content="{{$global_d['blog_meta_description'] ?? ''}}">
    <meta name="keywords" content="{{$global_d['blog_keywords'] ?? ''}}">
@endsection
@section('css')

<style>

.pager{
                list-style: none;
                display: flex;
                justify-content: center;
            }

            .pager li{
                margin: 0px 6px;
            }

            .pager .active span {
                color: #fb9678!important;
            }

            .pager li a{
                color:#212529;
            }


</style>
  
@endsection
@section('content')
<div id="page-content" class="template-collection">

   <!-- Bredcrumbs -->
   <div class="bredcrumbWrap bredcrumb-style2">
      <div class="container breadcrumbs">
          <a href="{{URL::to('/')}}" title="Back to the home page">Home</a>
          <span aria-hidden="true">|</span>
          <a href="{{URL::to('/shop')}}" title="Back to the home page">Shop</a>
      </div>
   </div>
  <!-- End Bredcrumbs -->

    <!-- Collection Banner -->
    <div class="collection-header">
      <div class="collection-hero">
          <div class="collection-hero__image blur-up lazyload" 
          style="background-image:url('{{asset('public/theme/assets/images/collection/women-collection-bnr.jpg')}}');"></div>
          <div class="collection-hero__title-wrapper">
            <h1 class="collection-hero__title page-width">Shop</h1></div>
      </div>
  </div>
  <!-- End Collection Banner -->


  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-3 col-lg-3 sidebar filterbar">
        <div class="closeFilter d-block d-md-block d-lg-none"><i class="icon an an-times"></i></div>
        <div class="sidebar_tags">

            <form action="{{URL::to('/shop')}}">
                <div class="input-group mb-3">
                    <input type="text" 
                        class="form-control"
                        name="search"
                        value="{{request()->has('search') ? request()->search : ''}}" 
                        placeholder="Search Here" />
                    <button type="submit" style="background:black;color:white;" 
                    class="input-group-text">
                    <i class="icon an an-search"></i>
                    </button>     
                </div>
            </form>

            <!-- Categories -->
            <div class="sidebar_widget filterBox categories filter-widget">
                <div class="widget-title"><h2>Categories</h2></div>
                <div class="widget-content">
                    <ul class="sidebar_categories">

                        @foreach($categories as $category)
                        <?php $subcats = $category->children; ?>

                           <li class="level1 {{count($subcats) ? 'sub-level' : '' }}">
                            <a  @if(count($subcats) == 0) 
                                href="{{URL::to('/shop?category=')}}{{$category->slug}}"
                                @endif 
                                class="site-nav"> {{ $category->title }} </a>

                                @if(count($subcats))
                                    <ul class="sublinks">
                                        @foreach($subcats as $child)
                                            <li class="level2" >
                                              <a href="{{URL::to('/shop?category=')}}{{$child->slug}}" class="site-nav"> {{ $child->title }} </a>
                                                @if(count($child->children))
                                                    <ul>
                                                        @foreach($child->children as $subchild)
                                                            <li>{{ $subchild->title }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- End Categories -->

            <!-- Price Filter -->
            <!-- <div class="sidebar_widget filterBox filter-widget">
                <div class="widget-title">
                    <h2>Price</h2>
                </div>
                <form action="#" method="post" class="price-filter widget-content">
                    <div id="slider-range" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                        <div class="ui-slider-range ui-widget-header ui-corner-all"></div>
                        <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                        <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="no-margin"><input id="amount" type="text" /></p>
                        </div>
                        <div class="col-6 text-end margin-25px-top">
                            <button class="btn btn-secondary btn--small">filter</button>
                        </div>
                    </div>
                </form>
            </div> -->
            <!-- End Price Filter -->

              <!-- Categories -->
              <div class="sidebar_widget filterBox categories filter-widget">
                <div class="widget-title"><h2>Collections</h2></div>
                <div class="widget-content">
                    <ul class="sidebar_categories">
                        @foreach($collections as $collection)
                           <li class="level1 ">
                            <a href="{{URL::to('/shop?collection=')}}{{$collection->slug}}"
                                class="site-nav"> {{ $collection->title }} </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- End Categories -->

          

      

            <!-- Vendors -->
            <div class="d-none sidebar_widget filterBox filter-widget">
                <div class="widget-title"><h2>Vendors</h2></div>
                <div class="widget-content">
                    <ul class="widget-vendors">
                        <li>
                            <input type="checkbox" value="allen-vela" id="1532947863384-0" />
                            <label for="1532947863384-0"><span><span></span></span>Allen Vela</label>
                        </li>
                        <li>
                            <input type="checkbox" value="famiza" id="1532947863384-2" />
                            <label for="1532947863384-2"><span><span></span></span>Famiza</label>
                        </li>
                        <li>
                            <input type="checkbox" value="oxymat" id="1532947863384-4" />
                            <label for="1532947863384-4"><span><span></span></span>Oxymat</label>
                        </li>
                        <li>
                            <input type="checkbox" value="vanelas" id="1532947863384-6" />
                            <label for="1532947863384-6"><span><span></span></span>Vanelas</label>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End Vendors -->

            <!-- Banner -->
            <div class="sidebar_widget static-banner">
                <a href="#"><img class="blur-up lazyload" data-src="{{asset('public/theme/assets/images/side-banner-2.jpg')}}" src="{{asset('public/theme/assets/images/side-banner-2.jpg')}}" alt="image" /></a>
            </div>
            <!-- End Banner -->

        </div>
    </div>
    <!-- End Sidebar -->

     <div class="col-12 col-sm-12 col-md-12 col-lg-9 main-col">
      <div class="productList">
        <!-- Toolbar -->
        <div class="toolbar">
            <div class="filters-toolbar-wrapper">
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-6 filters-toolbar__item collection-view-as d-flex justify-content-Start align-items-center">
                        <button type="button" class="btn-filter d-block d-md-block d-lg-none icon an an-sliders-h" data-bs-toggle="tooltip" data-bs-placement="top" title="Filters"></button>
                        Showing {{ $data->firstItem() }} - {{ $data->lastItem() }} of {{ $data->total() }}
                    </div>
                    
                    <div class="col-6 col-md-6 col-lg-6 d-flex justify-content-end align-items-center text-end">
                        <div class="filters-toolbar__item">
                            <label for="SortBy" class="hidden">Sort</label>
                            <select name="SortBy" id="SortBy" class="filters-toolbar__input filters-toolbar__input--sort">
                                <option value="title-ascending" selected="selected">Sort</option>
                                <option>Best Selling</option>
                                <option>Alphabetically, A-Z</option>
                                <option>Alphabetically, Z-A</option>
                                <option>Price, low to high</option>
                                <option>Price, high to low</option>
                                <option>Date, new to old</option>
                                <option>Date, old to new</option>
                            </select>
                            <input class="collection-header__default-sort" type="hidden" value="manual">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Toolbar -->

        <div class="grid-products grid--view-items product-three-load-more">
          <div class="row">
            @foreach ($data as $item)    
            <?php 
            $thumb = $item->get_thumbnail ? asset('public/'.$item->get_thumbnail->path) : '';
            $img_hover = $item->get_hover_image ? asset('public/'.$item->get_hover_image->path) : '';
         ?>
              <div class="col-6 col-sm-6 col-md-4 col-lg-4 item">
                  <div class="product-image">
                      <a href="{{URL::to('/products')}}/{{$item->slug}}">
                          <img class="primary blur-up lazyload" 
                          data-src="{{asset($item->get_thumbnail ? asset('public/'.$item->get_thumbnail->path) : '')}}" 
                          src="{{asset($item->get_thumbnail ? asset('public/'.$item->get_thumbnail->path) : '')}}" 
                          alt="image" 
                          title="product" />

                          <img class="hover blur-up lazyload" 
                            data-src="{{asset($item->get_hover_image ? asset('public/'.$item->get_hover_image->path) : '')}}" 
                            src="{{asset($item->get_hover_image ? asset('public/'.$item->get_hover_image->path) : '')}}" 
                            alt="image" 
                            title="product" />
                          
                      </a>
                  </div>
                
                  <div class="product-details text-center">
                      <div class="product-name">
                          <a href="{{URL::to('/products')}}/{{$item->slug}}">{{$item->title}}</a>
                      </div>
                      <div class="product-price">
                          <span class="old-price">{{$global_d['site_currency']}} {{$item->selling_price}}</span>
                          <span class="price">{{$global_d['site_currency']}} {{$item->price}}</span>
                      </div>
                      <div class="product-review">
                          <i class="an an-star"></i>
                          <i class="an an-star"></i>
                          <i class="an an-star"></i>
                          <i class="an an-star"></i>
                          <i class="an an-star-half-alt"></i>
                      </div>
                  </div>
                </div>
              @endforeach

              <div class="col-12 pt-5">
                <div class="paginate text-center">
                    {{ $data->links('pagination.custom') }}
                  </div>
              </div>

            

            </div>
          </div>
        </div>
      </div>
        
      

      </div>
    </div>
  
  

    </div>
  </div>




</div>
@endsection
@section('js')



@endsection