
<li @if(count($data->children) > 0) style="list-style-type: disclosure-open;" @endif > 

    <a class="menus-item">
      {{$data->title}}
    </a>
        <div style="padding-left: 15px;" class="d-inline">             
            <a class="btn btn-success" 
             href="{{URL::to('admin/menus_items/edit/'.Crypt::encryptString($data->id))}}?level={{$level}}">
             <i class="fas fa-edit"></i></a>

            <a class="btn btn-danger" 
                href="{{URL::to('/admin/menus_items/delete/'.Crypt::encryptString($data->id))}}">
                <i class="fas fa-window-close" ></i>
            </a>

        </div>
</li>