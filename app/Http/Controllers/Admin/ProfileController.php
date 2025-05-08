<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index($lang)
{
    $user = auth()->user(); // الحصول على المستخدم المسجل دخول
    $countries = Country::all(); // جلب قائمة الدول من قاعدة البيانات

    return view('admin.profile.index', compact('user', 'countries'));
}
public function update($lang,Request $request)
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

    return redirect()->route('user.profile', ['lang' => app()->getLocale()])->with('success', 'تم تحديث الملف الشخصي بنجاح!');
}

}
