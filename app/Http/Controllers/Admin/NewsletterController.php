<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewsletterMail;
use App\Models\Newsletter;
use App\Models\User;
use App\Models\EmailNewsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Jobs\SendNewsletterJob;

class NewsletterController extends Controller
{

    public function index(){
        return view('admin.newslatter.create');
    }
    public function store($lang,Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'send_date' => 'required|date|after_or_equal:today',
            'send_time' => 'required|date_format:H:i',
            'users_sent' => 'required|in:all_subscribers,all_users,both',
        ]);
        

        // حفظ البيانات في قاعدة البيانات
        $newsletter = Newsletter::create($request->all());
        
        $emails = [];
            if ($request->users_sent === 'all_subscribers' || $request->users_sent === 'both') {
                $emails = array_merge($emails, EmailNewsletter::pluck('email')->toArray());
            }
            if ($request->users_sent === 'all_users' || $request->users_sent === 'both') {
                $emails = array_merge($emails, User::pluck('email')->toArray());
            }
            $emails = array_unique($emails); // إزالة التكرارات

            // حساب وقت الإرسال
            $sendDateTime = Carbon::parse("{$request->send_date} {$request->send_time}");

            // جدولة الإرسال في الوقت المحدد
            SendNewsletterJob::dispatch($request->subject, $request->description, $emails)
                            ->delay($sendDateTime->diffInSeconds(Carbon::now()));

        return redirect()->back()->with('success', 'Newsletter scheduled successfully');
        
    }

    
}
