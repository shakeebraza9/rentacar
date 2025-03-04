<section class="card">
    <header class="card-header" style="background-color: #6b0909">
        <div class="row">
            <div class="col-6">
                <h4 class="mb-0 text-white">Gallery</h4>
            </div>
            <div class="col-6 text-end">
                <span class="add_image" ><i class="text-white fas fa-plus"></i></span>
            </div>
        </div>
    </header>
    <div class="card-body">
        <div class="row el-element-overlay gallery-box">
           @foreach($product->get_images() as $key => $item)
           <div class="col-lg-3 col-md-6">
           <div class="card">
                <div class="el-card-item mb-0 pb-0">
                    <div class="el-card-avatar el-overlay-1">
                        <img src="{{asset($item->path)}}" />
                        <div class="el-overlay">
                            <ul class="el-info">
                                <li>
                                    <a class="btn default btn-outline image-popup-vertical-fit"
                                    href="{{asset($item->path)}}">
                                        <i class="icon-magnifier"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="btn default btn-outline"
                                    href="{{URL::to('admin/products/remove-image/'.Crypt::encryptString($product->id))}}?image={{$item->id}}">
                                        <i class="mdi mdi-close"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
           </div>
           @endforeach

        </div>
    </div>
</section>
