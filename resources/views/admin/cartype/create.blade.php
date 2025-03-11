@extends('admin.layout')
@section('css')
<style>
    .invalid-feedback{
      display: block;
   }
</style>
@endsection

@section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">ADD YOUR CAR TYPE
        </h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Car type</li>
            </ol>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <header class="card-header bg-info">
                <h4 class="mb-0 text-white" >Create Car Type</h4>
            </header>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.cartype.store') }}">
                    @csrf

                    <!-- Title -->
                    <div class="form-group mb-3">
                        <label for="title">Car Type Name</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <!-- Slug -->
                    <div class="form-group mb-3">
                        <label for="slug">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" required>
                    </div>

                    <!-- Amount -->
                    <div class="form-group mb-3">
                        <label for="amount">Amount (RM)</label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group text-left">
                        <button type="submit" class="btn btn-info">Submit</button>

                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection

@section('js')

<script>
    document.getElementById("title").addEventListener("input", function () {
        let title = this.value;
        let slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
        document.getElementById("slug").value = slug;
    });
</script>


@endsection
