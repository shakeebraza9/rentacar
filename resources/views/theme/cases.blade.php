@extends('theme.layout')

@php
  //dd($product)
    
@endphp

@section('metatags')
    <title>Cart</title>
    <meta name="description" content="{{$global_d['blog_meta_description'] ?? ''}}">
    <meta name="keywords" content="{{$global_d['blog_keywords'] ?? ''}}">
@endsection
@section('css')
  
@endsection
@section('content')

<?php 
//dd($carts);
?>
<main class="main">
    <div>
                    
<div class="container my-5">
<div class="row mb-4">
    <div class="card rounded-3">
        <div class="card-body">
            <div class="row mt-2"><h4>Cases</h4></div>
            <hr class="mt-1">

                                <div class="mt-4 text-center fst-italic">
                    No Records Available                    </div>
                        </div>
    </div>
</div>
</div>        </div>
</main>
@endsection
@section('js')



@endsection