<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashagancyController extends Controller
{
    public function index($lang){
        $payments = Payment::whereHas('user', function($query) {
            $query->where('country_id', Auth::user()->country_id);
        })->get();
        
        return view('agency.home.index',compact('payments'));
    }
    public function show($lang,Payment $payment){
        $cardIts = json_decode($payment->cart_ids);

// استرجاع الـ cards التي تحتوي على cart_ids
$carts = Cart::whereIn('id', $cardIts)->get();

        return view('agency.home.show',compact('payment','carts'));
    }
    public function addnotes($lang,Request $request){
        $request->validate([
            'notes' => 'required|string',
            'pay_id' => 'required|exists:payments,id'
        ]);
        
        $payment = Payment::findOrFail($request->pay_id);
        $cartIds = json_decode($payment->cart_ids);
        
        // تحديث جميع السجلات في `carts`
        Cart::whereIn('id', $cartIds)->update([
            'notes' => $request->notes,
            'status_order' => true, // يمكنك تغيير القيمة حسب المطلوب
        ]);
        return redirect()->back()->with('success', 'تمت توصيل الطلب و إضافة الملاحظات');
    }
    public function onlyuser($lang)
    {
        // الحصول على المستخدم الحالي
        $currentUser = Auth::user();
        
        // جلب المستخدمين الذين لديهم نفس country_id مثل المستخدم الحالي
        $users = User::where('role', 'user')->where('country_id', $currentUser->country_id)->get();
        
        $currentYear = Carbon::now()->year;
    
        // جلب عدد المستخدمين من نوع 'user' لكل شهر في هذا العام لنفس الـ country_id
        $userCounts = User::where('role', 'user')
            ->where('country_id', $currentUser->country_id)
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
    
        // حساب عدد المستخدمين حسب الأدوار في نفس الـ country_id
        $userRolesCount = User::where('country_id', $currentUser->country_id)
            ->select('role', DB::raw('COUNT(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role');
    
        // حساب عدد المستخدمين الذين لديهم دور 'user' لكل شهر في العام الحالي لنفس الـ country_id
        $usersPerMonth = User::where('role', 'user')
            ->where('country_id', $currentUser->country_id)
            ->whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');
    
        return view('agency.user.index', compact('users', 'monthlyData', 'userRolesCount', 'usersPerMonth'));
    }
    public function showuser($lang, User $user)
    {
        $activities = $user->loginSessions; 
        return view('agency.user.show', compact('user','activities'));
    }
    
    public function indexprofile($lang)
{
    $user = auth()->user(); // الحصول على المستخدم المسجل دخول
    $countries = Country::all(); // جلب قائمة الدول من قاعدة البيانات

    return view('agency.profile.index', compact('user', 'countries'));
}
public function updateprofile($lang,Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6|confirmed',
        'phone' => 'nullable|string|max:20',
        'datebirthday' => 'nullable|date',
        'country_id' => 'nullable|exists:countries,id',
        'state' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'address1' => 'nullable|string|max:255',
        'address2' => 'nullable|string|max:255',
    ]);

    $user->update($request->except('password'));

    if ($request->filled('password')) {
        $user->update(['password' => Hash::make($request->password)]);
    }

    return redirect()->route('agancy.profile', ['lang' => app()->getLocale()])->with('success', 'تم تحديث الملف الشخصي بنجاح!');
}

    
}
