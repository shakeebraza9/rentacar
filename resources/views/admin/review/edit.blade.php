@extends('admin.layout')

@section('content')

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">ALL REVIEW LIST
        </h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Review</li>
            </ol>
        </div>
    </div>
</div>
<div class="container">
    <h2>Edit Review</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.review.update', $review->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="product_id">Select Product</label>
            <select class="form-control" name="product_id" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $product->id == $review->product_id ? 'selected' : '' }}>
                        {{ $product->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="user_id">Select User</label>
            <select class="form-control" name="user_id" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $review->user_id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="title">Review Title</label>
            <input type="text" class="form-control" name="title" value="{{ $review->title }}">
        </div>

        <div class="form-group">
            <label for="star">Star Rating</label>
            <select class="form-control" name="star" required>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ $i == $review->star ? 'selected' : '' }}>{{ $i }} Star</option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label for="review">Review</label>
            <textarea class="form-control" name="review" rows="4" required>{{ $review->review }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Review</button>
    </form>
</div>
</div>
</div>
@endsection
