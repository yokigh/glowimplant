<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Cart;
class ProccerrpaymentController extends Controller
{
    public function index($lang){
        $payments = Payment::all();
        return view('admin.payment.index',compact('payments'));
    }
    public function show($lang,Payment $payment){
        $cardIts = json_decode($payment->cart_ids);

// استرجاع الـ cards التي تحتوي على cart_ids
$carts = Cart::whereIn('id', $cardIts)->get();

        return view('admin.payment.show',compact('payment','carts'));
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
}
