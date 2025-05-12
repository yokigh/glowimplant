<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\Product;
use App\Models\Payment;
use App\Models\AboutUs;
use App\Models\Event;
use App\Models\Country;
use App\Models\ContactUs;
use App\Models\ProstheticProduct;

class StatckController extends Controller
{
    public function index($lang)
    {
        $sliders = Slider::all();
        $latestAbout = AboutUs::latest()->first();

        $sub_categries = SubCategory::all();
        return view('user.home.index', compact('sliders', 'sub_categries', 'latestAbout'));
    }
    public function about($lang)
    {
        $latestAbout = AboutUs::latest()->first();
        $latestEvents = Event::latest()->take(3)->get();
        $categoryCount = Category::count();
        $subCategoryCount = SubCategory::count();
        $paymentCount = Payment::count();
        $productCount = Product::count();

        return view('user.about.index', compact('latestAbout', 'latestEvents', 'categoryCount', 'subCategoryCount', 'paymentCount', 'productCount'));
    }
    public function showcategory($lang, Category $category)
    {
        $subcategories = $category->subcategories;
        return view('user.category.index', compact('category', 'subcategories'));
    }
    public function showsubcategory($lang, SubCategory $subcategory)
    {
        $category = $subcategory->category; // جلب ال Category المرتبطة بال SubCategory
        $subcategories = $category->subcategories; // جلب كل Subcategories التابعة لنفس ال Category

        return view('user.subcategory.index', compact('subcategory', 'category', 'subcategories'));
    }
    public function showsubcategoryproduct($lang, SubCategory $subcategory)
    {
        $products = $subcategory->products; // جلب جميع المنتجات المرتبطة بالـ SubCategory
        $countries = Country::all();
        return view('user.product.product', compact('subcategory', 'products', 'countries'));
    }
    public function products($lang)
    {
        $subcategories = SubCategory::all(); // جلب جميع الفئات الفرعية
        $products = Product::all(); // جلب جميع المنتجات
        $countries = Country::all();

        return view('user.product.index', compact('subcategories', 'countries', 'products', 'lang'));
    }
    public function showcategoryproduct($lang, Category $category)
    {
        // تحميل الـ Subcategories والـ Products المرتبطة بها
        $subcategories = $category->subcategories()->with('products')->get();
        $countries = Country::all();

        return view('user.product.category', compact('category', 'subcategories', 'countries'));
    }
    public function showproduct($lang, Product $product)
    {
        $prosthetic_products = ProstheticProduct::all();
        $countries = Country::all();
        $products = Product::all();
        return view('user.product.show', compact('product', 'products', 'countries','prosthetic_products','lang'));
    }
    public function event($lang)
    {
        $events = Event::all();
        return view('user.event.index', compact('events'));
    }
    public function contact($lang)
    {
        $contacts = ContactUs::all();
        return view('user.contact.index', compact('contacts'));
    }
    public function search($lang, Request $request)
    {
        $query = $request->input('query');

        // البحث عن المنتجات باستخدام `ref`
        $products = Product::where('ref', 'LIKE', "%{$query}%")
            ->take(10) // تحديد عدد النتائج
            ->get();

        return response()->json($products);
    }
    public function contactshow($lang, ContactUs $contac)
    {
        $contacts = ContactUs::all();
        return view('user.contact.show', compact('contacts', 'contac'));
    }
    public function payment($lang)
    {

        $userId = Auth::id();
        $payments = Payment::all();
    }
}
