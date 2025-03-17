<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\FileManager;

class BlogAdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Blog::query();

            // Searching
            if (!empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($s) use ($search) {
                    $s->where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('location', 'like', '%' . $search . '%');
                });
            }

            $count = $query->count(); // Total count before pagination

            // Pagination
            $records = $query->offset($request->start)
                ->limit($request->length)
                ->get();

            // ✅ Data formatting
            $data = [];
            foreach ($records as $blog) {
                $imageUrl = $blog->image->path ? asset($blog->image->path) : asset('default.jpg');

                $action = '<div class="btn-group" role="group">
                <a class="btn btn-info me-2" href="' . route('blog.edit', $blog->id) . '">Edit</a>
                <a class="btn btn-danger delete-btn" data-id="' . $blog->id . '" href="javascript:void(0)">Delete</a>
            </div>';
                $data[] = [
                    $blog->id,
                    htmlspecialchars($blog->title),
                    '<img src="' . $imageUrl . '" style="width:50px; height:50px; object-fit:cover;" />',
                    htmlspecialchars($blog->location ?? 'N/A'),
                    $action
                ];
            }

            return response()->json([
                "draw" => intval($request->draw),
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                'data' => $data,
            ]);
        }

        return view('admin.blog.index');
    }

    public function create()
    {
        $filemanager = FileManager::all(); // Fetch all images
        return view('admin.blog.create', compact('filemanager'));
    }

    public function store(Request $request)
{
    // ✅ Validate the input data
    $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:blogs,slug',
        'image_id' => 'nullable', // Ensure the image exists
        'description' => 'required|string',
        'short_description' => 'nullable|string',
        'location' => 'nullable|string|max:255',
    ]);

    // ✅ Save Blog
    $blog = Blog::create([
        'title' => $request->title,
        'slug' => $request->slug,
        'image_id' => $request->image_id, // Save image ID
        'description' => $request->description,
        'short_description' => $request->short_description,
        'location' => $request->location,
        'user_id' => auth()->id(), // Assuming blog is created by a logged-in user
    ]);

    // ✅ Redirect with success message
    return redirect()->route('blog.index.admin')->with('success', 'Blog created successfully!');
}


public function edit($id)
{
    $blog = Blog::findOrFail($id);
    $filemanager = FileManager::all(); // Get all images for selection

    return view('admin.blog.edit', compact('blog', 'filemanager'));
}

public function update(Request $request, $id)
{
    $blog = Blog::findOrFail($id);

    // ✅ Validate the input data
    $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:blogs,slug,' . $id,
        'image_id' => 'nullable', // Ensure image exists
        'description' => 'required|string',
        'short_description' => 'nullable|string',
        'location' => 'nullable|string|max:255',
    ]);

    // ✅ Update Blog
    $blog->update([
        'title' => $request->title,
        'slug' => $request->slug,
        'image_id' => $request->image_id, // Save selected image
        'description' => $request->description,
        'short_description' => $request->short_description,
        'location' => $request->location,
    ]);

    return redirect()->route('blog.index.admin')->with('success', 'Blog updated successfully!');
}

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return response()->json([
            'success' => 'Blog deleted successfully!'
        ]);
    }
}