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
                    <img src="{{ asset('filemanager/67af8dab6232c.png') }}" class="logo mb-4 mx-5 mx-md-0" alt="Logo">
                    <h4 class="mb-4">Forgot Password</h4>
                    <p class="text-muted">Enter your email and we'll send you a password reset link.</p>
                </div>

                @if(session('status'))
                    <div class="alert alert-success text-center">
                        <i class="fa fa-check-circle"></i> {{ session('status') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger text-center">
                        <i class="fa fa-exclamation-triangle"></i> {{ session('error') }}
                    </div>
                @endif

                <form method="post" action="{{ route('sendlink') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input class="form-control @error('email') is-invalid @enderror"
                               type="email"
                               name="email"
                               id="email"
                               placeholder="Enter your email"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa fa-paper-plane"></i> Send Reset Link
                    </button>
                </form>

                <hr class="my-4">

                <a href="{{ route('login') }}" class="link-dark">
                    <i class="fa fa-arrow-left"></i> Back to Login
                </a>

                <a href="{{ url('/') }}" class="link-dark d-block mt-3">
                    <i class="fa fa-home"></i> Return to Home
                </a>
            </div>
        </div>
    </div>
</div>

</main>
@endsection
