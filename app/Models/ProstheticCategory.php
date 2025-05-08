<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProstheticCategory extends Model
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
    ];
    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class, 'prosthetic_category_subcategory', 'prosthetic_category_id', 'subcategory_id');
    }
    public function prostheticproducts()
    {
        return $this->hasMany(ProstheticProduct::class);
    }
}
