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
    <div>
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-auto">
                            <a href="{{ route('customer.profile') }}"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md mt-4 mt-md-0">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="text-primary">
                                        Bank Details
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <form method="post" accept-charset="utf-8" action="{{ route('updateBankDetails') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="account-number">Account Number</label>
                                            <input class="form-control" type="text" name="account_number" placeholder="eg. 7628xxxxxx" id="account-number" value="{{ old('account_number', $accountDetail->account_number ?? '') }}">
                                            <span class="help-block text-muted"></span>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="account-holder-name">Account Holder Name</label>
                                            <input class="form-control" type="text" name="account_holder_name" placeholder="eg. Johnothan" id="account-holder-name" value="{{ old('account_holder_name', $accountDetail->account_holder_name ?? '') }}">
                                            <span class="help-block text-muted"></span>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="bank-name">Bank</label>
                                            <select class="form-select" name="bank_name" id="bank-name">
                                                <option value="" selected="selected">Please Select Bank</option>
                                                @foreach (['Affin Bank', 'AmBank', 'Alliance Bank', 'Agro Bank', 'Bank Muamalat', 'Bank Simpanan Nasional (BSN)', 'Bank Islam Malaysia', 'Cash', 'Contra', 'CIMB Bank', 'Citibank Malaysia', 'Exim Bank', 'Hong Leong Bank', 'HSBC Bank', 'Maybank', 'MBSB Bank', 'OCBC Bank', 'PayPal', 'Public Bank', 'RHB', 'SenangPay', 'Standard Chartered Bank', 'UOB'] as $bank)
                                                    <option value="{{ $bank }}" {{ old('bank_name', $accountDetail->bank_name ?? '') == $bank ? 'selected' : '' }}>{{ $bank }}</option>
                                                @endforeach
                                            </select>
                                            <span class="form-text"></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="nric-number">IC No / SSM No</label>
                                            <input class="form-control" type="text" name="nric_number" id="nric-number" value="{{ old('nric_number', $accountDetail->ic_ssm_number ?? '') }}">
                                            <span class="help-block text-muted"></span>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                        <div class="text-end">
                                            <button class="btn btn-primary" type="submit">Update</button>
                                        </div>
                                    </form>
                                </div>
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
