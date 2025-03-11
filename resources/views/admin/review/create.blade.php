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
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h4 class="mb-4">Add New Review</h4>
            <form action="{{ route('admin.review.store') }}" method="POST">
                @csrf

                <!-- Product Dropdown -->
                <div class="form-group">
                    <label for="product_id">Select Product</label>
                    <select class="form-control" name="product_id" required>
                        <option value="">Choose Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- User Dropdown -->
                <div class="form-group">
                    <label for="user_id">Select User</label>
                    <select class="form-control" name="user_id" required>
                        <option value="">Choose User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Review Title -->
                <div class="form-group">
                    <label for="title">Review Title</label>
                    <input type="text" class="form-control" name="title" required>
                </div>

                <!-- Star Rating -->
                <div class="form-group">
                    <label for="star">Star Rating</label>
                    <select class="form-control" name="star" required>
                        <option value="">Choose Rating</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }} Star</option>
                        @endfor
                    </select>
                </div>

                <!-- Review Text -->
                <div class="form-group">
                    <label for="review">Review</label>
                    <textarea class="form-control" name="review" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        </div>
    </div>
</div>
</div>
</div>
@endsection
