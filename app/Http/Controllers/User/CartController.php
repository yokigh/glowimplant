<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;

class CartController extends Controller
{public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'يجب تسجيل الدخول أولاً!']);
        }
    
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
    
        $userId = Auth::id();
        $productId = $request->product_id;
        $quantity = $request->quantity;
    
        // البحث عن المنتج في السلة للمستخدم
        $cartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $productId)
                        ->where('status_pay', false)
                        ->first();
    
        if ($cartItem) {
            // إذا كان `status_pay` false، يتم تحديث الكمية
            $cartItem->quantity += $quantity;
            $cartItem->save();
            return response()->json(['status' => 'success', 'message' => 'تم تحديث الكمية في السلة!']);
        } else {
            // إدراج المنتج في صف جديد حتى لو كان مضافًا مسبقًا مع `status_pay = true`
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'status_pay' => false
            ]);
    
            return response()->json(['status' => 'success', 'message' => 'تمت إضافة المنتج إلى السلة في صف جديد!']);
        }
    }
    
    public function getcat($lang)
{
    $user = Auth::user();

    // جلب سلة التسوق الخاصة بالمستخدم مع تفاصيل المنتج
    $cartItems = Cart::where('user_id', $user->id)
                ->where('status_pay', false) // ✅ فقط العناصر غير المدفوعة
                ->with('product') // ✅ جلب تفاصيل المنتج المرتبط
                ->get();


                    $countries = Country::all();

    return view('user.cart.index', compact('cartItems','countries'));
}
public function remove($lang,$id)
{
    $cartItem = Cart::findOrFail($id);
    $cartItem->delete();
    return redirect()->back()->with('success', 'تمت إزالة المنتج من السلة بنجاح.');
}
public function updateQuantity($lang,Request $request)
{
    $request->validate([
        'id' => 'required|exists:cart,id',
        'quantity' => 'required|integer|min:1'
    ]);

    $cartItem = \App\Models\Cart::find($request->id);
    $cartItem->quantity = $request->quantity;
    $cartItem->save();

    // استرجاع السعر بناءً على الدولة
    $userCountryId = auth()->user()->country_id ?? null;
    $selectedCountry = \App\Models\Country::where('id', $userCountryId)->first() ?? \App\Models\Country::where('name', 'Germany')->first();
    $price = $cartItem->product->prices->where('country_id', $selectedCountry->id)->first();

    return response()->json([
        'success' => true,
        'newTotal' => $price ? $price->price * $cartItem->quantity : 'N/A'
    ]);
}


}
