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

        <div class="container my-4">
            <div class="row my-5 text-center">
                <h1 class="text-primary">Blog</h1>
                <div class="fw-normal fs-5 text-primary">Get to know all the latest news here!</div>
            </div>

            <form method="get" accept-charset="utf-8" action="https://www.MRR HOLIDAYS.my/blogs">
                <div class="row mb-4 justify-content-center">
                    <div class="col-md-5">
                        <div class="mb-3"><input class=" form-control " type="text" name="search"
                                placeholder="Search" id="search" aria-label="Search" /><span
                                class="help-block text-muted"> </span>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <input type="submit" class="btn btn-primary" value="Filter">
                    </div>
                </div>
            </form>
            <div class="row">
       
                @foreach ($blogs as $blog)
                <div class="card shadow-sm rounded-3 mb-4">
                    <div class="card-body">
                        <div class="row">
                            <!-- Blog Image -->
                            <div class="col-md-3">
                                <img src="{{ asset( $blog->image_path) }}" class="img-fluid rounded-3"
                                     style="height: 200px; object-fit: cover;" width="100%" alt="{{ $blog->title }}">
                            </div>
                            <!-- Blog Content -->
                            <div class="col">
                                <h2 class="mt-3">
                                    <!-- Generate slug dynamically, or use the correct field if available -->
                                    <a href="{{ route('blogs.show', ['slug' => Str::slug($blog->title)]) }}" class="link-primary" title="{{ $blog->title }}">
                                        {{ $blog->title }}
                                    </a>
                                </h2>
                                <p class="text-dark">
                                    {{ Str::limit($blog->description, 150) }}
                                </p>
                                <div class="text-muted small mt-5">
                                    <span>
                                        <i class="fas fa-user"></i> {{ $blog->user_name ?? 'Unknown Author' }}  <!-- Handle null author -->
                                    </span>&nbsp;&nbsp;
                                    <span>
                                        <i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($blog->created_at)->format('d F Y') }}
                                    </span>&nbsp;&nbsp;
                                    <span class="me-3">
                                        <i class="fas fa-tag"></i> {{ $blog->category_name ?? 'Uncategorized' }}  <!-- Handle null category -->
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            

             
            
                    </div>
            </div>

</main>
@endsection

@section('js')
    <!-- Custom JS scripts here -->
@endsection
