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
Route::get('/category/{id}', [App\Http\Controllers\HelpController::class, 'show'])->name('category.show');
Route::get('/help-entry/{id}', [App\Http\Controllers\HelpController::class, 'details'])->name('help.entry.show');
Route::get('/help-search', [App\Http\Controllers\HelpController::class, 'search'])->name('help.search');

// attractions
Route::get('/attractions', [App\Http\Controllers\AttractionsController::class, 'home'])->name('attractions');
Route::get('/attractions/detail/{slug}', [App\Http\Controllers\AttractionsController::class, 'attractionsdetail'])->name('attractions.detail');
Route::get('/attractions/list', [App\Http\Controllers\AttractionsController::class, 'attractionslist'])->name('attractions.list');


// ticket
Route::Post('/check-availability', [App\Http\Controllers\TicketController::class, 'checkAvailability']);
Route::get('/book-ticket', [App\Http\Controllers\TicketController::class, 'bookTicket'])->name('book.ticket');
Route::Post('/place-order-ticket', [App\Http\Controllers\TicketController::class, 'placeorder'])->name('place.order');
Route::get('/checkoutticket/{order_id}', [App\Http\Controllers\TicketController::class, 'checkoutPage'])->name('place.checkout');
Route::post('/process-payment-ticket', [App\Http\Controllers\PaymentTicketController::class, 'processPayment'])->name('process.payment.ticket');
Route::get('/payment/success-ticket{order_id}', [App\Http\Controllers\PaymentTicketController::class, 'success'])->name('payment.success.ticket');
Route::get('/payment/cancel-ticket', [App\Http\Controllers\PaymentTicketController::class, 'cancel'])->name('payment.cancel.ticket');


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
Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('process.payment');
Route::get('/payment/success{order_id}', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

//Carts
Route::get('/cart', [App\Http\Controllers\CartController::class, 'cart']);
Route::get('/cart/add_to_cart', [App\Http\Controllers\CartController::class, 'add_to_cart']);
Route::get('/cart/get_cart_details', [App\Http\Controllers\CartController::class, 'get_cart_details']);
Route::get('/cart/cart_clear', [App\Http\Controllers\CartController::class, 'cart_clear']);
Route::get('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'cart_remove']);


Route::get('/order-tracking', [App\Http\Controllers\CheckoutController::class, 'order_tracking']);
Route::get('/checkout/{order_id}', [PaymentController::class, 'checkout'])->name('checkout');
Route::get('/checkoutdeposit/{order_id}', [PaymentController::class, 'checkoutdeposit'])->name('checkoutdeposit');

Route::get('/order-confirmaton/{id}', [App\Http\Controllers\CheckoutController::class, 'order_confirmaton']);
Route::post('/checkout/submit', [App\Http\Controllers\CheckoutController::class, 'checkout_submit']);
Route::get('/get_invoice/{id}', [App\Http\Controllers\CheckoutController::class, 'get_invoice']);

Route::post('/deposit/payment', [App\Http\Controllers\DepositePaymentController::class, 'processPayment'])->name('deposit.payment');
Route::get('/depositpayment/success', [App\Http\Controllers\DepositePaymentController::class, 'paymentSuccess'])->name('depositpayment.success');
Route::get('/depositpayment/cancel', [App\Http\Controllers\DepositePaymentController::class, 'paymentCancel'])->name('depositpayment.cancel');


Route::get('/test', [App\Http\Controllers\HomeController::class, 'test']);


Route::get('/login', [App\Http\Controllers\WebAuthController::class, 'login'])->name('weblogin');
Route::get('/register', [App\Http\Controllers\WebAuthController::class, 'register'])->name('register');

Route::get('/email/verify/{token}', [App\Http\Controllers\WebAuthController::class, 'verify'])->name('verify.email');
Route::get('/forgotpassword', [App\Http\Controllers\WebAuthController::class, 'forgotPassword'])->name('forgotpassword');
Route::post('/sendlink', [App\Http\Controllers\WebAuthController::class, 'sendResetLink'])->name('sendlink');
Route::get('/reset-password/{token}', [App\Http\Controllers\WebAuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\WebAuthController::class, 'resetPassword'])->name('password.update');

Route::post('/createaccount', [App\Http\Controllers\WebAuthController::class, 'createAccount'])->name('createAccount');
Route::post('/weblogin', [App\Http\Controllers\WebAuthController::class, 'webLogin'])->name('webpostlogin');
Route::post('/password-reset-request', [App\Http\Controllers\WebAuthController::class, 'sendResetLink'])->name('resetpassword');
Route::get('/logout', [App\Http\Controllers\WebAuthController::class, 'weblogout'])->name('weblogout');
Route::post('/submit-report', [App\Http\Controllers\ReportController::class, 'store'])->name('submit-report');
Route::get('/our-team', [App\Http\Controllers\OurTeamController::class, 'index'])->name('our-team');





    Route::middleware(['webLoginChk'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\WebAuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [App\Http\Controllers\CustomerController::class, 'profile'])->name('customer.profile');
    Route::get('/customer/users/chnagepassword', [App\Http\Controllers\CustomerController::class, 'chnagepassword'])->name('chngpassword');
    Route::post('/customer/users/changepassword', [App\Http\Controllers\CustomerController::class, 'changePassword'])->name('customer.changePassword');
    Route::get('/customer/users/updateprofile', [App\Http\Controllers\CustomerController::class, 'updateprofile'])->name('updateprofile');
    Route::post('/customer/users/updateprofile', [App\Http\Controllers\CustomerController::class, 'updateprofilepost'])->name('profile.update');
    Route::get('/customer/users/userbankaccount', [App\Http\Controllers\CustomerController::class, 'userbankaccount'])->name('userbankaccount');
    Route::post('/customer/users/updatebankdetails', [App\Http\Controllers\CustomerController::class, 'updateBankDetails'])->name('updateBankDetails');

    Route::get('/carts', [App\Http\Controllers\CustomerController::class, 'carts'])->name('customer.carts');
    Route::get('/history', [App\Http\Controllers\CustomerController::class, 'history'])->name('customer.history');
    Route::get('/orderdetails/{id}', [App\Http\Controllers\CustomerController::class, 'details'])->name('order.details');
    Route::get('/referral', [App\Http\Controllers\CustomerController::class, 'referral'])->name('customer.referral');
    Route::get('/cases', [App\Http\Controllers\CustomerController::class, 'cases'])->name('customer.cases');




    Route::get('/ticket/details/{id}', [App\Http\Controllers\CustomerController::class, 'ticketdetails'])->name('ticket.details');
    Route::get('/product/review/{product_id}', [App\Http\Controllers\ReviewController::class, 'show'])->name('product.Review');
    Route::post('/product/review/submit', [App\Http\Controllers\ReviewController::class, 'store'])->name('product.submitReview');

});


//Admin
Route::get('/admin/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login');
Route::post('/admin/login_submit', [App\Http\Controllers\Admin\AuthController::class, 'login_submit']);

Route::middleware(['web', 'auth', 'admin'])->group(function () {

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
    Route::post('/admin/users/update-role', [App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('admin.users.updateRole');


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

    // car type

Route::get('/admin/cartype/index', [App\Http\Controllers\Admin\CarTypeController::class, 'index'])->name('admin.cartype.index');
Route::get('/admin/cartype/create', [App\Http\Controllers\Admin\CarTypeController::class, 'create'])->name('admin.cartype.create');
Route::post('/admin/cartype/store', [App\Http\Controllers\Admin\CarTypeController::class, 'store'])->name('admin.cartype.store');

Route::get('/admin/cartype/edit/{id}', [App\Http\Controllers\Admin\CarTypeController::class, 'edit'])->name('admin.cartype.edit');
Route::post('/admin/cartype/update/{id}', [App\Http\Controllers\Admin\CarTypeController::class, 'update'])->name('admin.cartype.update');

Route::delete('/admin/cartype/delete/{id}', [App\Http\Controllers\Admin\CarTypeController::class, 'destroy'])->name('admin.cartype.delete');
Route::get('/admin/cartype/peakseason', [App\Http\Controllers\Admin\CarTypeController::class, 'peakseason'])->name('admin.peakseason.create');
Route::post('/admin/peakseason/store', [App\Http\Controllers\Admin\CarTypeController::class, 'peakseasonstore'])->name('admin.peakseason.store');
Route::get('/admin/cartype/fetach', [App\Http\Controllers\Admin\CarTypeController::class, 'getCarTypes'])->name('admin.fetach.cartpe');
Route::post('/admin/peakseason/updatestatus', [App\Http\Controllers\Admin\CarTypeController::class, 'peakseasonupdatestatus'])->name('admin.peakseasonupdatestatus.store');
Route::post('/admin/peakseason/delete-season', [App\Http\Controllers\Admin\CarTypeController::class, 'deleteSeason'])->name('delete.season');
Route::get('/admin/peakseason/edit/{id}', [App\Http\Controllers\Admin\CarTypeController::class, 'peakseasonedit'])->name('admin.peakseason.edit');
Route::put('/admin/peakseason/update-season/{id}', [App\Http\Controllers\Admin\CarTypeController::class, 'updateSeason'])->name('admin.peakseason.update');





//Attractions
Route::get('/admin/attractions/index', [App\Http\Controllers\Admin\AttractionsController::class, 'index'])->name('attractions.index');
Route::get('/admin/attractions/create', [App\Http\Controllers\Admin\AttractionsController::class, 'create'])->name('attractions.create');
Route::post('/admin/attractions/store', [App\Http\Controllers\Admin\AttractionsController::class, 'store']);
Route::get('/admin/attractions/edit/{id}', [App\Http\Controllers\Admin\AttractionsController::class, 'edit'])->name('attractions.edit');
Route::post('/admin/attractions/gallery/remove', [App\Http\Controllers\Admin\AttractionsController::class, 'removeGalleryImage'])->name('admin.galleryattractions.remove');

Route::post('/admin/attractions/update/{id}', [App\Http\Controllers\Admin\AttractionsController::class, 'update']);
Route::get('/admin/attractions/delete/{id}', [App\Http\Controllers\Admin\AttractionsController::class, 'delete'])->name('attractions.delete');

//Ticket
    Route::get('/admin/ticket/index', [App\Http\Controllers\Admin\TicketController::class, 'index'])->name('ticket.index');
    Route::get('/admin/ticket/create', [App\Http\Controllers\Admin\TicketController::class, 'create'])->name('ticket.create');
    Route::post('/admin/ticket/store', [App\Http\Controllers\Admin\TicketController::class, 'store']);
    Route::get('/admin/ticket/edit/{id}', [App\Http\Controllers\Admin\TicketController::class, 'edit'])->name('ticket.edit');
    Route::post('/admin/ticket/update/{id}', [App\Http\Controllers\Admin\TicketController::class, 'update'])->name('ticket.update');
    Route::get('/admin/ticket/delete/{id}', [App\Http\Controllers\Admin\TicketController::class, 'delete'])->name('ticket.delete');

    // Order Ticket
    Route::get('/admin/ticketorders/index', [App\Http\Controllers\Admin\TicketOrderController::class, 'index']);
    Route::get('/admin/ticketorders/edit/{id}', [App\Http\Controllers\Admin\TicketOrderController::class, 'edit']);
    Route::Post('/admin/ticketorders/update/{id}', [App\Http\Controllers\Admin\TicketOrderController::class, 'update'])->name("admin.ticketorders.update");
    Route::prefix('admin/ordersticket')->name('admin.ordersticket.')->group(function () {
        Route::get('/send-confirmation/{id}', [App\Http\Controllers\Admin\TicketOrderController::class, 'sendConfirmation'])->name('sendConfirmation');
        Route::get('/download-invoice/{id}', [App\Http\Controllers\Admin\TicketOrderController::class, 'downloadInvoice'])->name('downloadInvoice');
    });

    Route::delete('/admin/ordersticket/delete/{id}', [App\Http\Controllers\Admin\TicketOrderController::class, 'delete'])
    ->name('admin.ordersticket.delete');




    //orders
    Route::get('/admin/orders/index', [App\Http\Controllers\Admin\OrderController::class, 'index']);
    Route::get('/admin/orders/edit/{id}', [App\Http\Controllers\Admin\OrderController::class, 'edit']);
    Route::put('/admin/orders/update/{id}', [App\Http\Controllers\Admin\OrderController::class, 'update'])->name("admin.orders.update");
    Route::post('/admin/orders/update-pickup-deliver/{id}', [App\Http\Controllers\Admin\OrderController::class, 'updatePickupDeliver'])->name('admin.orders.updatePickupDeliver');
    Route::get('/admin/orders/get-total-time/{id}', [App\Http\Controllers\Admin\OrderController::class, 'getTotalTime'])->name('admin.orders.getTotalTime');
    Route::post('/admin/send-extra-payment-email/{id}', [App\Http\Controllers\Admin\OrderController::class, 'sendExtraPaymentEmail'])->name('send.extra.payment.email');
    Route::get('/admin/orders/download-invoice/{id}', [App\Http\Controllers\Admin\OrderController::class, 'downloadInvoice'])
    ->name('admin.orders.download-invoice');

    Route::delete('/admin/orders/delete/{id}', [App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('orders.delete');

    //Review
    // Route::get('admin/review/index', [App\Http\Controllers\Admin\ReviewController::class, 'index']);
    Route::get('admin/review/index', [App\Http\Controllers\ReviewController::class, 'index']);
    Route::get('admin/review/add', [App\Http\Controllers\ReviewController::class, 'createadmin'])->name('createadminreview');
    Route::get('admin/review/sort', [App\Http\Controllers\ReviewController::class, 'sort'])->name('review_sort');
    Route::post('admin/review/sort', [App\Http\Controllers\ReviewController::class, 'Managesort'])->name('submite_sort');
    Route::post('admin/review/reviewstore', [App\Http\Controllers\ReviewController::class, 'submit'])->name('admin.review.store');
    Route::get('admin/review/edit/{id}', [App\Http\Controllers\ReviewController::class, 'edit'])->name('admin.review.edit');
    Route::post('admin/review/update/{id}', [App\Http\Controllers\ReviewController::class, 'update'])->name('admin.review.update');
    Route::delete('admin/review/destroy/{id}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('admin.review.destroy');



    // Email Settings
    Route::get('admin/email/index', [App\Http\Controllers\Admin\EmailSettingController::class, 'index'])->name("admin.email.index");
    Route::get('admin/email/edit/{id}', [App\Http\Controllers\Admin\EmailSettingController::class, 'edit'])->name('admin.email_templates.edit');
    Route::put('admin/email/update/{id}', [App\Http\Controllers\Admin\EmailSettingController::class, 'update'])->name('admin.email.update');


    // client Report
    Route::get('/admin/reports/clients/index', [App\Http\Controllers\Admin\ReportsController::class, 'clientIndex']);



    // team
    Route::prefix('admin/team')->group(function () {
        Route::get('/index', [App\Http\Controllers\Admin\TeamController::class, 'index'])->name('team.index'); // Show All
        Route::get('/create', [App\Http\Controllers\Admin\TeamController::class, 'create'])->name('team.create'); // Show Create Form
        Route::post('/store', [App\Http\Controllers\Admin\TeamController::class, 'store'])->name('team.store'); // Store Data
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\TeamController::class, 'edit'])->name('team.edit'); // Show Edit Form
        Route::post('/update/{id}', [App\Http\Controllers\Admin\TeamController::class, 'update'])->name('team.update'); // Update Data
        Route::delete('/delete/{id}', [App\Http\Controllers\Admin\TeamController::class, 'destroy'])->name('team.destroy'); // Delete Data
    });
    // Client reports
    Route::get('admin/report/index', [App\Http\Controllers\Admin\ClientReportsController::class, 'index'])
    ->name('admin.report.index');
    Route::get('admin/report/index', [App\Http\Controllers\Admin\ClientReportsController::class, 'index'])->name('admin.report.show');
    Route::get('admin/report/index', [App\Http\Controllers\Admin\ClientReportsController::class, 'index'])->name('admin.report.destroy');


    Route::prefix('admin/faq')->group(function () {
        Route::get('/index', [App\Http\Controllers\Admin\FaqTestController::class, 'index'])->name('faq.index');
        Route::get('/create', [App\Http\Controllers\Admin\FaqTestController::class, 'create'])->name('faq.create');
        Route::post('/store', [App\Http\Controllers\Admin\FaqTestController::class, 'store'])->name('faq.store');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\FaqTestController::class, 'edit'])->name('faq.edit');
        Route::POST('/update/{id}', [App\Http\Controllers\Admin\FaqTestController::class, 'update'])->name('faq.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\Admin\FaqTestController::class, 'destroy'])->name('faq.delete');

    });
    Route::prefix('admin/blog')->group(function () {
        Route::get('/index', [App\Http\Controllers\Admin\BlogAdminController::class, 'index'])->name('blog.index.admin');
        Route::get('/create', [App\Http\Controllers\Admin\BlogAdminController::class, 'create'])->name('blog.create');
        Route::post('/store', [App\Http\Controllers\Admin\BlogAdminController::class, 'store'])->name('blog.store');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\BlogAdminController::class, 'edit'])->name('blog.edit');
        Route::POST('/update/{id}', [App\Http\Controllers\Admin\BlogAdminController::class, 'update'])->name('blog.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\Admin\BlogAdminController::class, 'destroy'])->name('blog.delete');

    });
    Route::prefix('admin/artical')->group(function (): void {
        Route::get('/index', [App\Http\Controllers\Admin\ArticalController::class, 'index'])->name('artical.index');
        Route::get('/create', [App\Http\Controllers\Admin\ArticalController::class, 'create'])->name('artical.create');
        Route::post('/store', [App\Http\Controllers\Admin\ArticalController::class, 'store'])->name('artical.store');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\ArticalController::class, 'edit'])->name('artical.edit');
        Route::POST('/update/{id}', [App\Http\Controllers\Admin\ArticalController::class, 'update'])->name('artical.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\Admin\ArticalController::class, 'destroy'])->name('artical.delete');

    });



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
        Route::post('/customer/admin/updateprofile', [App\Http\Controllers\CustomerController::class, 'updateadminprofile'])->name('profile.update.admin');
        Route::post('/customer/admin/changepassword', [App\Http\Controllers\CustomerController::class, 'changePasswordadmin'])->name('customer.changePassword.admin');




});

// Auth::routes();

Route::fallback(function () {
    return redirect('/');
});
