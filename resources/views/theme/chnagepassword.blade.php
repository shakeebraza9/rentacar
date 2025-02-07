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

<?php
?>
<main class="main">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md">
                        <h3>Change Password</h3>
                    </div>
                    <div class="col-md-auto">
                        <a href="{{ route('customer.profile') }}">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="mt-4">
                    <form method="POST" action="{{ route('customer.changePassword') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="current-password">Current Password</label>
                            <input class="form-control" type="password" name="current_password" id="current-password" required>
                            @error('current_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password">New Password</label>
                            <input class="form-control" type="password" name="password" id="password" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password">Confirm Password</label>
                            <input class="form-control" type="password" name="password_confirmation" id="confirm-password" required>
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection
@section('js')



@endsection