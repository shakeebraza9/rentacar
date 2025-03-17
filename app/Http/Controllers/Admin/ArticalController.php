<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Help;
use App\Models\FileManager;
use App\Models\Category;

class ArticalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Help::query();

            // Searching
            if (!empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($s) use ($search) {
                    $s->where('title', 'like', '%' . $search . '%');
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

                $action = '<div class="btn-group" role="group">
                <a class="btn btn-info me-2" href="' . route('artical.edit', $blog->id) . '">Edit</a>
                <a class="btn btn-danger delete-btn" data-id="' . $blog->id . '" href="javascript:void(0)">Delete</a>
            </div>';
                $data[] = [
                    $blog->id,
                    htmlspecialchars($blog->title),
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

        return view('admin.artical.index');
    }

    public function create()
    {
        $categories = Category::where('is_enable', 1)->orderBy('title')->get();
        return view('admin.artical.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        Help::create([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => 1, 
        ]);
    
        return redirect()->back()->with('success', 'Article created successfully!');
    }

    public function edit($id)
    {
        $article = Help::findOrFail($id);
        $categories = Category::where('is_enable', 1)->orderBy('title')->get();
    
        return view('admin.artical.edit', compact('article', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        $article = Help::findOrFail($id);
        $article->update([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
        ]);
    
        return redirect()->back()->with('success', 'Article updated successfully!');
    }
    
    public function destroy($id)
    {
        $blog = Help::findOrFail($id);
        $blog->delete();

        return response()->json([
            'success' => 'Article deleted successfully!'
        ]);
    }
}