@extends('theme.help.layout')

@section('metatags')
<title>{{$global_d['site_title']}}</title>
@endsection

@section('css')

@endsection
@section('content')
    <!-- Main Content -->
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('help.index') }}" style="color: var(--primary-color);">All Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ strtoupper($category->title) }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="sidebar-card">
                    <div class="sidebar-icon">
                        @if(strtoupper($category->title) == 'CAR')
                        <i class="fas fa-car"></i>  <!-- Car Icon -->
                    @elseif(strtoupper($category->title) == 'ATTRACTIONS')
                    <i class="fa fa-umbrella-beach"></i>
                    @else
                        <i class="fas fa-folder"></i>  <!-- Default Icon -->
                    @endif
                    </div>
                    <h2 class="category-title text-center">{{ $category->title }}</h2>
                    <p class="text-center text-muted small">{{ $category->updated_at->diffForHumans() }}</p>

                    <div class="user-avatars justify-content-center">
                        <div class="avatar">N</div>
                        <div class="avatar">L</div>
                        <div class="avatar">S</div>
                        <div class="avatar">+4</div>
                    </div>
                </div>


            </div>

            <!-- FAQ Content -->
            <div class="col-md-9">
                @foreach($category->helpEntries as $entry)
                <a href="{{ route('help.entry.show', $entry->id) }}" class="text-decoration-none text-dark">
                    <div class="faq-card d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="faq-question">{{ $entry->title }}</h3>
                            <p class="faq-meta mb-0">Last Update: {{ $entry->updated_at->diffForHumans() }}</p>
                        </div>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </div>
                    </a>
                @endforeach




            </div>
        </div>
    </div>
    <div id="ticket-modal" class="modal-backdrop" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5);">
        <div class="modal" style="background: white; width: 400px; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                <span class="header-text" style="font-size: 18px; font-weight: bold;">Submit Ticket</span>
                <button id="close-modal" type="button" class="btn-close" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
            </div>
            <div class="modal-body" style="padding: 15px 0;">
                <form id="ticket-form">
                    <div style="margin-bottom: 10px;">
                        <label for="sender-name" class="form-label" style="display: block; font-weight: bold;">Name</label>
                        <input type="text" id="sender-name" class="form-control" placeholder="Required" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    <div style="margin-bottom: 10px;">
                        <label for="sender-email" class="form-label" style="display: block; font-weight: bold;">Email</label>
                        <input type="email" id="sender-email" class="form-control" placeholder="Required" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    <div style="margin-bottom: 10px;">
                        <label for="ticket-subject" class="form-label" style="display: block; font-weight: bold;">Subject</label>
                        <input type="text" id="ticket-subject" class="form-control" placeholder="Required" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    <div style="margin-bottom: 10px;">
                        <label for="ticket-message" class="form-label" style="display: block; font-weight: bold;">Message</label>
                        <textarea id="ticket-message" class="form-control" placeholder="Required" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; height: 100px;"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="display: flex; justify-content: flex-end; border-top: 1px solid #ddd; padding-top: 10px;">
                <button type="button" class="btn btn-success" style="background: #03a84e; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">Submit Request</button>
            </div>
        </div>
    </div>
    @endsection

    @section('js')

    @endsection
