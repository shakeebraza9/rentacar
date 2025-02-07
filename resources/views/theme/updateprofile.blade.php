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

        .profile-image-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%; /* Makes the image circular */
            border: 2px solid #ddd; /* Optional: Adds a border around the image */
        }

        .profile-image-preview:hover {
            border-color: #007bff; /* Optional: Changes border color on hover */
        }

        @media (max-width: 768px) {
            .profile-image-preview {
                width: 100px;
                height: 100px;
            }
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
                        <h3>Edit Profile</h3>
                    </div>
                    <div class="col-md-auto">
                        <a href="{{ route('customer.profile') }}"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-auto text-center">
                        <!-- Profile Image -->
                        <img id="profileImagePreview"
                        src="{{ $user->profile_image ? asset( $user->profile_image) : asset('theme/asset/img/profileImg.png') }}"
                        class="img-fluid profile-image-preview border">

                    </div>
                    <div class="col-md mt-4 mt-md-0">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-primary">
                                    User Details
                                </h4>
                            </div>
                            <div class="card-body">
                                <form enctype="multipart/form-data" method="POST" action="{{ route('profile.update') }}">
                                    @csrf


                                    <div class="row mb-3">
                                        <label for="profile_image" class="col-md-2 col-form-label">Profile Image</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="file" name="profile_image" id="profile_image" accept="image/*">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="name" class="col-md-2 col-form-label">Name</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" name="name" required id="name" value="{{ old('name', $user->name) }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="phone-number" class="col-md-2 col-form-label">Phone Number</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="number" name="phone_number" required id="phone-number" value="{{ old('phone_number', $user->phone_number) }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="email" class="col-md-2 col-form-label">Email</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="email" name="email" disabled value="{{ $user->email }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="country" class="col-md-2 col-form-label">Country</label>
                                        <div class="col-md-10">
                                            <select class="form-select" name="country" id="country" required>

                                                <option value="MY" {{ old('country', $user->country) == 'MY' ? 'selected' : '' }}>Malaysia</option>
                                                <option value="SG" {{ old('country', $user->country) == 'SG' ? 'selected' : '' }}>Singapore</option>
                                                <option value="GB" {{ old('country', $user->country) == 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                                <option value="US" {{ old('country', $user->country) == 'US' ? 'selected' : '' }}>United States</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="dob" class="col-md-2 col-form-label">Date of Birth</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="date" name="dob" required id="dob" value="{{ old('dob', \Carbon\Carbon::parse($user->date_of_birth)->format('Y-m-d')) }}">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>

                                </form>
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

<script>
    document.getElementById('profile_image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImagePreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection
