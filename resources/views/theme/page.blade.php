@extends('theme.layout')

@php
  //dd($model)

@endphp

@section('metatags')
    <title>{{$pageData->title ?? ''}}</title>
    <meta name="description" content="{{$pageData->meta_description ?? ''}}">
    <meta name="keywords" content="{{$pageData->meta_keywords ?? ''}}">
@endsection
@section('css')
<style>


        p {
            font-size: 16px;
            margin-bottom: 15px;
            text-align: justify;
        }


</style>
@endsection
@section('content')




<main class="main">
    <div class="container">
        @if ($page->title != 'Terms and Conditions')
        <h1 class="my-4">{{ $page->title }}</h1>

        @endif
        {!! $page->content !!}

    </div>
</main>
@endsection
@section('js')



@endsection
