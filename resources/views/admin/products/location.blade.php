@php
    $locations = explode(',', $location ?? '');
@endphp

<section class="card">
    <header class="card-header bg-info">
        <h4 class="mb-0 text-white">Select Location</h4>
    </header>
    <div class="card-body">
        <div class="tags-default">
            <!-- Pickup Location -->
            <label for="pickup_location">Pickup Location</label>
            <select name="pickup_location" id="pickup_location" class="form-control">
                <option value="" disabled {{ empty($product->pickup_location) ? 'selected' : '' }}>Select Pickup Location</option>
                @foreach ($locations as $item)
                    <option value="{{ trim($item) }}" {{ trim($item) == trim($product->pickup_location ?? '') ? 'selected' : '' }}>
                        {{ trim($item) }}
                    </option>
                @endforeach
            </select>

            <!-- Drop-off Location -->
            <label for="dropoff_location">Drop-off Location</label>
            <select name="dropoff_location" id="dropoff_location" class="form-control">
                <option value="" disabled {{ empty($product->dropoff_location) ? 'selected' : '' }}>Select Drop-off Location</option>
                @foreach ($locations as $item)
                    <option value="{{ trim($item) }}" {{ trim($item) == trim($product->dropoff_location ?? '') ? 'selected' : '' }}>
                        {{ trim($item) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</section>
