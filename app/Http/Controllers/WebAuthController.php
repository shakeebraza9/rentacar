<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Illuminate\Auth\Events\Registered;
class WebAuthController extends Controller
{
    public function login()
    {

        if (Auth::check()){
            $role_id = Auth::user()->role_id;
            if ($role_id == 0) {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/dashboard');
            }
        }
        // $users = User::all();
        // return view('theme.login',compact('users'));
        return view('theme.login');
    }
    public function register()
    {

        if (Auth::check()){
             return redirect('/dashboard');
        }

        return view('theme.register');
    }



    public function createAccount(Request $request)
    {
        // Extend Validator for case-insensitive password confirmation
        Validator::extend('case_insensitive_confirmation', function ($attribute, $value, $parameters, $validator) {
            return strtolower($value) === strtolower($validator->getData()[$parameters[0]]);
        });

        // Validate all form fields
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone_number' => 'required|regex:/^[0-9- ]+$/|max:20',
            'gender' => 'required|in:M,F',
            'date_of_birth' => 'nullable|date|before:today',
            'country' => 'required',
            'password' => 'required|string|min:8|max:255|case_insensitive_confirmation:password_confirmation',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'country' => $request->country,
            'password' => Hash::make($request->password),
            'role_id' => 0, // Assuming 'customer' role has id 0
            'created_by' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Generate a unique verification token
        $verificationToken = Str::random(60);

        // Save the verification token to the user's record
        $user->verification_token = $verificationToken;
        $user->save();

        // Trigger the Registered event (Optional, you may remove if not required)
        event(new Registered($user));

        // Get the email template from the database (ID = 5)
        $template = DB::table('email_templates')->where('id', 5)->first();

        if ($template) {
            // Replace placeholders in the email body
            $emailBody = str_replace(
                ['{COMPANY_NAME}', '{CUSTOMER_NAME}', '{USERNAME}', '{EMAIL}', '{VERIFICATION_LINK}'],
                ['Your Company Name', $user->name, $user->name, $user->email, route('verification.verify', ['token' => $verificationToken])], // Adding the token in the verification URL
                $template->body
            );

            // Send email using Mail::html() for HTML content
            Mail::html($emailBody, function ($message) use ($user, $template) {
                $message->to($user->email)
                    ->subject($template->subject);
            });
        }

        return redirect('/login')->with('success', 'Account created successfully. You can now login.');
    }


    public function webLogin(Request $request)
    {


        // Validate login input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Find user by email
        $user = User::where('email', $request->email)->first();

        // If user doesn't exist, return error
        if (!$user) {
            return back()->withErrors([
                'email' => ['Incorrect email or password']
            ])->withInput();
        }

        // Check if the user is a valid customer (role_id != 0)
        // if ($user->role_id == 0) {
        //     return back()->withErrors([
        //         'email' => ['Enter a valid user email!']
        //     ])->withInput();
        // }

        // Verify password and attempt login
        if (Hash::check($request->password, $user->password)) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Redirect based on user role
                return redirect($user->role_id == 0 ? '/' : '/');
            }
        }

        // Incorrect password error
        return back()->withErrors([
            'password' => ['Incorrect password']
        ])->withInput();
    }

    public function forgotPassword()
    {
        return view('theme.forgot_password');
    }

    public function dashboard()
    {
        return redirect(route('weblogin'));
    }

    public function weblogout()
    {
        Auth::logout();
        return redirect(route('weblogin'));
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Check if the email exists
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'We couldn’t find a user with that email.');
        }

        // Generate a reset token
        $token = Str::random(60);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        // Send email with reset link
        $resetLink = route('password.reset', ['token' => $token, 'email' => $request->email]);

        Mail::send('emails.forgot_password', ['resetLink' => $resetLink], function ($message) use ($request) {
            $message->to($request->email)->subject('Reset Your Password');
        });

        return back()->with('status', 'We have emailed your password reset link!');
    }

    // ✅ Show Reset Password Form
    public function showResetForm($token)
    {
        return view('theme.reset_password', ['token' => $token]);
    }

    // ✅ Handle Password Reset
    public function resetPassword(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required',
        ]);

        $resetData = DB::table('password_resets')->where('email', $request->email)->first();
        if (!$resetData || !Hash::check($request->token, $resetData->token)) {
            return back()->with('error', 'Invalid or expired reset token.');
        }


        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('weblogin')->with('success', 'Your password has been reset successfully.');
    }

}
