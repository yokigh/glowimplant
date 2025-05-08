<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProstheticProduct extends Model
{
    protected $fillable = [
        'name_en',
        'name_es',
        'name_fr',
        'name_de',
        'name_ar',
        'description_en',
        'description_de',
        'description_fr',
        'description_es',
        'description_ar',
        'ref',
        'diameter',
        'height',
        'ml',
        'angle',
        'screw_ref',
        'image',
        'images',
        'prosthetic_category_id'
    ];
    public function prostheticcategory()
    {
        return $this->belongsTo(ProstheticCategory::class, 'prosthetic_category_id');
    }
    use HasFactory;
}
