<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailNewsletter;

class EmailNewsletterController extends Controller
{
    public function store($lang,Request $request)
    {
            // تحقق من صحة البيانات
            $request->validate([
                'email' => 'required|email|unique:email_newsletters,email',
            ]);
    
            try {
                // حفظ الإيميل في قاعدة البيانات
                EmailNewsletter::create([
                    'email' => $request->email,
                ]);
    
                return back()->with('success', __('messages.Email subscribed successfully!'));
            } catch (\Exception $e) {
                return back()->with('error', __('messages.Failed to subscribe. Please try again.'));
            }
    }
}
