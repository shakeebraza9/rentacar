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
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md">
                        <h3>Welcome, {{ $user->name }}!</h3>
                    </div>
                    <div class="col-md-auto">
                        <a href="{{ route('chngpassword') }}" class="btn btn-primary">
                            <i class="fa fa-key"></i> Change Password
                        </a>
                        <a href="{{ route('updateprofile') }}" class="btn btn-primary">
                            <i class="fas fa-pencil-alt"></i> Update Profile
                        </a>
                        <a href="{{ route('userbankaccount') }}" class="btn btn-primary">
                            <i class="fas fa-university"></i> Update Bank Details
                        </a>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-auto">
                        <img src="{{ $user->profile_image ?? '/img/profileImg.png' }}"
                             class="img-fluid object-fit-circle-lg" alt="Profile Image">
                    </div>
                    <div class="col-md mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-primary">User Details</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive">
                                    <tbody>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone Number</th>
                                            <td>{{ $user->phone_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date of Birth</th>
                                            <td>{{ $user->date_of_birth ? $user->date_of_birth->format('d-m-Y') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Country</th>
                                            <td>{{ $user->country }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
@section('js')



@endsection
