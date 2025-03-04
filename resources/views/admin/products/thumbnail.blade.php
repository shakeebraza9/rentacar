<section class="card">
    <header class="card-header" style="background-color: #6b0909">
        <h4 class="mb-0 text-white">Image</h4>
    </header>
    <div class="card-body">

        <!-- Thumbnail Selection -->
        <div class="form-group my-2">
            <label class="form-label" for="image-selector">Thumbnail:</label>
            <select name="image" class="form-control" id="image-selector">
                <option value="">Select Image</option>
                @foreach($filemanager as $file)
                    <option value="{{ $file->id }}" data-image="{{ asset($file->path) }}"
                        @if($file->id == $product->image) selected @endif>
                        {{ $file->title }}
                    </option>
                @endforeach
            </select>
            <div class="selected-image-preview">
                @if($product->get_thumbnail && file_exists(public_path($product->get_thumbnail->path)))
                    <img class="pt-3" style="width: 100px; height: 100px;" src="{{ asset($product->get_thumbnail->path) }}" alt="Thumbnail" />
                @else
                    <p class="pt-3">No thumbnail available</p>
                @endif
            </div>
        </div>

        <hr>

        <!-- Hover Image Selection -->
        <div class="form-group my-2">
            <label class="form-label" for="hover-image-selector">Hover Image:</label>
            <select name="hover_image" class="form-control" id="hover-image-selector">
                <option value="">Select Hover Image</option>
                @foreach($filemanager as $file)
                    <option value="{{ $file->id }}" data-image="{{ asset($file->path) }}"
                        @if($file->id == $product->hover_image) selected @endif>
                        {{ $file->title }}
                    </option>
                @endforeach
            </select>
            <div class="selected-image-preview">
                @if($product->get_hover_image && file_exists(public_path($product->get_hover_image->path)))
                    <img class="pt-3" style="width: 100px; height: 100px;" src="{{ asset($product->get_hover_image->path) }}" alt="Hover Image" />
                @else
                    <p class="pt-3">No hover image available</p>
                @endif
            </div>
        </div>

    </div>
</section>
