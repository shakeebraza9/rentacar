@extends('theme.layout')

@php
//dd($model)

@endphp

@section('metatags')

@endsection
@section('css')

@endsection
@section('content')




<main class="main">
    <div>

        <div class="container my-5">
            <div class="text-center">
                <h2>Meet Our Team</h2><br>
                {!! getset('our_team') !!}
                <br>
                <div class="row mt-3 gy-4">
                    @foreach($members as $member)
                        <div class="col-md-3 text-center">
                            <img src="{{ asset($member->image->path) }}"
                                 class="img-fluid mx-auto"
                                 style="width:180px; height:180px; object-fit:cover;"
                                 alt="{{ $member->name }}">
                            <div class="fw-bold h5 mt-3 mb-0">{{ $member->name }}</div>
                            <div class="title">{{ $member->position }}</div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</main>
@endsection
@section('js')



@endsection

