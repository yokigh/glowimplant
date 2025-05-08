<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subcategories = SubCategory::all();
        return view('admin.subcategories.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::all(); 
        return view('admin.subcategories.create',compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_de' => 'required|string|max:255',
            'name_fr' => 'required|string|max:255',
            'name_es' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'benefits_en' => 'nullable|string',
            'benefits_de' => 'nullable|string',
            'benefits_fr' => 'nullable|string',
            'benefits_es' => 'nullable|string',
            'benefits_ar' => 'nullable|string',
            'technical_info_en' => 'nullable|string',
            'technical_info_de' => 'nullable|string',
            'technical_info_fr' => 'nullable|string',
            'technical_info_es' => 'nullable|string',
            'technical_info_ar' => 'nullable|string',
            'clinical_cases_en' => 'nullable|string',
            'clinical_cases_de' => 'nullable|string',
            'clinical_cases_fr' => 'nullable|string',
            'clinical_cases_es' => 'nullable|string',
            'clinical_cases_ar' => 'nullable|string',
            'publish_articles_en' => 'nullable|string',
            'publish_articles_de' => 'nullable|string',
            'publish_articles_fr' => 'nullable|string',
            'publish_articles_es' => 'nullable|string',
            'publish_articles_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_de' => 'nullable|string',
            'description_fr' => 'nullable|string',
            'description_es' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'images' => 'nullable|array',
            'catalog' => 'nullable|file|mimes:pdf',
        ]);

        $data = $request->except('image', 'images', 'catalog');
        
        // حفظ الصورة الرئيسية
        $imagePath = null;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/subcategories/image');
            $img->move($path, $name);
            $imagePath = "storegs/subcategories/image/".$name;
        }
        $data['image'] = $imagePath;
        // حفظ الصور المتعددة
        $imagesPaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $ext = $image->getClientOriginalExtension();
                $name = time() . '_' . uniqid() . '.' . $ext;
                $path = public_path('storegs/subcategories/image');
                $image->move($path, $name);
                $imagesPaths[] = "storegs/subcategories/image/" . $name;
            }
        }
        $data['images'] = $imagesPaths;

        // حفظ الكتالوج
        $catalogPath = null;
        if ($request->hasFile('catalog')) {
            $pdf = $request->file('catalog');
            $ext = $pdf->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/subcategories/catalog');
            $pdf->move($path, $name);
            $catalogPath = "storegs/subcategories/catalog/".$name;
        }
        $data['catalog'] = $catalogPath;

        SubCategory::create($data);

        return redirect()->route('subcategories.index', ['lang' => app()->getLocale()]);
    }

    public function edit($lang,SubCategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }
    public function update($lang,Request $request, SubCategory $subcategory)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_de' => 'required|string|max:255',
            'name_fr' => 'required|string|max:255',
            'name_es' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'benefits_en' => 'nullable|string',
            'benefits_de' => 'nullable|string',
            'benefits_fr' => 'nullable|string',
            'benefits_es' => 'nullable|string',
            'benefits_ar' => 'nullable|string',
            'technical_info_en' => 'nullable|string',
            'technical_info_de' => 'nullable|string',
            'technical_info_fr' => 'nullable|string',
            'technical_info_es' => 'nullable|string',
            'technical_info_ar' => 'nullable|string',
            'clinical_cases_en' => 'nullable|string',
            'clinical_cases_de' => 'nullable|string',
            'clinical_cases_fr' => 'nullable|string',
            'clinical_cases_es' => 'nullable|string',
            'clinical_cases_ar' => 'nullable|string',
            'publish_articles_en' => 'nullable|string',
            'publish_articles_de' => 'nullable|string',
            'publish_articles_fr' => 'nullable|string',
            'publish_articles_es' => 'nullable|string',
            'publish_articles_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_de' => 'nullable|string',
            'description_fr' => 'nullable|string',
            'description_es' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'images' => 'nullable|array',
            'catalog' => 'nullable|file|mimes:pdf',
        ]);
    
        $data = $request->except('image', 'images', 'catalog');
    
        // **📌 تحديث الصورة الرئيسية**
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($subcategory->image && file_exists(public_path($subcategory->image))) {
                unlink(public_path($subcategory->image));
            }
    
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/subcategories/image');
            $img->move($path, $name);
            $data['image'] = "storegs/subcategories/image/" . $name;
        }
    
        // **📌 تحديث الصور المتعددة**
        if ($request->hasFile('images')) {
            // حذف الصور القديمة
            if (!empty($subcategory->images)) {
                $oldImages = is_string($subcategory->images) ? json_decode($subcategory->images, true) : $subcategory->images;
                if (is_array($oldImages)) {
                    foreach ($oldImages as $oldImage) {
                        if (file_exists(public_path($oldImage))) {
                            unlink(public_path($oldImage));
                        }
                    }
                }
            }
        
            $imagesPaths = [];
            foreach ($request->file('images') as $image) {
                $ext = $image->getClientOriginalExtension();
                $name = time() . '_' . uniqid() . '.' . $ext;
                $path = public_path('storegs/subcategories/image');
                $image->move($path, $name);
                $imagesPaths[] = "storegs/subcategories/image/" . $name;
            }
            $data['images'] = json_encode($imagesPaths);
        }
        
        // **📌 تحديث الكتالوج**
        if ($request->hasFile('catalog')) {
            // حذف الكتالوج القديم
            if ($subcategory->catalog && file_exists(public_path($subcategory->catalog))) {
                unlink(public_path($subcategory->catalog));
            }
    
            $pdf = $request->file('catalog');
            $ext = $pdf->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/subcategories/catalog');
            $pdf->move($path, $name);
            $data['catalog'] = "storegs/subcategories/catalog/" . $name;
        }
    
        // تحديث البيانات في قاعدة البيانات
        $subcategory->update($data);
    
        return redirect()->route('subcategories.index', ['lang' => app()->getLocale()]);
    }
    
    public function show($lang,SubCategory $subcategory){
        return view('admin.subcategories.show',compact('subcategory'));
    }

    public function destroy($lang,SubCategory $subcategory)
    {
        if ($subcategory->image && file_exists(public_path($subcategory->image))) {
            unlink(public_path($subcategory->image));
        }

        if ($subcategory->images) {
            $images = is_string($subcategory->images) ? json_decode($subcategory->images, true) : $subcategory->images;
        
            if (is_array($images)) {
                foreach ($images as $image) {
                    if (file_exists(public_path($image))) {
                        unlink(public_path($image));
                    }
                }
            }
        }
        

        if ($subcategory->catalog && file_exists(public_path($subcategory->catalog))) {
            unlink(public_path($subcategory->catalog));
        }

        $subcategory->delete();

        return redirect()->route('subcategories.index', ['lang' => app()->getLocale()])->with('success', 'Category deleted successfully.');
    }
}

