<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class BlogController extends Controller
{
    public function index()
    {
        $blogs = DB::table('blogs')
    ->leftJoin('filemanager', 'blogs.image_id', '=', 'filemanager.id') 
    ->leftJoin('users', 'blogs.user_id', '=', 'users.id')
    ->select(
        'blogs.*', 
        'filemanager.path as image_path', 
        'users.name as user_name'
    )
    ->get();

    
        return view('theme.blog.index', compact('blogs'));
    }

    public function show($slug)
    {
     
        $blog = Blog::with(['author', 'image'])->where('slug', $slug)->firstOrFail();

        $posts = Blog::latest()->take(5)->get(); 
    
        return view('theme.blog.show', compact('blog', 'posts'));
    }
}
