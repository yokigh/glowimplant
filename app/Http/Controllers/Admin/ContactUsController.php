<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\Country;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index($lang)
    {
        $contacts = ContactUs::all();
        return view('admin.contactus.index', compact('contacts'));
    }

    public function create($lang)
    {
        $countries = Country::all();
        return view('admin.contactus.create',compact('countries'));
    }

    public function store($lang,Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_de' => 'required|string|max:255',
            'name_fr' => 'required|string|max:255',
            'name_es' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_de' => 'nullable|string',
            'description_fr' => 'nullable|string',
            'description_ar' => 'nullable|string',  
            'description_es' => 'nullable|string',  
            'email' => 'required|email|unique:contact_us,email',
            'phone' => 'required|string|max:20',
            'url_facebook' => 'nullable|url',
            'url_whatsapp' => 'nullable|url',
            'url_instagram' => 'nullable|url',
            'url_tiktok' => 'nullable|url',
            'url_x' => 'nullable|url',
            'url_youtube' => 'nullable|url',
            'map' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        ContactUs::create($request->all());

        return redirect()->route('contactus.index', ['lang' => app()->getLocale()])->with('success', 'Contact created successfully');
    }

    public function show($lang,ContactUs $contactu)
    {
        return view('admin.contactus.show', compact('contactu'));
    }

    public function edit($lang,ContactUs $contactu)
    {
        $countries = Country::all();
        return view('admin.contactus.edit', compact('contactu','countries'));
    }

    public function update($lang,Request $request, ContactUs $contactu)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_de' => 'required|string|max:255',
            'name_fr' => 'required|string|max:255',
            'name_es' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_de' => 'nullable|string',
            'description_fr' => 'nullable|string',
            'description_ar' => 'nullable|string',  
            'description_es' => 'nullable|string',  
            'country_id' => 'nullable|exists:countries,id',
            'email' => 'required|email|unique:contact_us,email,' . $contactu->id,
            'phone' => 'required|string|max:20',
            'url_facebook' => 'nullable|url',
            'url_whatsapp' => 'nullable|url',
            'url_instagram' => 'nullable|url',
            'url_tiktok' => 'nullable|url',
            'url_x' => 'nullable|url',
            'url_youtube' => 'nullable|url',
            'map' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $contactu->update($request->all());

        return redirect()->route('contactus.index', ['lang' => app()->getLocale()])->with('success', 'Contact updated successfully');
    }

    public function destroy($lang,ContactUs $contactu)
    {
        $contactu->delete();
        return redirect()->route('contactus.index', ['lang' => app()->getLocale()])->with('success', 'Contact deleted successfully');
    }
}
