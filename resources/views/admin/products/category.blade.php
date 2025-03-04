<section class="card">
    <header class="card-header" style="background-color: #6b0909">
        <h4 class="mb-0 text-white">Select Category</h4>
    </header>
    <div class="card-body">
        <div class="form-group">
            <label for="category_id">Category</label>
            <select class="form-control" name="category_id" id="category_id" onchange="handleCategoryChange(this)">
                <option value="">Select a Category</option>
                @foreach($categories as $category)
                    <?php $subcats = $category->children; ?>
                    <option
                        data-slug="{{ $category->slug }}"
                        @if($product->category_id == $category->id) selected @endif
                        value="{{ $category->id }}">
                        {{ $category->title }}
                    </option>
                    @foreach($subcats as $child)
                        <option
                            data-slug="{{ $child->slug }}"
                            @if($product->category_id == $child->id) selected @endif
                            value="{{ $child->id }}">
                            ---- {{ $child->title }}
                        </option>
                        @foreach($child->children as $subchild)
                            <option
                                data-slug="{{ $subchild->slug }}"
                                @if($product->category_id == $subchild->id) selected @endif
                                value="{{ $subchild->id }}">
                                --------- {{ $subchild->title }}
                            </option>
                        @endforeach
                    @endforeach
                @endforeach
            </select>
            @if($errors->has('category_id'))
                <p class="invalid-feedback">{{ $errors->first('category_id') }}</p>
            @endif
        </div>

        <div id="additional-fields" style="{{ $product->category_id == 44 ? 'display: block;' : 'display: none;' }}">
            <!-- Passenger Category Input -->
            <div id="passenger-fields">
                <label for="passenger_number">Passenger Number</label>
                <input type="number" name="passenger_number" id="passenger_number"
                       value="{{ optional($product_details->firstWhere('key_title', 'passenger_number'))->value ?? '' }}"
                       class="form-control">
            </div>

            <!-- Baggage Category Input -->
            <div id="baggage-fields">
                <label for="baggage_number">Baggage Number</label>
                <input type="number" name="baggage_number" id="baggage_number"
                       value="{{ optional($product_details->firstWhere('key_title', 'baggage_number'))->value ?? '' }}"
                       class="form-control">
            </div>

            <!-- Door Category Input -->
            <div id="door-fields">
                <label for="door_number">Door Number</label>
                <input type="number" name="door_number" id="door_number"
                       value="{{ optional($product_details->firstWhere('key_title', 'door_number'))->value ?? '' }}"
                       class="form-control">
            </div>

            <!-- Aircond Category Input -->
            <div id="aircond-fields">
                <label for="aircond">Air Conditioning</label>
                <select name="aircond" id="aircond" class="form-control">
                    <option value="yes" {{ optional($product_details->firstWhere('key_title', 'aircond'))->value == 'yes' ? 'selected' : '' }}>Yes</option>
                    <option value="no" {{ optional($product_details->firstWhere('key_title', 'aircond'))->value == 'no' ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <!-- Transmission Category Input -->
            <div id="transmission-fields">
                <label for="transmission">Transmission</label>
                <input type="text" name="transmission" id="transmission"
                       value="{{ optional($product_details->firstWhere('key_title', 'transmission'))->value ?? '' }}"
                       class="form-control">
            </div>

            <!-- Oil Type Category Input -->
            <div id="oil-type-fields">
                <label for="oil_type">Oil Type</label>
                <select name="oil_type" id="oil_type" class="form-control">
                    <option value="gas" {{ optional($product_details->firstWhere('key_title', 'oil_type'))->value == 'gas' ? 'selected' : '' }}>Gas</option>
                    <option value="petrol" {{ optional($product_details->firstWhere('key_title', 'oil_type'))->value == 'petrol' ? 'selected' : '' }}>Petrol</option>
                    <option value="diesel" {{ optional($product_details->firstWhere('key_title', 'oil_type'))->value == 'diesel' ? 'selected' : '' }}>Diesel</option>
                </select>
            </div>
        </div>



        </section>

