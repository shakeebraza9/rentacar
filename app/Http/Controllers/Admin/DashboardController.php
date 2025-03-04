<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filemanager;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;




class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */




    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function dashboard()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 1)->sum('amount');
        $totalUsers = User::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalProducts = Product::count(); // Fetch total products

        // Sales Data for Bar Chart (last 6 months)
        $monthlySalesLabels = collect(range(1, 6))->map(fn($m) => now()->subMonths($m)->format('M Y'))->reverse()->values();
        $monthlySalesArray = $monthlySalesLabels->toArray();
        $monthlySalesData = collect($monthlySalesLabels)->map(fn($m) =>
            Order::whereMonth('created_at', now()->subMonths(array_search($m, $monthlySalesArray)))->sum('amount')
        );

        // Order Status Data for Pie Chart
        $orderStatusData = [
            Order::where('status', 'pending')->count(),
            Order::where('status', 'apporve')->count(),
            Order::where('status', 'completed')->count(),
            Order::where('status', 'cancelled')->count()
        ];

        return view('admin.dashboard', compact(
            'totalOrders', 'totalRevenue', 'totalUsers', 'pendingOrders', 'totalProducts',
            'monthlySalesLabels', 'monthlySalesData', 'orderStatusData'
        ));
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function changepassword()
    {

        return view('admin.changepassword');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function changepassword_submit(Request $request)
    {

        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($id),
            ],
            'password' => 'nullable|string|min:8|max:255',
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->created_by = Auth::user()->id;
        $user->created_at = Carbon::now();

        if($request->password){
          $user->password =  Hash::make($request->password);
        }
        $user->save();
        return back()->with('success','Profile Updated');

    }

    /**
     * Create a new controller instance.
     * @return void
     */
    public function status(Request $request)
    {
        DB::update('UPDATE '.$request->table.' SET '.$request->column.' = ? WHERE id = ?', [$request->value,Crypt::decryptString($request->id)]);
    }

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function update_file_url(Request $request)
    {
        $files = Filemanager::all();
        foreach ($files as $key => $file) {
            $file->preview = asset($file->path);
            $file->save();
        }

    }









}