<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgencyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // التحقق مما إذا كان المستخدم مسجلاً الدخول وله دور 'agency'
        if (Auth::check() && Auth::user()->role === 'agency') {
            return $next($request);  // إذا كان الدور agency، اسمح بمرور الطلب
        }

        // إذا لم يكن المستخدم مسجلاً دخول أو ليس لديه دور agency، إرجاع استجابة ممنوعة
        return abort(403, 'Unauthorized');
    }
}
