<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use Illuminate\Support\Facades\View;

class ContactUsMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // جلب أول سجل من جدول contact_us
        $firstcontactUs = ContactUs::first();

        // مشاركة البيانات مع جميع الفيوهات
        View::share('firstcontactUs', $firstcontactUs);

        return $next($request);
    }
}
