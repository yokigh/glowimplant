<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_de',
        'name_fr',
        'name_es',
        'name_ar',
        'description_en',
        'description_de',
        'description_fr',
        'description_es',
        'description_ar',
        'image',
        'images',
        'catalog',
        'benefits_en',
        'benefits_de',
        'benefits_fr',
        'benefits_es',
        'benefits_ar',
        'technical_info_en',
        'technical_info_de',
        'technical_info_fr',
        'technical_info_es',
        'technical_info_ar',
        'clinical_cases_en',
        'clinical_cases_de',
        'clinical_cases_fr',
        'clinical_cases_es',
        'clinical_cases_ar',
        'publish_articles_en',
        'publish_articles_de',
        'publish_articles_fr',
        'publish_articles_es',
        'publish_articles_ar',
        'category_id',
    ];

    protected $casts = [
        'images' => 'array',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'subcategory_id');
    }
    public function prostheticCategories()
    {
        return $this->belongsToMany(ProstheticCategory::class, 'prosthetic_category_subcategory', 'subcategory_id', 'prosthetic_category_id');
    }
}
