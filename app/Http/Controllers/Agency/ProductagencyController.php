<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Subcategory;
use App\Models\Country;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductUpdate;

class ProductagencyController extends Controller
{
    public function index($lang)
    {
        $userCountry = Auth::user()->country;

        $products = Product::with('subcategory', 'prices.country')->get();

// جلب البلد فقط الذي ينتمي إليه المستخدم
$countries = Country::find($userCountry);
return view('agency.product.index', compact('products', 'countries'));

    }

    public function edit($lang, Product $product)
    {
        $userCountry = Auth::user()->country;

        $subcategories = Subcategory::all();
        $countries = Country::find($userCountry);
    
        return view('agency.product.edit', compact('product', 'subcategories', 'countries'));
    }
    public function update($lang, Request $request, Product $product)
    {
        $request->validate([
            'ref' => 'required|string|unique:products,ref,' . $product->id,
            'diameter' => 'required|numeric',
            'height' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'np' => 'nullable|numeric',
            'nr' => 'nullable|numeric',
            'subcategory_id' => 'required|exists:subcategories,id',
            'prices.*.country_id' => 'required|exists:countries,id',
            'prices.*.price' => 'required|numeric|min:0',
        ]);
    
        // تحديث الصورة الرئيسية
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/product/image');
            $img->move($path, $name);
            $product->image = "storegs/product/image/" . $name;
        }
    
        // تحديث الصور المتعددة
        $imagesPaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $ext = $image->getClientOriginalExtension();
                $name = time() . '_' . uniqid() . '.' . $ext;
                $path = public_path('storegs/product/image');
                $image->move($path, $name);
                $imagesPaths[] = "storegs/product/image/" . $name;
            }
        }
        // تخزين السعر القديم لكل دولة
        $oldPrices = [];
        foreach ($product->prices as $productPrice) {
            $oldPrices[$productPrice->country_id] = $productPrice->price;
        }
    
        // تحديث بيانات المنتج
        $product->update([
            'ref' => $request->ref,
            'diameter' => $request->diameter,
            'height' => $request->height,
            'np' => $request->np,
            'nr' => $request->nr,
            'subcategory_id' => $request->subcategory_id,
            'description_en' => $request->description_en,
            'description_de' => $request->description_de,
            'description_fr' => $request->description_fr,
            'description_es' => $request->description_es,
            'description_ar' => $request->description_ar,
        ]);
    
        // تحديث الأسعار لكل دولة
        foreach ($request->prices as $price) {
            $oldPrice = $oldPrices[$price['country_id']] ?? null;

            // إذا كان السعر القديم موجودًا وكان السعر قد تغير
            if ($oldPrice !== null && $oldPrice !== $price['price']) {
                // تخزين التحديث في جدول product_updates
                ProductUpdate::create([
                    'user_id' => auth()->id(), // معرف المستخدم الذي قام بالتعديل
                    'product_id' => $product->id, // معرف المنتج
                    'country_id' => $price['country_id'], // معرف الدولة
                    'old_price' => $oldPrice, // السعر القديم
                    'new_price' => $price['price'], // السعر الجديد
                ]);
            }
        
    
            ProductPrice::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'country_id' => $price['country_id']
                ],
                [
                    'price' => $price['price']
                ]
            );
        }
    
        return redirect()->route('product.agency', ['lang' => app()->getLocale()])
            ->with('success', 'تم تحديث المنتج بنجاح.');
    }
    
    public function show($lang, Product $product)
{
    
    // جلب جميع الدول من قاعدة البيانات
    $userCountry = Auth::user()->country;

    $countries = Country::find($userCountry);

    // استدعاء API لجلب أسعار الصرف مقابل الدولار
    $apiResponse = Http::get('https://open.er-api.com/v6/latest/USD?apikey=8ce9c06326641d234d76eab5');

    // التحقق من نجاح الاستجابة
    if ($apiResponse->successful()) {
        $exchangeRates = $apiResponse->json();

        // الحصول على سعر الصرف من USD إلى EUR
        $usdToEurRate = $exchangeRates['rates']['EUR'] ?? null;

        // إنشاء مصفوفة لتخزين فرق العملة لكل دولة
        $currencyDifferences = [];

        foreach ($countries as $country) {
            $currencyCode = strtoupper($country->currency); // تحويل رمز العملة إلى أحرف كبيرة

            // التحقق مما إذا كان يوجد سعر صرف لهذه العملة
            if (isset($exchangeRates['rates'][$currencyCode]) && $usdToEurRate) {
                // حساب فرق العملة بين العملة المحلية واليورو
                $exchangeRateToEur = $exchangeRates['rates'][$currencyCode] / $usdToEurRate;
                $currencyDifferences[$currencyCode] = $exchangeRateToEur;
            } else {
                $currencyDifferences[$currencyCode] = null; // إذا لم يكن هناك سعر صرف متاح
            }
        }
    } else {
        $currencyDifferences = []; // إذا فشل الاتصال بالـ API
    }

    return view('agency.product.show', compact('product', 'countries', 'currencyDifferences'));
}
}
