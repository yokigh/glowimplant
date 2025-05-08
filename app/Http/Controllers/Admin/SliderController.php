<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index($lang)
    {
        $sliders = Slider::latest()->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store($lang,Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:mobile,desktop',

        ]);


        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/slider/image');
            $img->move($path, $name);
            $imagePath = "storegs/slider/image/" . $name;
        }
        Slider::create([
            'image' => $imagePath,
            'type' => $request->type,
        ]);
    
        return redirect()->route('sliders.index', ['lang' => app()->getLocale()])->with('success', 'تم إضافة السلايدر بنجاح!');
    }

    public function edit($lang,Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update($lang,Request $request, Slider $slider)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:mobile,desktop',
        ]);

        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/slider/image');
            $img->move($path, $name);
            $product->image = "storegs/slider/image/" . $name;
        }
        $slider->type = $request->type;

        return redirect()->route('sliders.index', ['lang' => app()->getLocale()])->with('success', 'تم تحديث السلايدر بنجاح!');
    }

    public function destroy($lang,Slider $slider)
    {
       
        if ($slider->image && file_exists(public_path($slider->image))) {
            unlink(public_path($slider->image));
        }
        $slider->delete();

        return redirect()->route('sliders.index', ['lang' => app()->getLocale()])->with('success', 'تم حذف السلايدر بنجاح!');
    }
}
