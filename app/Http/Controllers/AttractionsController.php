<?php
namespace App\Http\Controllers;


use App\Models\Brand;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Value;
use App\Models\Category;
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

class AttractionsController extends Controller
{
    public function home()
    {

        $categories = Category::where('is_enable',1)->where('is_featured',1)->where('parent_id',null)->get();
        // dd($categories);
        $sliders = Slider::where('is_enable',1)->get();
        $products = Product::where('is_enable',1)->where('is_featured',1)->where('category_id' ,44)->get();
        $reviews = ProductReview::join('users', 'product_reviews.user_id', '=', 'users.id')
        ->join('products', 'product_reviews.product_id', '=', 'products.id')
        ->join('filemanager', 'products.image', '=', 'filemanager.id') // Join with filemanager
        ->select('product_reviews.*',
                 'users.name as user_name',
                 'users.email as user_email',
                 'products.title as product_name',
                 'filemanager.path as image_path') // Select image path from filemanager
        ->where('product_reviews.active', 1)
        ->get();
        $blogs = DB::table('blogs')
        ->leftJoin('filemanager', 'blogs.image_id', '=', 'filemanager.id')
        ->leftJoin('users', 'blogs.user_id', '=', 'users.id')
        ->select(
            'blogs.*',
            'filemanager.path as image_path',
            'users.name as user_name'
        )
        ->get();
        $randomSlider = Slider::where('alignment', 'Home')->inRandomOrder()->first();

        return view('theme.attractions.home',compact('categories','products','sliders','reviews','blogs','randomSlider'));

    }
}