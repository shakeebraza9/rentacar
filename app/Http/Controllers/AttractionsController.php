<?php
namespace App\Http\Controllers;


use App\Models\Brand;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Value;
use App\Models\Category;
use App\Models\Attraction;
use App\Models\ProductReview;
use App\Models\Collection;
use App\Models\Ticket;
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



        $attractions  = Attraction::where('status',1)->get();
        $reviews = ProductReview::join('users', 'product_reviews.user_id', '=', 'users.id')
        ->join('products', 'product_reviews.product_id', '=', 'products.id')
        ->join('filemanager', 'products.image', '=', 'filemanager.id')
        ->select('product_reviews.*',
                 'users.name as user_name',
                 'users.email as user_email',
                 'products.title as product_name',
                 'filemanager.path as image_path')
        ->where('product_reviews.active', 1)
        ->get();

        $randomSlider = Slider::where('alignment', 'Attractions')->inRandomOrder()->first();

        return view('theme.attractions.home',compact('attractions','reviews','randomSlider'));

    }

    public function attractionsdetail($slug)
    {
        $attraction = Attraction::where('slug', $slug)->first();


        if (!$attraction) {
            return abort(404, 'Attraction not found');
        }


        $allAttractions = Attraction::where('status', 1)->get();
        $tickets = Ticket::where('attraction_id', $attraction->id)->where('status', 'active') ->with('variations')->get();
        $reviews = ProductReview::join('users', 'product_reviews.user_id', '=', 'users.id')
        ->join('products', 'product_reviews.product_id', '=', 'products.id')
        ->join('filemanager', 'products.image', '=', 'filemanager.id') // Join with filemanager
        ->select(
            'product_reviews.*',
            'users.name as user_name',
            'users.email as user_email',
            'products.title as product_name',
            'filemanager.path as image_path' // Select image path from filemanager
        )
        ->where('product_reviews.active', 1)
        ->orderBy('product_reviews.sort_order', 'ASC') // ✅ Sorting by sort_order
        ->get();


        // Pass data to the view
        return view('theme.attractions.detail', compact('attraction', 'allAttractions', 'tickets', 'reviews'));
    }

}
