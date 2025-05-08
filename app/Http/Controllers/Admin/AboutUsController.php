<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::all();
        return view('admin.about_us.index', compact('aboutUs'));
    }

    public function create()
    {
        return view('admin.about_us.create');
    }

    public function store($lang, Request $request)
    {
        $request->validate([
            'name_en' => 'required|string',
            'name_de' => 'required|string',
            'name_ar' => 'required|string',
            'name_fr' => 'required|string',
            'name_es' => 'required|string',
            'description_en' => 'required|string',
            'description_de' => 'required|string',
            'description_ar' => 'required|string',
            'description_fr' => 'required|string',
            'description_es' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/about/image');
            $img->move($path, $name);
            $date['image'] = "storegs/about/image/" . $name;
        }

        AboutUs::create($data);

        return redirect()->route('about-us.index', ['lang' => app()->getLocale()])->with('success', 'About Us Created Successfully');
    }

    public function edit($lang, AboutUs $about_u)
    {
        return view('admin.about_us.edit', compact('about_u'));
    }

    public function update($lang, Request $request, AboutUs $about_u)
    {
        $request->validate([
            'name_en' => 'required|string',
            'name_de' => 'required|string',
            'name_ar' => 'required|string',
            'name_fr' => 'required|string',
            'name_es' => 'required|string',
            'description_en' => 'required|string',
            'description_de' => 'required|string',
            'description_ar' => 'required|string',
            'description_fr' => 'required|string',
            'description_es' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $data = $request->all();

        
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/about/image');
            $img->move($path, $name);
            $data['image'] = "storegs/about/image/" . $name;
        }

        $about_u->update($data);

        return redirect()->route('about-us.index', ['lang' => app()->getLocale()])->with('success', 'About Us Updated Successfully');
    }

    public function destroy($lang, AboutUs $about_u)
    {
       
        if ($about_u->image && file_exists(public_path($about_u->image))) {
            unlink(public_path($about_u->image));
        }

        $about_u->delete();

        return redirect()->route('about-us.index', ['lang' => app()->getLocale()])->with('success', 'About Us Deleted Successfully');
    }
}
