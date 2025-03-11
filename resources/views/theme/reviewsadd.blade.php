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
<style>
    .rating {
        direction: rtl; /* Right to Left to make the last star clickable first */
        display: flex;
        justify-content: center;
        font-size: 2rem;
        gap: 5px;
    }
    .rating input {
        display: none;
    }
    .rating label {
        color: #ccc;
        cursor: pointer;
        transition: color 0.3s ease-in-out;
    }
    .rating input:checked ~ label,
    .rating label:hover,
    .rating label:hover ~ label {
        color: gold;
    }
</style>
@endsection
@section('content')

<div class="container mt-6 mb-6">
    <h2>Review Product: {{ $product->title }}</h2>

    <form action="{{ route('product.submitReview') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <!-- Star Rating System -->
        <div class="form-group text-center">
            <label class="d-block font-weight-bold mb-2">Rating:</label>
            <div class="rating">
                <input type="radio" name="rating" id="star5" value="5"><label for="star5">★</label>
                <input type="radio" name="rating" id="star4" value="4"><label for="star4">★</label>
                <input type="radio" name="rating" id="star3" value="3"><label for="star3">★</label>
                <input type="radio" name="rating" id="star2" value="2"><label for="star2">★</label>
                <input type="radio" name="rating" id="star1" value="1"><label for="star1">★</label>
            </div>
        </div>

        <!-- Review Text Area -->
        <div class="form-group mt-3">
            <label for="review" class="font-weight-bold">Your Review:</label>
            <textarea name="review" id="review" class="form-control" rows="4" placeholder="Write your thoughts here..."></textarea>
        </div>
        <input type="hidden" value="{{ $product->title }}">
        <input type="hidden" value="{{ $product->id }} ">

        <!-- Submit Button -->
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success btn-lg px-4">Submit Review</button>
        </div>
    </form>
</div>
@endsection
@section('js')



@endsection
