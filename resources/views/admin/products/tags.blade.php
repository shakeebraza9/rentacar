<section class="card">
    <header class="card-header bg-info">
        <h4 class="mb-0 text-white">Select Tags</h4>
    </header>
    <div class="card-body">
        <div class="tags-default">
            <input type="text" name="tags" value="{{$product->tags}}" data-role="tagsinput" placeholder="" /> 
        </div>
    </div>
</section>

<section class="card">
    <header class="card-header bg-info">
        <h4 class="mb-0 text-white">Select Type</h4>
    </header>
    <div class="card-body">
        <div class="tags-default">
            <!-- Dropdown Selector -->
            <label for="car_type">Select Car Type</label>
            <select name="car_type" id="car_type" class="form-control">
                <option value="sedan" {{ $product->type == 'sedan' ? 'selected' : '' }}>Sedan</option>
                <option value="compact" {{ $product->type == 'compact' ? 'selected' : '' }}>Compact</option>
                <option value="mpv" {{ $product->type == 'mpv' ? 'selected' : '' }}>MPV</option>
                <option value="luxury_mpv" {{ $product->type == 'luxury_mpv' ? 'selected' : '' }}>Luxury MPV</option>
            </select>
        </div>
    </div>
</section>
