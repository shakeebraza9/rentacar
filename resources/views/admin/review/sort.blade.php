@extends('admin.layout')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.css">
<style>
    .invalid-feedback { display: block; }
</style>
@endsection

@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Manage Review Sorting</h4>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <header class="card-header d-flex justify-content-between align-items-center" style="background-color: #6b0909">
                <h4 class="mb-0 text-white">Sort Reviews</h4>
                <button class="btn btn-primary btn-sm save_btn">
                    <i class="fas fa-save"></i> Save Sorting
                </button>
            </header>

            <div class="card-body">
                <div class="dd">
                    <ol class="dd-list">
                        @foreach ($data as $item)
                            <li class="dd-item" data-id="{{ $item->id }}">
                                <div class="dd-handle">
                                    <strong>{{ $item->title }}</strong> - {{ $item->review }} (⭐ {{ $item->star }} Stars)
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.js"></script>
<script>
    $(document).ready(function () {
        $('.dd').nestable({ maxDepth: 1 }); // ✅ Single-level sorting enabled

        $(".save_btn").click(function () {
            let sortedData = $('.dd').nestable('serialize');
            let url = "{{ route('submite_sort') }}"; // ✅ Corrected route

            $.ajax({
                type: "POST",
                url: url,
                data: { data: sortedData, _token: "{{ csrf_token() }}" },
                dataType: "json",
                success: function (response) {
                    alert(response.message);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                    alert("An error occurred while saving. Please try again.");
                }
            });
        });
    });
</script>
@endsection
