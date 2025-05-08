<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Payment;
use App\Models\Cart;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Mail\PaymentSuccessMail;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function processPayment($lang, Request $request)
{
    // إعداد مفتاح Stripe
    Stripe::setApiKey(config('services.stripe.secret'));

    try {
        // طلب البيانات من API للتحويل بين العملات
        $response = Http::get('https://open.er-api.com/v6/latest/USD', [
            'apikey' => '8ce9c06326641d234d76eab5'
        ]);
        $data = $response->json();
        if (isset($data['rates'][$request->currency]) && isset($data['rates']['EUR'])) {
            $poundRate = $data['rates'][$request->currency]; // سعر العملة مقابل USD
            $eurRate = $data['rates']['EUR']; // سعر اليورو مقابل USD
        
            $poundToEur = $poundRate / $eurRate; // تحويل العملة إلى اليورو
            $amount = round($request->total_price / $poundToEur, 2);
        } else {
            return back()->with('error', 'Payment failed: لم يتم العثور على العملة');
        }
        
        // إنشاء عملية الدفع باستخدام Stripe
        $charge = Charge::create([
            'amount' => $amount * 100, // المبلغ بالـ سنتات
            'currency' => 'eur',
            'source' => $request->stripeToken,
            'description' => 'Payment from ' . $request->email,
        ]);

        // الحصول على تفاصيل البطاقة
        $card = $charge->payment_method_details->card;
        $lastFour = $card->last4; // آخر 4 أرقام من البطاقة
        $cardType = $card->brand; // نوع البطاقة (مثل visa, mastercard, إلخ)
        $user = Auth::user();
        $cartIds = Cart::where('user_id', $user->id)
    ->where('status_pay', false)
    ->pluck('id')
    ->toArray(); 

    do {
        $invoiceNumber = strtoupper(chr(rand(65, 90))) . rand(10000, 99999) . strtoupper(chr(rand(65, 90)));
    } while (Payment::where('invoice_number', $invoiceNumber)->exists());


        // حفظ تفاصيل الدفع في قاعدة البيانات
        $payment = Payment::create([
            'invoice_number' => $invoiceNumber, 
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'building_number' => $request->building_number,
            'amount' => $request->total_price, // تأكد من إرسال المبلغ
            'currency' => $request->currency ?? 'EUR', // إضافة العملة
            'payment_status' => 'success',
            'stripe_payment_id' => $charge->id ?? null,
            'last_four_digits' => $lastFour, // حفظ آخر 4 أرقام من البطاقة
            'card_type' => $cardType, // حفظ نوع البطاقة
            'cart_ids' => json_encode($cartIds), // حفظ cart_ids كمصفوفة
            'user_id' => auth()->id(), // حفظ ID المستخدم
        ]);

        // تحديث حالة السلة بعد الدفع
        Cart::where('user_id', auth()->id())->update(['status_pay' => true]);
        
        Mail::to($request->email)->send(new PaymentSuccessMail($payment));

        return redirect()->route('checkout.success', ['lang' => app()->getLocale()])->with('success', 'Payment Successful! رقم الفاتورة: ' . $invoiceNumber);

    } catch (\Exception $e) {
        return back()->with('error', 'Payment failed: ' . $e->getMessage());
    }
}


    public function checkoutSuccess()
    {
        return view('user.checkout.success');
    }
}
