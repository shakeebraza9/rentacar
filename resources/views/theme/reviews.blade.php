@extends('theme.layout')

@php
//dd($users);
@endphp

@section('metatags')
<title>{{$global_d['site_title']}}</title>
@endsection

@section('css')


@endsection
@section('content')

<main class="main">
    <div class="container">
        <div class="row my-5 text-center">
            <h1>Our Car Rental Reviews</h1>
            <p class="mt-3">
                We pride ourselves on providing top-notch service and high-quality, affordable vehicles to all of our customers. Below are the reviews we have received from our valued customers.
            </p>
        </div>

        <div class="row gy-3 mb-4">

            @foreach ($reviews as $review)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!-- Review Image -->
                                <div class="col-md-5">
                                    @if ($review->image_path)
                                        <img src="{{ asset( $review->image_path) }}" class="img-fluid w-100" alt="Review Image">

                                    @endif
                                    <div class="text-center mt-2">
                                        <div class="stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star fa-1x {{ $i <= $review->star ? 'text-primary' : 'text-muted' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <!-- Review Content -->
                                <div class="col-md-7 position-relative">
                                    <div class="mb-6">
                                        "{{ $review->review }}"
                                    </div>
                                    <div class="fst-italic text-muted position-absolute bottom-0 end-0 p-3">
                                        By {{ $review->user->name ?? 'Anonymous' }} <br>
                                        <span class="small text-dark">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="wrap-pagination my-2">
            <div class="paginator text-center">
                {{ $reviews->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</main>


  @endsection
  @section('js')

  @endsection
