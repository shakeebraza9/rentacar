@extends('admin.layout')

@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">EDIT FILE
        </h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Filemanager</li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <header class="card-header" style="background-color: #6b0909">
                <h4 class="mb-0 text-white"> Edit File Form</h4>
            </header>
            <div class="card-body">
                <form action="{{URL::to('admin/filemanager/update/'.$filemanager->id)}}"
                  method="POST"
                  enctype="multipart/form-data" >
                    @csrf
                <div class="container">
                    <div class="my-2 row">
                        <div class="col-md-12">
                             <label class="form-label">Group</label>
                             <input name="group" class="form-control"
                               value="{{$filemanager->grouping}}" placeholder="Group">
                             @if ($errors->has('group'))
                              <small class="text-danger">{{ $errors->first('group')}}</small>
                             @endif
                        </div>
                    </div>
                    <div class="my-2 row">
                        <div class="col-md-12">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control"
                                value="{{$filemanager->title}}"
                                placeholder="{{__('title')}}" />
                                @if ($errors->has('title'))
                                <small class="text-danger">{{ $errors->first('title')}}</small>
                                @endif
                        </div>
                    </div>

                    <div class="my-2 row">
                        <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <input type="text" name="description" class="form-control"
                                value="{{$filemanager->description}}" placeholder="Description">
                                @if ($errors->has('description'))
                                <small class="text-danger">{{ $errors->first('description')}}</small>
                                @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 pt-3">
                            <button type="submit" class="btn btn-primary text-white">Update</button>
                            <a href="{{URL::to('admin/filemanager')}}"
                            class="btn btn-danger">{{__('cancel')}}</a>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </section>
    </div>
</div>
@endsection
