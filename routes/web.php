<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\PaymentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function(){

    return redirect('/admin/login');
})->name('home');


//Blogs
Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
Route::get('/category/{id}', [App\Http\Controllers\HomeController::class, 'category']);
Route::get('/pages/{slug}', [App\Http\Controllers\HomeController::class, 'pageContent'])->name('pages.show');
Route::get('/reviews', [App\Http\Controllers\HomeController::class, 'reviews'])->name('reviews.index');

Route::get('/help', [App\Http\Controllers\HelpController::class, 'help'])->name('help.index');


// attractions
Route::get('/attractions', [App\Http\Controllers\AttractionsController::class, 'home'])->name('attractions');
Route::get('/attractions/detail{slug}', [App\Http\Controllers\AttractionsController::class, 'attractionsdetail'])->name('attractions.detail');
Route::get('/attractions/list', [App\Http\Controllers\AttractionsController::class, 'attractionslist'])->name('attractions.list');





Route::get('/booking/{slug}', [App\Http\Controllers\BookingController::class, 'show'])->name('booking');
Route::get('/bookingfilter/{data}', [App\Http\Controllers\BookingController::class, 'show2'])->name('bookingfilter');

Route::get('/customer/orders/{slug}', [App\Http\Controllers\BookingController::class, 'index'])
    ->name('customers.orders');

    Route::post('/cusmotercheckout', [App\Http\Controllers\BookingController::class, 'checkout'])
    ->name('cusmoter.checkout');


Route::get('/products/{id}', [App\Http\Controllers\HomeController::class, 'product']);

Route::get('/shop', [App\Http\Controllers\HomeController::class, 'shop']);
Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blogs/{slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blogs.show');
// Route::post('/cart/add_to_cart', [App\Http\Controllers\HomeController::class, 'add_to_cart']);

Route::get('/combination_maker', [App\Http\Controllers\HomeController::class, 'combination_maker']);
Route::get('/blogs/categories/{id}', [App\Http\Controllers\HomeController::class, 'blog_categories']);


//Carts
Route::get('/cart', [App\Http\Controllers\CartController::class, 'cart']);
Route::get('/cart/add_to_cart', [App\Http\Controllers\CartController::class, 'add_to_cart']);
Route::get('/cart/get_cart_details', [App\Http\Controllers\CartController::class, 'get_cart_details']);
Route::get('/cart/cart_clear', [App\Http\Controllers\CartController::class, 'cart_clear']);
Route::get('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'cart_remove']);

//Checkout
Route::get('/order-tracking', [App\Http\Controllers\CheckoutController::class, 'order_tracking']);


Route::get('/order-confirmaton/{id}', [App\Http\Controllers\CheckoutController::class, 'order_confirmaton']);
Route::post('/checkout/submit', [App\Http\Controllers\CheckoutController::class, 'checkout_submit']);
Route::get('/get_invoice/{id}', [App\Http\Controllers\CheckoutController::class, 'get_invoice']);

// testing
Route::get('/test', [App\Http\Controllers\HomeController::class, 'test']);

// Website login
Route::get('/login', [App\Http\Controllers\WebAuthController::class, 'login'])->name('weblogin');
Route::get('/register', [App\Http\Controllers\WebAuthController::class, 'register'])->name('register');
Route::get('/forgotpassword', [App\Http\Controllers\WebAuthController::class, 'forgotPassword'])->name('forgotpassword');
Route::post('/createaccount', [App\Http\Controllers\WebAuthController::class, 'createAccount'])->name('createAccount');
Route::post('/weblogin', [App\Http\Controllers\WebAuthController::class, 'webLogin'])->name('webpostlogin');
Route::post('/password-reset-request', [App\Http\Controllers\WebAuthController::class, 'sendResetLink'])->name('resetpassword');

// dashboard login Group
Route::middleware(['webLoginChk'])->group(function () {
  Route::get('/dashboard', [App\Http\Controllers\WebAuthController::class, 'dashboard'])->name('dashboard');
  Route::get('/logout', [App\Http\Controllers\WebAuthController::class, 'weblogout'])->name('weblogout');
  Route::get('/profile', [App\Http\Controllers\CustomerController::class, 'profile'])->name('customer.profile');
  Route::get('/customer/users/chnagepassword', [App\Http\Controllers\CustomerController::class, 'chnagepassword'])->name('chngpassword');
  Route::post('/customer/users/changepassword', [App\Http\Controllers\CustomerController::class, 'changePassword'])->name('customer.changePassword');
  Route::get('/customer/users/updateprofile', [App\Http\Controllers\CustomerController::class, 'updateprofile'])->name('updateprofile');
  Route::post('/customer/users/updateprofile', [App\Http\Controllers\CustomerController::class, 'updateprofilepost'])->name('profile.update');
  Route::get('/customer/users/userbankaccount', [App\Http\Controllers\CustomerController::class, 'userbankaccount'])->name('userbankaccount');
  Route::post('/customer/users/updatebankdetails', [App\Http\Controllers\CustomerController::class, 'updateBankDetails'])->name('updateBankDetails');

  Route::get('/carts', [App\Http\Controllers\CustomerController::class, 'carts'])->name('customer.carts');
    Route::get('/history', [App\Http\Controllers\CustomerController::class, 'history'])->name('customer.history');
    Route::get('/referral', [App\Http\Controllers\CustomerController::class, 'referral'])->name('customer.referral');
    Route::get('/cases', [App\Http\Controllers\CustomerController::class, 'cases'])->name('customer.cases');
});


//Admin
Route::get('/admin/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login');
Route::post('/admin/login_submit', [App\Http\Controllers\Admin\AuthController::class, 'login_submit']);

Route::middleware(['web', 'auth'])->group(function () {

Route::get('/admin/update_file_url', [App\Http\Controllers\Admin\DashboardController::class, 'update_file_url']);
Route::get('/admin/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout']);
Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard']);
Route::get('/admin/changepassword', [App\Http\Controllers\Admin\DashboardController::class, 'changepassword']);
Route::post('/admin/changepassword_submit', [App\Http\Controllers\Admin\DashboardController::class, 'changepassword_submit']);
Route::get('/admin/status', [App\Http\Controllers\Admin\DashboardController::class, 'status']);


//Users
    Route::get('/admin/users/index', [App\Http\Controllers\Admin\UserController::class, 'index']);
    Route::get('/admin/users/create', [App\Http\Controllers\Admin\UserController::class, 'create']);
    Route::post('/admin/users/store', [App\Http\Controllers\Admin\UserController::class, 'store']);
    Route::get('/admin/users/edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'edit']);
    Route::post('/admin/users/update/{id}', [App\Http\Controllers\Admin\UserController::class, 'update']);
    Route::get('/admin/users/delete/{id}', [App\Http\Controllers\Admin\UserController::class, 'delete']);

//Roles
    Route::get('/admin/roles/index', [App\Http\Controllers\Admin\RoleController::class, 'index']);
    Route::get('/admin/roles/create', [App\Http\Controllers\Admin\RoleController::class, 'create']);
    Route::post('/admin/roles/store', [App\Http\Controllers\Admin\RoleController::class, 'store']);
    Route::get('/admin/roles/edit/{id}', [App\Http\Controllers\Admin\RoleController::class, 'edit']);
    Route::post('/admin/roles/update/{id}', [App\Http\Controllers\Admin\RoleController::class, 'update']);
    Route::get('/admin/roles/delete/{id}', [App\Http\Controllers\Admin\RoleController::class, 'delete']);

//Menus
  Route::get('/admin/menus/index', [App\Http\Controllers\Admin\MenuController::class, 'index']);
  Route::get('/admin/menus/create', [App\Http\Controllers\Admin\MenuController::class, 'create']);
  Route::post('/admin/menus/store', [App\Http\Controllers\Admin\MenuController::class, 'store']);
  Route::get('/admin/menus/edit/{id}', [App\Http\Controllers\Admin\MenuController::class, 'edit']);
  Route::post('/admin/menus/update/{id}', [App\Http\Controllers\Admin\MenuController::class, 'update']);
  Route::get('/admin/menus/delete/{id}', [App\Http\Controllers\Admin\MenuController::class, 'delete']);

//Menus Items
  Route::get('/admin/menus_items/{menu}/index', [App\Http\Controllers\Admin\MenuItemController::class,'index']);
  Route::post('/admin/menus_items/store', [App\Http\Controllers\Admin\MenuItemController::class,'store']);
  Route::get('/admin/menus_items/sort/{id}', [App\Http\Controllers\Admin\MenuItemController::class, 'sort']);
  Route::get('/admin/menus_items/edit/{id}', [App\Http\Controllers\Admin\MenuItemController::class, 'edit']);
  Route::post('/admin/menus_items/update/{id}', [App\Http\Controllers\Admin\MenuItemController::class, 'update']);
  Route::get('/admin/menus_items/delete/{id}', [App\Http\Controllers\Admin\MenuItemController::class, 'delete']);


//products
    Route::get('/admin/products/index', [App\Http\Controllers\Admin\ProductController::class, 'index']);
    Route::get('/admin/products/create', [App\Http\Controllers\Admin\ProductController::class, 'create']);
    Route::post('/admin/products/store', [App\Http\Controllers\Admin\ProductController::class, 'store']);
    Route::get('/admin/products/edit/{id}', [App\Http\Controllers\Admin\ProductController::class, 'edit']);
    Route::post('/admin/products/update/{id}', [App\Http\Controllers\Admin\ProductController::class, 'update']);
    Route::get('/admin/products/remove-image/{id}', [App\Http\Controllers\Admin\ProductController::class, 'remove_image']);
    Route::get('/admin/products/delete/{id}', [App\Http\Controllers\Admin\ProductController::class, 'delete']);
    Route::post('/admin/products/variations/{id}', [App\Http\Controllers\Admin\ProductController::class, 'variations']);
    Route::get('/admin/products/remove-variation/{id}', [App\Http\Controllers\Admin\ProductController::class, 'remove_variation']);




    //Attractions
    Route::get('/admin/attractions/index', [App\Http\Controllers\Admin\AttractionsController::class, 'index'])->name('attractions.index');
    Route::get('/admin/attractions/create', [App\Http\Controllers\Admin\AttractionsController::class, 'create'])->name('attractions.create');
    Route::post('/admin/attractions/store', [App\Http\Controllers\Admin\AttractionsController::class, 'store']);
    Route::get('/admin/attractions/edit/{id}', [App\Http\Controllers\Admin\AttractionsController::class, 'edit'])->name('attractions.edit');
    Route::post('/admin/attractions/update/{id}', [App\Http\Controllers\Admin\AttractionsController::class, 'update']);
    Route::get('/admin/attractions/delete/{id}', [App\Http\Controllers\Admin\AttractionsController::class, 'delete'])->name('attractions.delete');

    //Ticket
    Route::get('/admin/ticket/index', [App\Http\Controllers\Admin\TicketController::class, 'index'])->name('ticket.index');
    Route::get('/admin/ticket/create', [App\Http\Controllers\Admin\TicketController::class, 'create'])->name('ticket.create');
    Route::post('/admin/ticket/store', [App\Http\Controllers\Admin\TicketController::class, 'store']);
    Route::get('/admin/ticket/edit/{id}', [App\Http\Controllers\Admin\TicketController::class, 'edit'])->name('ticket.edit');
    Route::post('/admin/ticket/update/{id}', [App\Http\Controllers\Admin\TicketController::class, 'update'])->name('ticket.update');
    Route::get('/admin/ticket/delete/{id}', [App\Http\Controllers\Admin\TicketController::class, 'delete'])->name('ticket.delete');


    //orders
    Route::get('/admin/orders/index', [App\Http\Controllers\Admin\OrderController::class, 'index']);
    Route::get('/admin/orders/edit/{id}', [App\Http\Controllers\Admin\OrderController::class, 'edit']);
    Route::put('/admin/orders/update/{id}', [App\Http\Controllers\Admin\OrderController::class, 'update'])->name("admin.orders.update");

    //Review
    // Route::get('admin/review/index', [App\Http\Controllers\Admin\ReviewController::class, 'index']);
    Route::get('admin/review/index', [App\Http\Controllers\ReviewController::class, 'index']);
    // client Report
    Route::get('/admin/reports/clients/index', [App\Http\Controllers\Admin\ReportsController::class, 'clientIndex']);



    //Sliders
    Route::get('/admin/sliders/index', [App\Http\Controllers\Admin\SliderController::class, 'index']);
    Route::get('/admin/sliders/create', [App\Http\Controllers\Admin\SliderController::class, 'create']);
    Route::post('/admin/sliders/store', [App\Http\Controllers\Admin\SliderController::class, 'store']);
    Route::get('/admin/sliders/edit/{id}', [App\Http\Controllers\Admin\SliderController::class, 'edit']);
    Route::post('/admin/sliders/update/{id}', [App\Http\Controllers\Admin\SliderController::class, 'update']);
    Route::get('/admin/sliders/delete/{id}', [App\Http\Controllers\Admin\SliderController::class, 'delete']);


    //Collections
    Route::get('/admin/collections/index', [App\Http\Controllers\Admin\CollectionController::class, 'index']);
    Route::get('/admin/collections/create', [App\Http\Controllers\Admin\CollectionController::class, 'create']);
    Route::post('/admin/collections/store', [App\Http\Controllers\Admin\CollectionController::class, 'store']);
    Route::get('/admin/collections/edit/{id}', [App\Http\Controllers\Admin\CollectionController::class, 'edit']);
    Route::post('/admin/collections/update/{id}', [App\Http\Controllers\Admin\CollectionController::class, 'update']);
    Route::get('/admin/collections/delete/{id}', [App\Http\Controllers\Admin\CollectionController::class, 'delete']);

    //page
    Route::get('/admin/page/index', [App\Http\Controllers\Admin\PageController::class, 'index']);
    Route::get('/admin/page/edit/{id}', [App\Http\Controllers\Admin\PageController::class, 'edit']);
    Route::get('/admin/page/create', [App\Http\Controllers\Admin\PageController::class, 'create']);
    Route::post('/admin/page/store', [App\Http\Controllers\Admin\PageController::class, 'store']);
    Route::post('/admin/page/update/{id}', [App\Http\Controllers\Admin\PageController::class, 'update']);
    Route::get('/admin/page/delete/{id}', [App\Http\Controllers\Admin\PageController::class, 'delete']);

    //products category
    Route::get('/admin/categories/index', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');;
    Route::get('admin/categories/subcategories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'showSubcategories']);
    Route::post('/admin/subcategory', [App\Http\Controllers\Admin\CategoryController::class, 'storesubcat'])->name('storesubcate');
    Route::get('admin/categories/subcategories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'showSubcategories']);
    Route::get('admin/categories/subcategoriesedit/{id}/edit',
    [App\Http\Controllers\Admin\CategoryController::class, 'editSubcategories']
)->name('editSubcategories');
Route::put('admin/categories/subcategories/update/{id}',
    [App\Http\Controllers\Admin\CategoryController::class, 'updateSubcategory']
)->name('updatesubcate');


    Route::get('/admin/subcategory/{id}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('admin.subcategory.edit');

    Route::delete('admin/subcategory/destroy/{id}',
    [App\Http\Controllers\Admin\CategoryController::class, 'destroySubcategory']
)->name('admin.subcategory.destroy');

Route::get('/admin/categories/create', [App\Http\Controllers\Admin\CategoryController::class, 'create']);
    Route::post('/admin/categories/store', [App\Http\Controllers\Admin\CategoryController::class, 'store']);
    Route::get('/admin/categories/sort', [App\Http\Controllers\Admin\CategoryController::class, 'sort']);
    Route::get('/admin/categories/edit/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'edit']);
    Route::post('/admin/categories/update/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update']);
    Route::get('/admin/categories/delete/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'delete']);

  //filemanager
    Route::get('admin/filemanager',[App\Http\Controllers\Admin\FilemanagerController::class,'index']);
    Route::get('admin/filemanager/create',[App\Http\Controllers\Admin\FilemanagerController::class,'create']);
    Route::post('admin/filemanager/store',[App\Http\Controllers\Admin\FilemanagerController::class,'store']);
    Route::get('admin/filemanager/edit/{id}',[App\Http\Controllers\Admin\FilemanagerController::class,'edit']);
    Route::post('admin/filemanager/update/{id}',[App\Http\Controllers\Admin\FilemanagerController::class,'update']);
    Route::get('admin/filemanager/delete/{id}',[App\Http\Controllers\Admin\FilemanagerController::class,'delete']);

  //Settings
    Route::get('admin/settings/edit', [App\Http\Controllers\Admin\SettingController::class, 'edit']);
    Route::post('admin/settings/update', [App\Http\Controllers\Admin\SettingController::class, 'update']);


    // payments
    Route::get('/checkout/{order_id}', [PaymentController::class, 'checkout'])->name('checkout');

    Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('process.payment');
    Route::get('/payment/success{order_id}', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

});

// Auth::routes();

Route::fallback(function () {
    return redirect('/');
});