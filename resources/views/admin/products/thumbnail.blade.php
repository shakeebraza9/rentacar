<section class="card">
    <header class="card-header bg-info">
        <h4 class="mb-0 text-white">Image</h4>
    </header>
    <div class="card-body">

        <!-- Thumbnail Selection (using a dropdown) -->
        <div class="form-group my-2">
            <label class="form-label" for="">Thumbnail :</label>

            <select name="image" class="form-control" id="image-selector">
                <option value="">Select Image</option>
                @foreach($filemanager as $file)
                    <option value="{{ $file->id }}"
                            @if($file->id == $product->image) selected @endif>
                        {{ $file->title }} <!-- Display title or any other text as needed -->
                    </option>
                @endforeach
            </select>

            @if($product->get_thumbnail && file_exists(public_path($product->get_thumbnail->path)))
                <img class="pt-3" style="width: 100px" height="100px" src="{{ asset($product->get_thumbnail->path) }}" alt="Thumbnail" />
            @else
                <p>No thumbnail available</p>
            @endif
        </div>

        <hr>

        <!-- Hover Image Selection (using a dropdown) -->
        <div class="form-group my-2">
            <label class="form-label" for="">Hover Image :</label>

            <select name="hover_image" class="form-control" id="hover-image-selector">
                <option value="">Select Hover Image</option>
                @foreach($filemanager as $file)
                    <option value="{{ $file->id }}"
                            @if($file->id == $product->hover_image) selected @endif>
                        {{ $file->title }}
                    </option>
                @endforeach
            </select>

            @if($product->get_hover_image && file_exists(public_path($product->get_hover_image->path)))
                <img class="pt-3" style="width: 100px" height="100px" src="{{ asset($product->get_hover_image->path) }}" alt="Hover Image" />
            @else
                <p>No hover image available</p>
            @endif
        </div>

    </div>
</section>
