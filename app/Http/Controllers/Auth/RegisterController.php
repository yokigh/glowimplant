<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountVerificationMail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Country;

class RegisterController extends Controller
{
    public function showRegistrationForm($lang)
    {
        $countries = Country::all();
        return view('auth.register', compact('countries'));
    }

    public function register($lang, Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'username' => 'required|string|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'datebirthday' => 'required|date',
        'job' => 'nullable|string|max:255',
        'phone' => 'required|string|max:15',
        'country_id' => 'required|exists:countries,id',
        'state' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'address1' => 'nullable|string|max:255',
        'address2' => 'nullable|string|max:255',
        'zipcode' => 'nullable|string|max:10',
        'role' => 'required|in:user,admin,agency',
    ], [
        'name.required' => __('valdition.name_required'),
        'email.required' => __('valdition.email_required'),
        'email.email' => __('valdition.email_invalid'),
        'email.unique' => __('valdition.email_unique'),
        'password.required' => __('valdition.password_required'),
        'password.min' => __('valdition.password_min', ['min' => 6]),
        'password.confirmed' => __('valdition.password_confirmed'),
        'username.required' => __('valdition.username_required'),
        'username.unique' => __('valdition.username_unique'),
        'phone.required' => __('valdition.phone_required'),
        'country_id.required' => __('valdition.country_required'),
        'role.required' => __('valdition.role_required'),
    ]);

    $verificationToken = Str::random(64);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'username' => $request->username,
        'password' => bcrypt($request->password),
        'datebirthday' => $request->datebirthday,
        'job' => $request->job,
        'phone' => $request->phone,
        'country_id' => $request->country_id,
        'state' => $request->state,
        'city' => $request->city,
        'address1' => $request->address1,
        'address2' => $request->address2,
        'zipcode' => $request->zipcode,
        'role' => $request->role,
        'email_verification_token' => $verificationToken,
    ]);

    $verificationUrl = url(app()->getLocale() . '/verify-email/' . $verificationToken);

    // إرسال البريد الإلكتروني
    Mail::to($user->email)->send(new AccountVerificationMail($user, $verificationUrl));

    return redirect()->route('login', ['lang' => app()->getLocale()])
        ->with('success', __('valdition.registration_success'));
}

}
