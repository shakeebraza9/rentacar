@extends('theme.help.layout')

@section('metatags')
<title>{{$global_d['site_title']}}</title>
@endsection
@section('css')
<style>
    :root {
        --primary-color: #00c853;
        --primary-dark: #009624;
        --text-color: #333;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f5f5;
        color: var(--text-color);
    }

    .breadcrumb {
        padding: 15px 0;
        margin-bottom: 0;
    }

    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
    }

    .sidebar {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .category-icon {
        color: var(--primary-color);
        font-size: 48px;
        text-align: center;
        margin-bottom: 15px;
    }

    .category-title {
        font-size: 24px;
        text-align: center;
        margin-bottom: 5px;
    }

    .last-update {
        color: #666;
        font-size: 14px;
        text-align: center;
        margin-bottom: 20px;
    }

    .faq-list {
        list-style: none;
        padding: 0;
    }

    .faq-list li {
        margin-bottom: 10px;
    }

    .faq-list a {
        color: var(--primary-color);
        text-decoration: none;
        display: flex;
        align-items: start;
        padding: 8px 0;
    }

    .faq-list a i {
        margin-right: 10px;
        margin-top: 3px;
    }

    .main-content {
        background-color: white;
        border-radius: 8px;
        padding: 30px;
    }

    .article-title {
        font-size: 32px;
        margin-bottom: 10px;
    }

    .article-subtitle {
        color: #666;
        font-size: 20px;
        margin-bottom: 30px;
    }

    .author-info {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
    }

    .author-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #FF9800;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-weight: bold;
    }

    .author-meta {
        color: #666;
        font-size: 14px;
    }

    .article-content {
        font-size: 16px;
        line-height: 1.6;
    }

    .article-content ol {
        padding-left: 20px;
    }

    .article-content ol li {
        margin-bottom: 15px;
    }

    .article-footer {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
        font-style: italic;
        color: #666;
    }
</style>
@endsection


@section('content')

<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('help.index') }}">All Categories</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('category.show', $category->id) }}">{{ $category->title }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $helpEntry->title }}</li>

        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="sidebar">
                <div class="category-icon">
                    @if(strtoupper($category->title) == 'CAR')
                    <i class="fas fa-car"></i>  <!-- Car Icon -->
                @elseif(strtoupper($category->title) == 'ATTRACTIONS')
                <i class="fa fa-umbrella-beach"></i>
                @else
                    <i class="fas fa-folder"></i>  <!-- Default Icon -->
                @endif
                </div>
                <h2 class="category-title">{{ $category->title }}</h2>
                <p class="last-update">{{ $category->updated_at->diffForHumans() }}</p>

                <ul class="faq-list">
                    @foreach($relatedEntries as $entry)
                        <li>
                            <a href="{{ route('help.entry.show', $entry->id) }}">
                                <i class="fas fa-file-alt"></i>
                                {{ $entry->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="main-content">
                <h1 class="article-title">{{ $helpEntry->title }}</h1>
         



                <div class="article-content">
                    {!! $helpEntry->description !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection








