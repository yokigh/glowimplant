<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CountryController extends Controller
{
    public function index($lang)
    {    $countries = Country::all();

        // استدعاء API لجلب أسعار الصرف
        $apiResponse = Http::get('https://open.er-api.com/v6/latest/USD?apikey=8ce9c06326641d234d76eab5');
    
        // التحقق من نجاح الاستجابة
        if ($apiResponse->successful()) {
            $exchangeRates = $apiResponse->json();
    
            // الحصول على سعر الصرف من USD إلى EUR
            $usdToEurRate = $exchangeRates['rates']['EUR'] ?? null;
    
            // إنشاء مصفوفة لتخزين أسعار الصرف لكل عملة
            $currencyRates = [];
    
            foreach ($countries as $country) {
                $currencyCode = strtoupper($country->currency); // تحويل رمز العملة إلى أحرف كبيرة
    
                // التحقق مما إذا كان يوجد سعر صرف لهذه العملة
                if (isset($exchangeRates['rates'][$currencyCode]) && $usdToEurRate) {
                    // تحويل العملة إلى اليورو
                    $currencyRates[$currencyCode] = $exchangeRates['rates'][$currencyCode] / $usdToEurRate;
                } else {
                    $currencyRates[$currencyCode] = null; // إذا لم يكن هناك سعر صرف متاح
                }
            }
        } else {
            $currencyRates = []; // إذا فشل الاتصال بالـ API
        }
    
        return view('admin.countries.index', compact('countries', 'currencyRates'));
    
    }

    public function create($lang)
    {
        return view('admin.countries.create');
    }
    public function store($lang, Request $request)
    {
        // التحقق من المدخلات
        $request->validate([
            'name' => 'required',
            'currency' => 'nullable|string',  // تأكد من أن العملة تحتوي على قيمة نصية
        ]);
    
        // إنشاء السجل الجديد مع تحديد الحقول المحددة
        Country::create([
            'name' => $request->name,
            'currency' => $request->currency ?: 'EUR', // تعيين EUR كقيمة افتراضية إذا كانت العملة فارغة
        ]);
    
        return redirect()->route('countries.index', ['lang' => app()->getLocale()])
                         ->with('success', 'Country created successfully');
    }
    
    public function edit($lang,Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    public function update($lang,Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required',
            'currency' => 'nullable',
        ]);

        $country->update($request->all());

        return redirect()->route('countries.index', ['lang' => app()->getLocale()])->with('success', 'Country updated successfully');
    }

    public function destroy($lang,Country $country)
    {
        $country->delete();

        return redirect()->route('countries.index', ['lang' => app()->getLocale()])->with('success', 'Country deleted successfully');
    }
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
