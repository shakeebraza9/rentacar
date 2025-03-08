@extends('theme.layout')

@php
//dd($users);
@endphp

@section('metatags')
<title>{{$global_d['site_title']}}</title>
@endsection

@section('css')

<style>
    .row {

        justify-content: center;
    }

</style>

@endsection
@section('content')
<div class="my-4 my-md-5">
    <div class="container">
        <div class="card card-auth shadow">
            <div class="card-body p-4 p-md-5">
                <div class="text-center">
                    <h4 class="mb-4">Reset Password</h4>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input class="form-control" type="email" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input class="form-control" type="password" name="password" placeholder="New password" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm password" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                </form>

                <hr class="my-4">
                <a href="{{ route('login') }}" class="link-dark">
                    <i class="fa fa-arrow-left"></i> Back to Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
