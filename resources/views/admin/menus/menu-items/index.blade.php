@extends('admin.layout')
@section('css')

<link rel="stylesheet" type="text/css"
href="{{asset('public/admin/assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" type="text/css"
href="{{asset('public/admin/assets/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css')}}">
<link href="{{asset('public/admin/assets/node_modules/switchery/dist/switchery.min.css')}}" rel="stylesheet" type="text/css" />


<style>

    table td{
        /* border: 1px solid lightgray; */
    }

    table th{
        /* border: 1px solid lightgray; */
    }

    @media (max-width: 767px){
        .container-fluid, .container-sm, .container-md, .container-lg, .container-xl, .container-xxl {

            overflow: scroll!important;
        }
    }



    .tree li {
        list-style-type:none;
        margin:0;
        padding:10px 5px 0 5px;
        position:relative
    }
    .tree li::before,
    .tree li::after {
        content:'';
        left:-20px;
        position:absolute;
        right:auto
    }
    .tree li::before {
        border-left:2px solid #000;
        bottom:50px;
        height:100%;
        top:0;
        width:1px
    }
    .tree li::after {
        border-top:2px solid #000;
        height:20px;
        top:25px;
        width:25px
    }
    .tree li span {
        -moz-border-radius:5px;
        -webkit-border-radius:5px;
        border:2px solid #000;
        border-radius:3px;
        display:inline-block;
        padding:3px 8px;
        text-decoration:none;
        cursor:pointer;
    }
    .tree>ul>li::before,
    .tree>ul>li::after {
        border:0
    }
    .tree li:last-child::before {
        height:27px
    }
    .tree li span:hover {
        background: hotpink;
        border:2px solid #94a0b4;
        }

    [aria-expanded="false"] > .expanded,
    [aria-expanded="true"] > .collapsed {
    display: none;
    }


  .menues-section ul  {
    list-style-type: disclosure-closed;
  }

  .menues-section ul ul {
    list-style-type: disclosure-closed;
   }

  .menues-section ul ul ul {
    list-style-type: disclosure-closed;
   }



   .menus-box li{
    margin: 18px 0px;
   }

   .menus-box li a{
     /* color: #94a0b4; */
   }

   .menus-box i{
     /* font-size: 10px; */
   }


   .menus-item{
    font-size: 16px;
   }



</style>
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Menu "{{$menu->title}}"
            </h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Menus</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- page start-->
        <div class="menues-section row">
            <div class="col-sm-5">
                <section class="card">
                     <header class="card-header" style="background-color: #6b0909">
                         <h4 class="mb-0 text-white" >Add New Page</h4>
                     </header>
                     <div class="card-body">
                         <form method="post" action="{{URL::to('/admin/menus_items/store')}}">
                             @csrf
                                <input type="hidden" name="menu_id" value="{{$menu->id}}" />

                                    <div class="form-group">
                                        <label class="form-label">Select Parent</label>
                                        <select class="form-control" name="parent_id">
                                            <option value="">None</option>
                                            {!! $dropdowns !!}
                                        </select>
                                    </div>

                                     <div class="form-group">
                                         <label class="form-label" >Title</label>
                                         <input required name="title"
                                           class="form-control"
                                           placeholder="Title">
                                     </div>

                                     <div class="form-group">
                                        <label class="form-label" >Sort</label>
                                        <input required type="number" name="sort"
                                        class="form-control" placeholder="sort" />
                                    </div>

                                     <div class="form-group">
                                        <label class="form-label" >Link</label>
                                        <input required name="link"
                                        class="form-control" placeholder="Link" />
                                    </div>

                                     <div class="form-group">
                                        <label class="form-label">SubTitle</label>
                                        <input name="subtitle"
                                          class="form-control"
                                          placeholder="SubTitle">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Open In</label>
                                        <select class="form-control" name="target" >
                                            <option value="">Existing</option>
                                            <option value="_blank">New Tab</option>
                                        </select>
                                    </div>

                                    <div class="text-center" >
                                        <button type="submit" class="btn btn-info text-white">Submit</button>
                                    </div>
                             </form>
                          </div>
                       </section>
                  </div>
                  <div class="col-sm-7">
                        <section class="card">
                            <header class="card-header bg-info">
                                <h4 class="mb-0 text-white">{{$menu->title}} 's Pages</h4>
                            </header>
                            <div class="card-body">
                                <ul class="menus-box" >
                                    @foreach ($pageItems as $menu_item)

                                    @component('admin.menus.menu-items.item',[
                                        'data' => $menu_item,
                                        'level' => 1,
                                    ])@endcomponent

                                            @foreach ($menu_item->children as $child)
                                              <ul>
                                                @component('admin.menus.menu-items.item',[
                                                    'data' => $child,
                                                    'level' => 2,
                                                ])@endcomponent

                                                        @foreach ($child->children as $subchild)
                                                            <ul>
                                                                @component('admin.menus.menu-items.item',[
                                                                    'data' => $subchild,
                                                                    'level' => 3,
                                                                ])@endcomponent

                                                            </ul>
                                                        @endforeach
                                                </ul>
                                            @endforeach

                                    @endforeach
                                </ul>
                            </div>
                          </section>
                    </div>
            </div>



 @endsection
 @section('js')

       <!-- This is data table -->
       <script src="{{asset('admin/assets/node_modules/datatables.net/js/jquery.dataTables.min.js')}}"></script>
       <script src="{{asset('admin/assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js')}}"></script>
       <script src="{{asset('admin/assets/node_modules/switchery/dist/switchery.min.js')}}"></script>


       <script>
        $(function () {
            $('[data-level="3"]').attr('disabled', 'true');

            $('.js-switch').each(function () {
                new Switchery($(this)[0], $(this).data());
            });


            var application_table = $('.mydatatable').DataTable({
            processing: true,
            "searching": true,
            fixedColumns: false,
            fixedHeader: false,
            scrollCollapse: false,
            scrollX: true,
            autoWidth: false,
            dom: 'lfrtip',
            order: [],
            lengthMenu: [[10,25, 50, 100,500],[10,25, 50, 100,500]],
            initComplete: function () {

            }
        });

        $(".mydatatable").delegate(".is_enable", "change", function(){
            var isChecked = $(this).prop('checked');
            $.ajax({
                url: "{{URL::to('/admin/status')}}",
                data: {
                    id:$(this).data('id'),
                    table:'menu_items',
                    column:'is_enable',
                    value: $(this).prop('checked') ? 1: 0,
                },
                dataType: "json",
                success: function (response) {

                },
                errror:function (response) {

                },
            });

        });








      });
    </script>
@endsection
