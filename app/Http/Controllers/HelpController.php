<?php

namespace App\Http\Controllers;


use App\Models\Brand;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Value;
use App\Models\Category;
use App\Models\Help;
use App\Models\ProductReview;
use App\Models\Collection;
use App\Models\Page;
use App\Models\ProductCollection;
use App\Models\Variation;
use App\Models\VariationAttribute;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Part\HtmlPart;
use Illuminate\Support\Facades\DB;


class HelpController extends Controller
{


    public function help()
    {
        $categories = Category::where('is_enable',1)->where('is_featured',1)->get();

        return view('theme.help',compact('categories'));

    }
    public function show($id)
    {
        $category = Category::with(['helpEntries' => function($query){
            $query->where('status', 1);
        }])->findOrFail($id);

        return view('theme.category-details', compact('category'));
    }

    public function details($id)
    {

        $helpEntry = Help::with('category')->findOrFail($id);
        $category = $helpEntry->category;
        $relatedEntries = Help::where('category_id', $category->id)
            ->where('id', '!=', $id)
            ->latest()
            ->take(5)
            ->get();

        return view('theme.help-details', compact('helpEntry', 'category', 'relatedEntries'));
    }




}