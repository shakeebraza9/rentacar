@extends('admin.layout')

@section('css')
<style>
    .invalid-feedback {
        display: block;
    }

    .dateandtime {
        gap: 20px;
        padding: 10px;
        border: 1px solid rgb(221, 221, 221);
        border-radius: 8px;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 2px 10px;
        background-color: rgb(249, 249, 249);
        margin-top: 20px;
    }
</style>
@endsection

@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">EDIT YOUR SEASON</h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Season</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <header class="card-header" style="background-color: #6b0909;">
                <h4 class="mb-0 text-white">Edit Season</h4>
            </header>
            <div class="card-body">
                <form action="{{ route('admin.peakseason.update', $season->id) }}" method="POST">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label for="peak_season_name">Peak Season Name</label>
                        <input type="text" name="peak_season_name" value="{{ $season->title }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" value="{{ \Carbon\Carbon::parse($season->start_date)->format('Y-m-d') }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" value="{{ \Carbon\Carbon::parse($season->end_date)->format('Y-m-d') }}" class="form-control" required>
                    </div>


                    <h5>Prices</h5>
                    <div class="form-row" id="car_types_section">
                        @foreach ($carTypesWithPrices as $priceData)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center mb-4" style="gap: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); background-color: #f9f9f9;">
                                    <div style="flex: 1;">
                                        <label for="price_{{ $priceData['car_type_slug'] }}" style="font-weight: bold; color: #333;">
                                            Car Type: {{ $priceData['car_type_title'] }}
                                        </label>
                                        <input type="number" class="form-control" name="prices[{{ $priceData['car_type_slug'] }}]"
                                               value="{{ $priceData['price'] }}" placeholder="Enter price" required>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-success">Update Season</button>
                </form>

            </div>
        </section>
    </div>
</div>
@endsection
