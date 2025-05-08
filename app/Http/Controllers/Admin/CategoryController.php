<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index($lang)
    {
        $categories = Category::withCount('subcategories')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create($lang)
    {
        return view('admin.categories.create');
    }

    public function store($lang,Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_de' => 'nullable|string|max:255',
            'name_fr' => 'nullable|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'description_en' => 'required|string|max:255',
            'description_de' => 'nullable|string|max:255',
            'description_fr' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'catalog' => 'nullable|mimes:pdf|max:10000',
        ]);

        // حفظ الصورة الرئيسية
        $imagePath = null;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/Product/image');
            $img->move($path, $name);
            $imagePath = "storegs/Product/image/".$name;
        }

        // حفظ الصور المتعددة
        $imagesPaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $ext = $image->getClientOriginalExtension();
                $name = time() . '_' . uniqid() . '.' . $ext;
                $path = public_path('storegs/Product/image');
                $image->move($path, $name);
                $imagesPaths[] = "storegs/Product/image/" . $name;
            }
        }

        // حفظ الكتالوج
        $catalogPath = null;
        if ($request->hasFile('catalog')) {
            $pdf = $request->file('catalog');
            $ext = $pdf->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/Product/catalog');
            $pdf->move($path, $name);
            $catalogPath = "storegs/Product/catalog/".$name;
        }

        Category::create([
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
            'image' => $imagePath,
            'images' => json_encode($imagesPaths),
            'catalog' => $catalogPath,
        ]);

        return redirect()->route('categories.index', ['lang' => app()->getLocale()])->with('success', 'Category created successfully.');
    }

    public function edit($lang,Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update($lang,Request $request, Category $category)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_de' => 'nullable|string|max:255',
            'name_fr' => 'nullable|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'description_en' => 'required|string|max:255',
            'description_de' => 'nullable|string|max:255',
            'description_fr' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'catalog' => 'nullable|mimes:pdf|max:10000',
        ]);

        // تحديث الصورة الرئيسية
        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/Product/image');
            $img->move($path, $name);
            $category->image = "storegs/Product/image/".$name;
        }

        // تحديث الصور المتعددة
        if ($request->hasFile('images')) {
            if ($category->images) {
                foreach (json_decode($category->images) as $oldImage) {
                    if (file_exists(public_path($oldImage))) {
                        unlink(public_path($oldImage));
                    }
                }
            }

            $imagesPaths = [];
            foreach ($request->file('images') as $image) {
                $ext = $image->getClientOriginalExtension();
                $name = time() . '_' . uniqid() . '.' . $ext;
                $path = public_path('storegs/Product/image');
                $image->move($path, $name);
                $imagesPaths[] = "storegs/Product/image/" . $name;
            }
            $category->images = json_encode($imagesPaths);
        }

        // تحديث الكتالوج
        if ($request->hasFile('catalog')) {
            if ($category->catalog && file_exists(public_path($category->catalog))) {
                unlink(public_path($category->catalog));
            }

            $pdf = $request->file('catalog');
            $ext = $pdf->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/Product/catalog');
            $pdf->move($path, $name);
            $category->catalog = "storegs/Product/catalog/".$name;
        }

        $category->update($request->except(['image', 'images', 'catalog']));

        return redirect()->route('categories.index', ['lang' => app()->getLocale()])->with('success', 'Category updated successfully.');
    }
    public function show($lang, Category $category)
    {
        $subcategories = $category->subcategories; 
        return view('admin.categories.show', compact('category','subcategories'));
    }

    public function destroy($lang,Category $category)
    {
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }

        if ($category->images) {
            foreach (json_decode($category->images) as $image) {
                if (file_exists(public_path($image))) {
                    unlink(public_path($image));
                }
            }
        }

        if ($category->catalog && file_exists(public_path($category->catalog))) {
            unlink(public_path($category->catalog));
        }

        $category->delete();

        return redirect()->route('categories.index', ['lang' => app()->getLocale()])->with('success', 'Category deleted successfully.');
    }

}
