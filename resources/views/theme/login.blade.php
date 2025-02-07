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
                    <img src="{{ asset(getset('logo')) }}" class="logo mb-4 mx-5 mx-md-0" alt="">
                    <h4 class="mb-4">Sign in</h4>
                </div>
                <div class="mb-4"></div>
                <form method="post" accept-charset="utf-8" action="{{ route('webpostlogin') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror"
                               type="email"
                               name="email"
                               placeholder="traveller@mail.com"
                               id="email"
                               value="{{ old('email') }}" />
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input class="form-control @error('password') is-invalid @enderror"
                               type="password"
                               name="password"
                               placeholder="* * * * *"
                               id="password" />
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-control" type="hidden" name="remember_me" value="0" />
                            <input class="form-check-input" type="checkbox" name="remember_me" value="1" id="remember-me" />
                            <label for="remember-me" class="form-check-label">Remember me</label>
                        </div>
                    </div>

                    <input type="submit" class="btn btn-primary btn-block" value="Login">
                </form>

                <hr class="my-4">
                <a href="{{ route('forgotpassword') }}" class="link-dark">Forgot password?</a>
                <a href="{{ route('register') }}" class="link-dark register d-block">Not a member? Sign up here</a>
                <a href="{{ route('home') }}" class="link-dark d-block mt-4">
                    <i class="fa fa-arrow-left"></i> Back to home
                </a>
            </div>
        </div>
    </div>
</div>

</main>
@endsection
