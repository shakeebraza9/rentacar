<section class="card">
    <header class="card-header bg-info">
        <h4 class="mb-0 text-white">Car Type</h4>
    </header>
    <div class="card-body">
        <div class="tags-default">
            <!-- Dropdown Selector -->
            <label for="car_type">Select Car Type</label>
            <select name="car_type" id="car_type" class="form-control">
                <option value="compact" {{ $product->type == 'compact' ? 'selected' : '' }}>Compact</option>
                <option value="mpv" {{ $product->type == 'mpv' ? 'selected' : '' }}>MPV</option>
                <option value="sedan" {{ $product->type == 'sedan' ? 'selected' : '' }}>Sedan</option>
                <option value="SUV " {{ $product->type == 'SUV' ? 'selected' : '' }}>SUV</option>
                <option value="luxury_compact" {{ $product->type == 'luxury_compact' ? 'selected' : '' }}>Luxury Compact</option>
                <option value="luxury_mpv" {{ $product->type == 'luxury_mpv' ? 'selected' : '' }}>Luxury MPV</option>
                <option value="Luxury_SUV" {{ $product->type == 'Luxury_SUV' ? 'selected' : '' }}>Luxury SUV</option>
                <option value="Luxury_Sedan" {{ $product->type == 'Luxury_Sedan' ? 'selected' : '' }}>Luxury Sedan</option>
                <option value="Other" {{ $product->type == 'Other' ? 'selected' : '' }}>Other</option>
              
            </select>
        </div>
    </div>
</section>
<section class="card">
    <header class="card-header bg-info">
        <h4 class="mb-0 text-white">Car Brand</h4>
    </header>
    <div class="card-body">
        <div class="tags-default">
            <label for="sub_category">Select Brand</label>
            <select name="sub_category" id="sub_category" class="form-control">
                <option value="">Select a Sub Category</option>


                @foreach($Subcategory as $sub)
                @if ($sub->category_id == 44)

                <option value="{{ $sub->id }}" {{ $product->subcategory_id == $sub->id ? 'selected' : '' }}>
                    {{ $sub->title}}
                </option>
                @endif
                @endforeach
            </select>
        </div>
    </div>
</section>


<section class="card">
    <header class="card-header bg-info">
        <h4 class="mb-0 text-white">Information Dicount</h4>
    </header>
    <div class="card-body">
        <div class="tags-default">
    <label for="rms_text">Offer Text</label>
    <input type="text" id="rms_text" name="rms_text" class="form-control" placeholder="Enter RMS Text" value="{{ $product->discount_text ?? '' }}">
</div>
<div class="form-group">
    <div class="tags-default">
    <label for="unit">Unit</label>
    <input type="number" id="unit" name="unit" class="form-control" placeholder="Enter Unit" value="{{ $product->stock ?? '' }}">
</div>
</div>
</div>

</section>
