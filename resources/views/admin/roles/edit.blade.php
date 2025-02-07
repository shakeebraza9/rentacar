@extends('admin.layout')
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
        <h4 class="text-themecolor">EDIT YOUR ROLE
        </h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Roles</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <header class="card-header bg-info">
                <h4 class="mb-0 text-white" >Edit Role And Assign The Permission</h4>
            </header>
            <div class="card-body">
                <form method="post" action="{{URL::to('admin/roles/update/'.Crypt::encryptString($model->id))}}" >
                    @csrf
                    <div class="form-group">
                        <label class="form-label" >Name</label>
                        <input type="text" value="{{$model->name}}" name="name" class="form-control" 
                        placeholder="User Name">
                        @if($errors->has('name'))
                         <p class="invalid-feedback" >{{ $errors->first('name') }}</p>
                        @endif 
                    </div>
                    
                    <div class="form-group">
                      <label class="form-label">Status</label>
                      <select name="status" class="form-control" >
                        <option {{$model->status ? 'Selected' : ''}} value="1" >Active</option>
                        <option {{$model->status ? '' : 'Selected'}}  value="0">Deactive</option>
                      </select>
                      @if($errors->has('status'))
                      <p class="invalid-feedback" >{{ $errors->first('status') }}</p>
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