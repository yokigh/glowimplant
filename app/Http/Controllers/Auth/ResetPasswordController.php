<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule; 

class ResetPasswordController extends Controller
{
    public function showResetForm($lang,$token)
    {
        return view('auth.reset-password', ['token' => $token, 'lang' => $lang]);
    }
    public function reset($lang, Request $request)
    {
        // التحقق من صحة البيانات باستخدام الرسائل المخصصة من ملف validation.php
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            // إضافة الرسائل المخصصة في حالة الحاجة
            'token.required' => __('valdition.newrequired'),
            'email.required' => __('valdition.newrequired'),
            'email.email' => __('valdition.email'),
            'password.required' => __('valdition.newpassword.newrequired'),
            'password.confirmed' => __('valdition.newpassword.confirmed'),
            'password.password' => __('valdition.newpassword.newpassword'),
        ]);
    
        // محاولة إعادة تعيين كلمة المرور
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );
    
        // إرسال الرسائل المناسبة بعد إعادة تعيين كلمة المرور
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login', ['lang' => app()->getLocale()])->with('status', __('valdition.newpassword_reset'))
            : back()->withErrors(['email' => [__('valdition.newpassword_reset_failed')]]);
    }
    
}
