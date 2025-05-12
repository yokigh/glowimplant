<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProstheticCategory;
use App\Models\ProstheticProduct;
use Illuminate\Http\Request;

class ProstheticProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($lang)
    {
        $products = ProstheticProduct::all();
        return view('admin.prosthetic_products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($lang)
    {
        $prostheticcategories = ProstheticCategory::all();
        return view('admin.prosthetic_products.create', compact('prostheticcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($lang, Request $request)
    {
        $data = $request->validate([
            'name_en' => 'required|string',
            'name_de' => 'required|string',
            'name_fr' => 'required|string',
            'name_es' => 'required|string',
            'name_ar' => 'required|string',
            'description_en' => 'nullable|string',
            'description_de' => 'nullable|string',
            'description_fr' => 'nullable|string',
            'description_es' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'ref' => 'nullable|string',
            'diameter' => 'nullable|string',
            'height' => 'nullable|string',
            'ml' => 'nullable|string',
            'angle' => 'nullable|numeric',
            'screw_ref' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'images.*' => 'nullable|file|mimes:jpeg,png,jpg,gif',
            'prosthetic_category_id' => 'required|exists:prosthetic_categories,id',
        ]);
        $data['image'] = null;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/prosthetic_products/image');
            $img->move($path, $name);
            $data['image'] = "storegs/prosthetic_products/image/" . $name;
        }
        $data['images'] = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $ext = $img->getClientOriginalExtension();
                $name = time() . '_' . uniqid() . '.' . $ext;
                $path = public_path('storegs/prosthetic_products/images');
                $img->move($path, $name);
                $data['images'][] = "storegs/prosthetic_products/images/" . $name;
            }
            // Save as JSON string in the database
            $data['images'] = json_encode($data['images']);
        } else {
            $data['images'] = json_encode([]);
        }


        ProstheticProduct::create($data);
        return redirect()->route('prosthetic_products.index', ['lang' => app()->getLocale()])->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($lang, ProstheticProduct $prostheticProduct)
    {
        return view('admin.prosthetic_products.show', compact('prostheticProduct'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($lang, ProstheticProduct $prostheticProduct)
    {
        $prostheticcategories = ProstheticCategory::all();
        return view('admin.prosthetic_products.edit', compact('prostheticProduct', 'prostheticcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($lang, Request $request, ProstheticProduct $prostheticProduct)
    {
        $data = $request->validate([
            'name_en' => 'required|string',
            'name_de' => 'required|string',
            'name_fr' => 'required|string',
            'name_es' => 'required|string',
            'name_ar' => 'required|string',
            'description_en' => 'nullable|string',
            'description_de' => 'nullable|string',
            'description_fr' => 'nullable|string',
            'description_es' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'ref' => 'nullable|string',
            'diameter' => 'nullable|string',
            'height' => 'nullable|string',
            'ml' => 'nullable|string',
            'angle' => 'nullable|numeric',
            'screw_ref' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'images.*' => 'nullable|file|mimes:jpeg,png,jpg,gif',
            'prosthetic_category_id' => 'required|exists:prosthetic_categories,id',
        ]);

        // Handle single image
        if ($request->hasFile('image')) {
            // Delete old image
            if ($prostheticProduct->image && file_exists(public_path($prostheticProduct->image))) {
                unlink(public_path($prostheticProduct->image));
            }

            // Upload new image
            $img = $request->file('image');
            $ext = $img->getClientOriginalExtension();
            $name = time() . '.' . $ext;
            $path = public_path('storegs/prosthetic_products/image');
            $img->move($path, $name);
            $data['image'] = "storegs/prosthetic_products/image/" . $name;
        } else {
            $data['image'] = $prostheticProduct->image;
        }


        // Handle multiple images
        $newImages = [];
        if ($request->hasFile('images')) {
            // Delete old images
            $existingImages = json_decode($prostheticProduct->images, true) ?? [];
            foreach ($existingImages as $oldImagePath) {
                if ($oldImagePath && file_exists(public_path($oldImagePath))) {
                    unlink(public_path($oldImagePath));
                }
            }

            // Upload new images
            foreach ($request->file('images') as $img) {
                $ext = $img->getClientOriginalExtension();
                $name = time() . '_' . uniqid() . '.' . $ext;
                $path = public_path('storegs/prosthetic_products/images');

                // Ensure directory exists
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                $img->move($path, $name);
                $newImages[] = "storegs/prosthetic_products/images/" . $name;
            }

            $data['images'] = json_encode($newImages);
        } else {
            $data['images'] = $prostheticProduct->images;
        }


        $prostheticProduct->update($data);

        return redirect()->route('prosthetic_products.index', ['lang' => app()->getLocale()])
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($lang, ProstheticProduct $prostheticProduct)
    {
        // Delete main image if exists
        if ($prostheticProduct->image && file_exists(public_path($prostheticProduct->image))) {
            unlink(public_path($prostheticProduct->image));
        }

        // Delete multiple images if exist (stored as JSON array)
        if ($prostheticProduct->images) {
            $images = json_decode($prostheticProduct->images, true);
            if (is_array($images)) {
                foreach ($images as $imagePath) {
                    if ($imagePath && file_exists(public_path($imagePath))) {
                        unlink(public_path($imagePath));
                    }
                }
            }
        }
        // Delete the database record
        $prostheticProduct->delete();
        return redirect()->route('prosthetic_products.index', ['lang' => app()->getLocale()])->with('success', 'Product deleted successfully.');
    }
}
