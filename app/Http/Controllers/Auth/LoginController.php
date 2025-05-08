<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginSession;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login($lang, Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // التحقق مما إذا كان الحساب مفعلاً
            if (!$user->email_verified_at) {
                Auth::logout();
                return redirect()->back()->withErrors(['email' => __('validation.login.email_not_verified')]);
            }

            // تسجيل نشاط الدخول
            LoginSession::create([
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ]);

            // التحقق من دور المستخدم وتوجيهه إلى الصفحة المناسبة
            if ($user->role === 'admin') {
                return redirect()->route('dashboard.admins', ['lang' => $lang]);
            }elseif($user->role === 'user'){
                return redirect()->route('home.page', ['lang' => $lang]);
            }elseif($user->role === 'agency'){

            return redirect()->route('dash.agency', ['lang' => $lang]);
            }
        }

        return redirect()->back()->withErrors(['email' => __('validation.login.invalid_credentials')]);
    }


    public function logout($lang,Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // تسجيل نشاط الخروج
            $session = LoginSession::where('user_id', $user->id)->latest()->first();
            if ($session) {
                $session->update([
                    'logout_at' => now(),
                ]);
            } else {
                return redirect()->route('login', ['lang' => app()->getLocale()])
                    ->withErrors(['logout' => __('valdition.logout.session_not_found')]);
            }

            Auth::logout();
        }

        return redirect()->route('login', ['lang' => app()->getLocale()]);
    }
}
