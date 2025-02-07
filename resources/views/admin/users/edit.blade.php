@extends('admin.layout')

<?php 
$permissions = [
    'store_management',
    'coupons_management',
    'blogs_management',
    'site_management',
    'user_rights_management'
];

?>
@section('css')
    
<style>

    .error{
        color:red;
    }
</style>
@endsection

@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">EDIT YOUR USER 
        </h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <header class="card-header bg-info">
                <h4 class="mb-0 text-white" >Edit User And Assign The Permission</h4>
            </header>
            <div class="card-body">
                <form method="post" action="{{URL::to('admin/users/update/'.Crypt::encryptString($user->id))}}" >
                    @csrf
                    <div class="form-group">
                        <label class="form-label" >User Name</label>
                        <input type="text" value="{{$user->name}}" name="name" class="form-control" 
                        placeholder="User Name">
                        @if($errors->has('name'))
                         <p class="invalid-feedback" >{{ $errors->first('name') }}</p>
                        @endif 
                    </div>
                    
                    <div class="form-group">
                      <label class="form-label">Email Address</label>
                      <input type="email" value="{{$user->email}}" name="email" class="form-control" placeholder="Email Address"> 
                      @if($errors->has('email'))
                      <p class="invalid-feedback" >{{ $errors->first('email') }}</p>
                     @endif 
                   </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" value="" class="form-control" placeholder="Password">
                        <small  class="form-text text-dark">Please never share your email & password with anyone else.</small>

                        @if($errors->has('password'))
                          <p class="invalid-feedback" >{{ $errors->first('password') }}</p>
                         @endif 
                    </div>
                   
                    <div class="form-group row">
                        <div class="col-md-12 text-left">
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                     </div>
                     
                </form>
            </div>
        </section>
    </div>
</div>
@endsection

@section('js')
    
@endsection