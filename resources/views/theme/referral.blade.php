@extends('theme.layout')

@php
  //dd($product)
    
@endphp

@section('metatags')
    <title>Cart</title>
    <meta name="description" content="{{$global_d['blog_meta_description'] ?? ''}}">
    <meta name="keywords" content="{{$global_d['blog_keywords'] ?? ''}}">
@endsection
@section('css')
  
@endsection
@section('content')

<?php 
//dd($carts);
?>
<main class="main">
    <div>
                    <div class="container my-5">
<div class="row mb-3">
    <div class="card rounded-3 bg-light">
        <div class="card-header text-center bg-light">
            <h2>Refer a friend, get rewarded!</h2>
        </div>
        <div class="card-body text-center text-primary fw-bold mt-2">
            Share your referral code with your friends. Claim your reward when they registered &amp; successfully made a booking with LangkawiBook.                                    <div class="mt-4">
                    <img src="data:image/png;base64,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" height="200px" class="mx-auto d-block" alt="">                        <div class="row mt-3">
                        <div class="col"></div>
                        <div class="col-md-6">
                            <a href="/customer/users/print-qr" target="_blank" class="btn btn-primary fw-bold mt-2"><i class="fas fa-download"></i> Download QR Code</a>
                        </div>
                        <div class="col"></div>
                    </div>
                </div>
                <div class="text-black mt-4">
                    Referral Link: <span class="fw-normal text-primary" id="ref_url">https://www.langkawibook.my/ref/h23928a</span>
                    <span id="copy_review" title="" style="margin-left: 10px;" data-bs-original-title="Copied!" aria-label="Copied!"><a href="#"><i class="far fa-copy fa-lg border p-2 rounded-1"></i></a></span>
                </div>
                <!-- <div class="text-black">
                    Referral Code: <span class="fw-normal text-primary" id="ref_code">h23928a</span>
                    <span id="copy_code" title="Copied!" style="margin-left: 10px;"><a href="#"><i class="far fa-copy fa-lg border p-2 rounded-1"></i></a></span>
                </div> -->
                        </div>
                </div>
</div>

<div class="row mb-4">
    <div class="card rounded-3">
        <div class="card-body">
            <div class="row mt-2"><h5>My Referrals</h5></div>
            <hr class="mt-1">
            <div class="row gx-4">
                <div class="col-md-2"></div>
                <div class="col-md-auto">
                    <div class="bg-dark icon-circle-lg text-white">
                        <i class="fas fa-eye fa-2x"></i>
                    </div>
                </div>
                <div class="col-md">
                    <h5 class="text-muted">Viewed</h5>
                    <h4 class="mb-0">3</h4>
                </div>
                <div class="col-md-auto">
                    <div class="bg-dark icon-circle-lg text-white">
                        <i class="fas fa-check fa-2x"></i>
                    </div>
                </div>
                <div class="col-md">
                    <h5 class="text-muted">Purchased</h5>
                    <h4 class="mb-0">0</h4>
                </div>
                <div class="col-md-auto">
                    <div class="bg-dark icon-circle-lg text-white">
                        <i class="fas fa-check-double fa-2x"></i>
                    </div>
                </div>
                <div class="col-md">
                    <h5 class="text-muted">Successful</h5>
                    <h4 class="mb-0">0</h4>
                </div>
                <div class="col-md-2"></div>
            </div>

                                <div class="table-responsive mt-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Return Datetime</th>
                                <th>Type</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Payment Status</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                                                                                        </tbody>
                    </table>
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
    $(document).ready(function() {
        $("#copy_review").on('click', function(e) {
            e.preventDefault();
            var url = $('#ref_url').html();
            copyToClipboard(url);
        });
        
        $("#copy_review").tooltip({trigger: 'focus', delay: {show:0 ,hide: 500}})
    
        $("#copy_code").on('click', function(e) {
            e.preventDefault();
            var code = $('#ref_code').html();
            copyToClipboard(code);
        });
        
        $("#copy_code").tooltip({trigger: 'focus', delay: {show:0 ,hide: 500}})
    
        function copyToClipboard(text) {
            var dummy = document.createElement("textarea");
            document.body.appendChild(dummy);
            dummy.value = text;
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);
        }
    });
    </script> 


@endsection