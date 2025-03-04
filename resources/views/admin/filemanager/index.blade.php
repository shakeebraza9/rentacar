@extends('admin.layout')

@section('css')

    <link href="{{asset('public/admin/assets/css/pages/user-card.css')}}" rel="stylesheet">
    <link href="{{asset('public/admin/assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css')}}" rel="stylesheet">

    <style>

            /* .paginate{
                    padding-bottom: 50px;
                }

            .pager li>span {
                border-radius: 0px!important;
            } */



            .pager{
                list-style: none;
                display: flex;
                justify-content: center;
            }

            .pager li{
                margin: 0px 6px;
            }

            .pager .active span {
                color: #fb9678!important;
            }

            .pager li a{
                color:#212529;
            }
            .el-card-avatar {
                position: relative;
                overflow: hidden;
                border-radius: 8px;
            }

            .el-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.6);
                opacity: 0;
                transition: opacity 0.3s ease-in-out;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 8px;
            }

            .el-card-avatar:hover .el-overlay {
                opacity: 1;
            }

            .el-info {
                display: flex;
                gap: 10px;
            }

            .el-info .btn {
                transition: transform 0.2s ease-in-out;
            }

            .el-info .btn:hover {
                transform: scale(1.1);
            }



    </style>
 @endsection
@section('content')
<style>

</style>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">ADD NEW FILE </h4>


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
                <div class="row">
                    <div class="col-6">
                        <h4 class="mb-0 text-white" >All Files</h4>
                    </div>
                    <div class="col-6">
                        <h4 class="mb-0 text-white text-end" >Showing {{ $data->firstItem() }} - {{ $data->lastItem() }} of {{ $data->total() }}</h4>
                    </div>
                </div>
            </header>
            <div class="card-body">
                <div class="row el-element-overlay">

                    <div style="border-bottom: 1px solid lightgray;margin-bottom: 18px;padding-bottom: 12px;" class="col-12 pb-3">
                        <a href="{{URL::to('admin/filemanager')}}" class="btn {{request()->group == null ? 'btn-success' : 'btn-info'}}">All</a>

                        @foreach ($groups as $g)
                           <a href="{{URL::to('admin/filemanager')}}?group={{$g}}"
                           class="btn {{request()->group == $g ? 'btn-success' : 'btn-info'}}">{{$g}}</a>
                        @endforeach
                    </div>

                    @foreach($data as $item)
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="el-card-item">
                                <div class="el-card-avatar el-overlay-1 position-relative">
                                    <img class="img-fluid file-image" style="width: 200px;height:200px; object-fit: cover; border-radius: 8px;"
                                         src="{{ asset($item->path) }}" alt="user" />

                                    <!-- Overlay with buttons, shown only on hover -->
                                    <div class="el-overlay d-flex align-items-center justify-content-center">
                                        <ul class="el-info list-unstyled d-flex gap-3">
                                            <li>
                                                <a class="btn btn-light btn-sm image-popup-vertical-fit" href="{{ asset($item->path) }}">
                                                    <i class="mdi mdi-magnify"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="btn btn-danger btn-sm"
                                                   href="{{ URL::to('admin/filemanager/delete/'.$item->id) }}?image={{ $item->id }}">
                                                    <i class="mdi mdi-delete"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="el-card-content text-center mt-2">
                                    <h5 class="box-title">
                                        <a href="{{ URL::to('/admin/filemanager/edit/'.$item->id) }}">
                                            {{ $item->id }}
                                        </a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    </div>
                 </div>


                 <div class="paginate text-center">
                    {{ $data->links('pagination.custom') }}
                </div>

             </section>
       </div>
    </div>
@endsection

@section('js')

<script src="{{asset('public/admin/assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup.min.js')}}">
</script>
<script src="{{asset('public/admin/assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup-init.js')}}"></script>

@endsection
