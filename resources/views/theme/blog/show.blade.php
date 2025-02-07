@extends('theme.layout')

@section('metatags')
    <title>{{$global_d['site_title']}}</title>
@endsection

@section('css')
<style>
    /* Your custom styles here */
</style>
@endsection

@section('content')

<main class="main">
    <div>
        <div class="container my-5">
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-lg">
                        <div class="card-header">
                            <h1 class="text-primary">{{ $blog->title }}</h1> <!-- Blog Title -->
                            <div class="mt-2"><i class="fas fa-tag"></i> &nbsp;{{ $blog->category }}</div> <!-- Category -->
                            <div class="small text-muted mt-2">
                                Posted by {{ $blog->author->name }} on {{ $blog->created_at->format('d M Y') }} <!-- Author and Date -->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <img src="{{ asset($blog->image->path) }}" class="mx-auto d-block" alt="{{ $blog->title }}">
                            </div>
                            <div class="row mt-4">
                                <h2>{{ $blog->description }}</h2> <!-- Subtitle -->
                                <p>{{ $blog->short_description }}</p> <!-- Blog Content -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-5 ps-md-6">
                    <h4>Featured Post</h4>
                    @foreach($posts as $featuredPost)
                        <div class="row mt-4">
                            <div class="col-auto">
                                <img src="{{ asset($featuredPost->image->path) }}" class="img-fluid rounded-3" style="object-fit:cover; width:85px;" alt="">
                            </div>
                            <div class="col">
                                <div>
                                    <a href="{{ route('blogs.show', $featuredPost->slug) }}" class="d-block link-primary fw-bold">{{ $featuredPost->title }}</a>
                                </div>
                                <div class="text-muted small mt-2">
                                    <span class="me-3">
                                        <i class="fas fa-tag"></i> {{ $featuredPost->location }}
                                    </span>
                                </div>
                                <div class="text-muted small">
                                    <span class="me-3">
                                        <i class="far fa-calendar-alt"></i> {{ $featuredPost->created_at->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <hr class="mb-5">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</main>



@endsection

@section('js')
    <!-- Custom JS scripts here -->
@endsection
