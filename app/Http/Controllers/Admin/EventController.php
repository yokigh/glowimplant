<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index($lang)
    {
        $events = Event::all();
        return view('admin.event.index', compact('events'));
    }

    public function create($lang)
    {
        return view('admin.event.create');
    }

    public function store($lang,Request $request)
    {
        $request->validate([
            'name_en' => 'required|string',
            'name_de' => 'required|string',
            'name_fr' => 'required|string',
            'name_es' => 'required|string',
            'name_ar' => 'required|string',
            'description_en' => 'required|string',
            'description_de' => 'required|string',
            'description_fr' => 'required|string',
            'description_es' => 'required|string',
            'description_ar' => 'required|string',
            'event_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/product/image');
            $img->move($path, $name);
            $imagePath = "storegs/product/image/".$name;
        }

        Event::create([
            'name_en' => $request->name_en,
            'name_de' => $request->name_de,
            'name_fr' => $request->name_fr,
            'name_es' => $request->name_es,
            'name_ar' => $request->name_ar,
            'description_en' => $request->description_en,
            'description_de' => $request->description_de,
            'description_fr' => $request->description_fr,
            'description_es' => $request->description_es,
            'description_ar' => $request->description_ar,
            'event_date' => $request->event_date,
            'image' => $imagePath,
        ]);

        return redirect()->route('events.index', ['lang' => app()->getLocale()])->with('success', 'Event created successfully');
    }
    public function show($lang,Event $event)
    {
        // هنا الـ Event يتم تمريره مباشرة
        return view('admin.event.show', compact('event'))->with('lang', app()->getLocale());
    }
    
    public function edit($lang,Event $event)
    {
        // هنا الـ Event يتم تمريره مباشرة
        return view('admin.event.edit', compact('event'))->with('lang', app()->getLocale());
    }
    
    public function update($lang,Request $request, Event $event)
    {
        $request->validate([
            'name_en' => 'required|string',
            'name_de' => 'required|string',
            'name_fr' => 'required|string',
            'name_es' => 'required|string',
            'name_ar' => 'required|string',
            'description_en' => 'required|string',
            'description_de' => 'required|string',
            'description_fr' => 'required|string',
            'description_es' => 'required|string',
            'description_ar' => 'required|string',
            'event_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $imagePath = $event->image;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/product/image');
            $img->move($path, $name);
            $imagePath = "storegs/product/image/".$name;
        }
    
        // تحديث البيانات
        $event->update([
            'name_en' => $request->name_en,
            'name_de' => $request->name_de,
            'name_fr' => $request->name_fr,
            'name_es' => $request->name_es,
            'name_ar' => $request->name_ar,
            'description_en' => $request->description_en,
            'description_de' => $request->description_de,
            'description_fr' => $request->description_fr,
            'description_es' => $request->description_es,
            'description_ar' => $request->description_ar,
            'event_date' => $request->event_date,
            'image' => $imagePath,
        ]);
    
        return redirect()->route('events.index', ['lang' => app()->getLocale()])->with('success', 'Event updated successfully');
    }
    
    public function destroy($lang,Event $event)
    {
        if ($event->image && Storage::exists('public/' . $event->image)) {
            Storage::delete('public/' . $event->image);
        }
        $event->delete();
    
        return redirect()->route('events.index', ['lang' => app()->getLocale()])->with('success', 'Event deleted successfully');
    }
    
}
