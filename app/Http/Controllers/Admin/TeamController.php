<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\OurTeam;
use App\Models\FileManager;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = OurTeam::query();


            if (!empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($s) use ($search) {
                    $s->where('name', 'like', '%' . $search . '%');
                });
            }

            $count = $query->count();


            $records = $query->offset($request->start)
                ->limit($request->length)
                ->get();

            // ✅ Data formatting
            $data = [];
            foreach ($records as $blog) {
                $imageUrl = $blog->image->path ? asset($blog->image->path) : asset('default.jpg');

                $action = '<div class="btn-group" role="group">
                <a class="btn btn-info me-2" href="' . route('team.edit', $blog->id) . '">Edit</a>
                <a class="btn btn-danger delete-btn" data-id="' . $blog->id . '" href="javascript:void(0)">Delete</a>
            </div>';
                $data[] = [
                    $blog->id,
                    htmlspecialchars($blog->name),
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

        return view('admin.team.index');
    }

    public function create()
    {
        $filemanager = FileManager::all(); 
        return view('admin.team.create', compact('filemanager'));
    }

    public function store(Request $request)
{

    $request->validate([
        'title' => 'required|string|max:255',
        'image_id' => 'nullable', 
        'position' => 'required|string|max:255',
        
    ]);


    $Memeber = OurTeam::create([
        'name' => $request->title,
        'image_id' => $request->image_id, 
        'position' => $request->position,

    ]);


    return redirect()->route('team.index')->with('success', 'Member created successfully!');
}


public function edit($id)
{
    $team = OurTeam::findOrFail($id);
    $filemanager = FileManager::all(); // Get all images for selection

    return view('admin.team.edit', compact('team', 'filemanager'));
}

public function update(Request $request, $id)
{
    $team = OurTeam::findOrFail($id);


    $request->validate([
        'title' => 'required|string|max:255',
        'image_id' => 'nullable', 
        'position' => 'required|string|max:255',
        
    ]);


    $team->update([
        'name' => $request->title,
        'image_id' => $request->image_id, 
        'position' => $request->position,
    ]);

    return redirect()->route('team.index')->with('success', 'Member updated successfully!');
}

    public function destroy($id)
    {
        $blog = OurTeam::findOrFail($id);
        $blog->delete();

        return response()->json([
            'success' => 'Member deleted successfully!'
        ]);
    }
}