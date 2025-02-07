<section class="card">
    <header class="card-header bg-info">
        <h4 class="mb-0 text-white">Details</h4>
    </header>
    <div class="card-body"> 
        <div class="col-12">
            <div class="form-group">
                <textarea rows="10" cols="10" placeholder="Details..." class="form-control" 
                name="details">{{$product->details}}</textarea>
                @if($errors->has('details'))
                <p class="invalid-feedback" >{{ $errors->first('details') }}</p>
                @endif
            </div>
        </div>
    </div>
</section>