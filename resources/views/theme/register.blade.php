@extends('theme.layout')

@php

@endphp

@section('metatags')
    <title>{{$global_d['site_title']}}</title>
@endsection

@section('css')

<style>

</style>

@endsection
@section('content')

<div class="my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <img src="{{ asset(getset('logo')) }}" class="logo mb-4" style="height:4rem" alt="Logo">
                            <h4 class="mb-4">Register</h4>
                        </div>
                        <form method="POST" action="{{ route('createAccount') }}">
                            @csrf
                            <div class="row">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror"
                                           type="text"
                                           name="name"
                                           placeholder="eg. John"
                                           id="name"
                                           value="{{ old('name') }}"
                                           required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input class="form-control @error('email') is-invalid @enderror"
                                               type="email"
                                               name="email"
                                               placeholder="eg. John@gmail.com"
                                               id="email"
                                               value="{{ old('email') }}"
                                               required>
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="phone_number">Phone Number</label>
                                        <input class="form-control @error('phone_number') is-invalid @enderror"
                                               type="tel"
                                               name="phone_number"
                                               placeholder="0123456789"
                                               id="phone_number"
                                               pattern="[0-9- ]{1,}"
                                               title="Only numbers are allowed"
                                               value="{{ old('phone_number') }}"
                                               required>
                                        @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="gender">Gender</label>
                                        <select class="form-select @error('gender') is-invalid @enderror"
                                                name="gender"
                                                id="gender"
                                                required>
                                            <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Male</option>
                                            <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="date_of_birth">Date of Birth</label>
                                        <input class="form-control @error('date_of_birth') is-invalid @enderror"
                                               type="date"
                                               name="date_of_birth"
                                               id="date_of_birth"
                                               value="{{ old('date_of_birth') }}">
                                        @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="country">Country</label>
                                        <select class="form-select @error('country') is-invalid @enderror"
                                                name="country"
                                                id="country">
                                            <option value="MY" {{ old('country') == 'MY' ? 'selected' : '' }}>Malaysia</option>
                                            <option value="SG" {{ old('country') == 'SG' ? 'selected' : '' }}>Singapore</option>
                                            <option value="GB" {{ old('country') == 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                            <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>United States</option>
                                            <!-- Add other countries as needed -->
                                        </select>
                                        @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="password">Password</label>
                                    <input class="form-control @error('password') is-invalid @enderror"
                                           type="password"
                                           name="password"
                                           id="password"
                                           required>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="confirm-password">Confirm Password</label>
                                    <input class="form-control"
                                           type="password"
                                           name="password_confirmation"
                                           id="confirm-password"
                                           required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="g-recaptcha" data-sitekey="6LfcExcqAAAAAKavm4Fr_QLS7wrwV5kB1ScVkEHz"></div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col">
                                    <input type="submit" class="btn btn-primary btn-block" id="btn-submit" value="Sign Up">
                                </div>
                            </div>
                        </form>
                        <hr class="my-4">
                        <a href="{{ route('weblogin') }}" class="name">Already a member? Sign in here</a><br>
                        <a href="{{ route('home') }}"><i class="fa fa-arrow-left"></i> Back to home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    console.log("hello");
</script>
@endsection

