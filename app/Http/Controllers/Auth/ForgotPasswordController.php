<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm($lang)
    {
        return view('auth.forgot-password');
    }
    public function sendResetLinkEmail($lang, Request $request)
{
    $request->validate(['email' => 'required|email|exists:users,email']);

    $status = Password::sendResetLink($request->only('email'), function ($user, $token) use ($lang) {
        $resetUrl = url("$lang/reset-password/$token");

        // إرسال البريد الإلكتروني باستخدام البريد المخصص
        Mail::to($user->email)->send(new ResetPasswordMail($resetUrl, $lang));
    });

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['success' => __('valdition.password_reset_link_sent')])
        : back()->withErrors(['email' => __('valdition.password_reset_failed')]);
}


        }
