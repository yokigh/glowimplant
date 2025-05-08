<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Subcategory;
use App\Models\Country;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    /**
     * عرض جميع المنتجات
     */
    public function index($lang)
    {
        $products = Product::with('subcategory', 'prices.country')->get();
        $countries = Country::all();
        return view('admin.products.index', compact('products', 'countries'));

    }

    /**
     * عرض صفحة إنشاء منتج جديد
     */
    public function create($lang)
    {
        $subcategories = Subcategory::all();
        $countries = Country::all();
        return view('admin.products.create', compact('subcategories', 'countries'));
    }

    /**
     * تخزين منتج جديد في قاعدة البيانات
     */
    public function store($lang,Request $request)
    {
        $request->validate([
            'ref' => 'required|string|unique:products,ref',
            'diameter' => 'required|numeric',
            'height' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'np' => 'nullable|numeric',
            'nr' => 'nullable|numeric',
            'subcategory_id' => 'required|exists:subcategories,id',
            'prices.*.country_id' => 'required|exists:countries,id',
            'prices.*.price' => 'required|numeric|min:0',
        ]);

        // رفع الصورة إن وجدت

        // حفظ الصورة الرئيسية
        $imagePath = null;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/product/image');
            $img->move($path, $name);
            $imagePath = "storegs/product/image/".$name;
        }
        // حفظ الصور المتعددة
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
        // إنشاء المنتج
        $product = Product::create([
            'ref' => $request->ref,
            'diameter' => $request->diameter,
            'height' => $request->height,
            'image' => $imagePath,
            'np' => $request->np,
            'nr' => $request->nr,
            'subcategory_id' => $request->subcategory_id,
            'description_en' => $request->description_en,
            'description_de' => $request->description_de,
            'description_fr' => $request->description_fr,
            'description_es' => $request->description_es,
            'description_ar' => $request->description_ar,
        ]);

        // تخزين الأسعار لكل دولة
        foreach ($request->prices as $price) {
            ProductPrice::create([
                'product_id' => $product->id,
                'country_id' => $price['country_id'],
                'price' => $price['price'],
            ]);
        }

        return redirect()->route('products.index', ['lang' => app()->getLocale()])->with('success', 'تم إنشاء المنتج بنجاح.');
    }

    /**
     * عرض تفاصيل المنتج
     */
    public function show($lang, Product $product)
{
    // جلب جميع الدول من قاعدة البيانات
    $countries = Country::all();

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

    return view('admin.products.show', compact('product', 'countries', 'currencyDifferences'));
}

    public function edit($lang, Product $product)
    {
        $subcategories = Subcategory::all();
        $countries = Country::all();
    
        return view('admin.products.edit', compact('product', 'subcategories', 'countries'));
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
    
        return redirect()->route('products.index', ['lang' => app()->getLocale()])
            ->with('success', 'تم تحديث المنتج بنجاح.');
    }
    

    /**
     * حذف المنتج
     */
    public function destroy($lang,Product $product)
    {
        
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        if ($product->images) {
            foreach (json_decode($product->images) as $image) {
                if (file_exists(public_path($image))) {
                    unlink(public_path($image));
                }
            }
        }
        
        $product->delete();
        
        return redirect()->route('products.index', ['lang' => app()->getLocale()])->with('success', 'تم حذف المنتج بنجاح.');
    }
}
