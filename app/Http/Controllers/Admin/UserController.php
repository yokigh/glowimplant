<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\AccountVerificationMail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Password;
use App\Models\LoginSession;
use App\Models\Country;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
class UserController extends Controller
{
    
    public function index($lang){
        
        $users = User::all();
        $currentYear = Carbon::now()->year;

        // حساب عدد المستخدمين الذين لديهم بريد مؤكد وغير مؤكد
        $emailVerificationData = [
            'مؤكد' => User::whereNotNull('email_verified_at')->count(),
            'غير مؤكد' => User::whereNull('email_verified_at')->count()
        ];
    
        // حساب عدد المستخدمين الذين لديهم دور 'admin' لكل شهر في العام الحالي
        $userCounts = User::whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
    
        // تجهيز البيانات لكل الأشهر (حتى التي بدون تسجيلات)
        $monthlyData = array_fill(1, 12, 0);
        foreach ($userCounts as $month => $count) {
            $monthlyData[$month] = $count;
        }
    
        return view('admin.user.index',compact('users','monthlyData', 'emailVerificationData'));
    }
    public function virifay($lang, User $user)
    {
        // تحقق مما إذا كان المستخدم قد تم التحقق منه بالفعل
        if ($user->email_verified_at) {
            return back()->with('info', __('valdition.already_verified'));
        }
    
        // إنشاء رمز تحقق جديد
        $user->email_verification_token = Str::random(64);
        $user->save();
    
        // رابط التحقق الجديد
        $verificationUrl = url($lang . '/verify-email/' . $user->email_verification_token);
    
        // إرسال البريد الإلكتروني
        Mail::to($user->email)->send(new AccountVerificationMail($user, $verificationUrl));
    
        return back()->with('success', __('valdition.verification_email_resent'));
    }
    public function forgetpassword($lang, User $user)
    {
        // التحقق مما إذا كان المستخدم موجودًا
        if (!$user) {
            return back()->withErrors(['email' => __('valdition.user_not_found')]);
        }
    
        // إنشاء رمز إعادة تعيين جديد
        $token = Password::createToken($user);
        
        // توليد رابط إعادة تعيين كلمة المرور
        $resetUrl = url("$lang/reset-password/$token");
    
        // إرسال البريد الإلكتروني
        Mail::to($user->email)->send(new ResetPasswordMail($resetUrl, $lang));
    
        return back()->with(['success' => __('valdition.password_reset_link_sent')]);
    }

    public function show($lang, User $user)
    {
        $activities = $user->loginSessions; 
        return view('admin.user.show', compact('user','activities'));
    }
    public function destroy($lang, User $user)
    {
        $userName = $user->name;
        $user->delete();
    
        return redirect()->back()->with('success', "تم حذف المستخدم $userName بنجاح");
    }
    
    //user only 
    public function onlyuser($lang){
        $users = User::where('role', 'user')->get();
        $currentYear = Carbon::now()->year;

        // جلب عدد المستخدمين من نوع 'user' لكل شهر في هذا العام
        $userCounts = User::where('role', 'user')
            ->whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
    
        // تجهيز البيانات لكل الأشهر (حتى التي بدون تسجيلات)
        $monthlyData = array_fill(1, 12, 0);
        foreach ($userCounts as $month => $count) {
            $monthlyData[$month] = $count;
        }
        $currentYear = now()->year;

        // حساب عدد المستخدمين حسب الأدوار
        $userRolesCount = User::select('role', DB::raw('COUNT(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role');
    
        // حساب عدد المستخدمين الذين لديهم دور 'user' لكل شهر في العام الحالي
        $usersPerMonth = User::where('role', 'user')
            ->whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');
    
    
        return view('admin.user.useronly',compact('users','monthlyData','userRolesCount','usersPerMonth'));
    }
    public function createuseronly($lang){
        $countries = Country::all();
        return view('admin.user.createonlyuser' , compact('countries'));
    }
    //Agancy Only
    public function onlyagancy($lang){
        $users = User::where('role', 'agency')->get();
        $currentYear = Carbon::now()->year;

        // جلب عدد المستخدمين من نوع 'agency' لكل شهر في هذا العام
        $userCounts = User::where('role', 'agency')
            ->whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
    
        // تجهيز البيانات لكل الأشهر (حتى التي بدون تسجيلات)
        $monthlyData = array_fill(1, 12, 0);
        foreach ($userCounts as $month => $count) {
            $monthlyData[$month] = $count;
        }
        $currentYear = now()->year;

        // حساب عدد المستخدمين حسب الأدوار
        $userRolesCount = User::select('role', DB::raw('COUNT(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role');
    
        // حساب عدد المستخدمين الذين لديهم دور 'user' لكل شهر في العام الحالي
        $usersPerMonth = User::where('role', 'agency')
            ->whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');
    
        return view('admin.user.agancyonly',compact('users','monthlyData','userRolesCount','usersPerMonth'));
    }
    public function createagancyonly($lang){
        $countries = Country::all();
        return view('admin.user.createagancyonly',compact('countries'));
    }
    //Admin Only
    public function onlyadmin($lang){
        
        $users = User::where('role', 'admin')->get();
        $currentYear = Carbon::now()->year;

        // جلب عدد المستخدمين من نوع 'admin' لكل شهر في هذا العام
        $userCounts = User::where('role', 'admin')
            ->whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
    
        // تجهيز البيانات لكل الأشهر (حتى التي بدون تسجيلات)
        $monthlyData = array_fill(1, 12, 0);
        foreach ($userCounts as $month => $count) {
            $monthlyData[$month] = $count;
        }
        $currentYear = now()->year;

        // حساب عدد المستخدمين حسب الأدوار
        $userRolesCount = User::select('role', DB::raw('COUNT(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role');
    
        // حساب عدد المستخدمين الذين لديهم دور 'user' لكل شهر في العام الحالي
        $usersPerMonth = User::where('role', 'admin')
            ->whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');
        return view('admin.user.adminonly',compact('users','monthlyData','userRolesCount','usersPerMonth'));
    
    }
    public function createadminonly($lang){
        $countries = Country::all();

        return view('admin.user.createadmin',compact('countries'));
    }
    public function store($lang, Request $request)
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

        // إنشاء المستخدم
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

        // رابط التحقق من البريد الإلكتروني
        $verificationUrl = url(app()->getLocale() . '/verify-email/' . $verificationToken);

        // إرسال البريد الإلكتروني
        Mail::to($user->email)->send(new AccountVerificationMail($user, $verificationUrl));

        return back()->with('success', __('valdition.registration_success'));
    }

}
