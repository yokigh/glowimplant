<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProstheticCategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;
class ProstheticCategoryController extends Controller
{
    public function index($lang)
    {
        $categories = ProstheticCategory::all();
        return view('admin.prosthetic_categories.index', compact('categories'));
    }

    public function create($lang)
    {
        $subcategories = Subcategory::all();
        return view('admin.prosthetic_categories.create',compact('subcategories'));
    }

    public function store($lang, Request $request)
    {
        $data = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_de' => 'required|string|max:255',
            'name_fr' => 'required|string|max:255',
            'name_es' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_de' => 'nullable|string',
            'description_fr' => 'nullable|string',
            'description_es' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'subcategories' => 'required|array',  // <-- CHANGED from 'products' to 'subcategories'
        ]);

        $data['image'] = null;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/prosthetic_categories/image');
            $img->move($path, $name);
            $data['image'] = "storegs/prosthetic_categories/image/" . $name;
        }

        $prostheticCategory = ProstheticCategory::create($data);

        // Attach subcategories instead of products
        $prostheticCategory->subcategories()->attach($request->subcategories);

        return redirect()->route('prostatic_categories.index', ['lang' => app()->getLocale()])
            ->with('success', 'Category created.');
    }

    public function edit($lang,ProstheticCategory $prostatic_category)
    {
        $selectedSubcategories = $prostatic_category->subcategories()->pluck('subcategories.id')->toArray();
        $subcategories = Subcategory::all();
        return view('admin.prosthetic_categories.edit', compact('prostatic_category','subcategories', 'selectedSubcategories'));
    }

    public function update($lang,Request $request, ProstheticCategory $prostatic_category)
    {
        $data = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_de' => 'required|string|max:255',
            'name_fr' => 'required|string|max:255',
            'name_es' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_de' => 'nullable|string',
            'description_fr' => 'nullable|string',
            'description_es' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'subcategories' => 'required|array',
        ]);

        if ($request->hasFile('image')) {
            if ($prostatic_category->image && file_exists(public_path($prostatic_category->image))) {
                unlink(public_path($prostatic_category->image));
            }
    
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/prosthetic_categories/image');
            $img->move($path, $name);
            $data['image'] = "storegs/prosthetic_categories/image/" . $name;
        }
    

        $prostatic_category->update($data);
        $prostatic_category->subcategories()->sync($request->subcategories);
        return redirect()->route('prostatic_categories.index', ['lang' => app()->getLocale()])->with('success', 'Category updated.');
    }

    public function show($lang, ProstheticCategory $prostatic_category)
    {
        // Get all subcategories linked to this category
        $subcategories = $prostatic_category->subcategories;

        return view('admin.prosthetic_categories.show', compact('prostatic_category', 'subcategories'));
    }   

    public function destroy($lang,ProstheticCategory $prostatic_category)
    {
        if ($prostatic_category->image && file_exists(public_path($prostatic_category->image))) {
            unlink(public_path($prostatic_category->image));
        }
        $prostatic_category->delete();
        return redirect()->route('prostatic_categories.index', ['lang' => app()->getLocale()])->with('success', 'Category deleted.');
    }
}
