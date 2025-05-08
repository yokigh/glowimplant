<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en', 'name_de', 'name_fr', 'name_es', 'name_ar',
        'description_en', 'description_de', 'description_fr', 'description_es', 'description_ar',
        'image', 'images', 'catalog'
    ];

    protected $casts = [
        'images' => 'array', // تحويل الصور إلى مصفوفة عند الاسترجاع
    ];
    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }


}
