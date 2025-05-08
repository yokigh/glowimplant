<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en', 'name_de', 'name_ar', 'name_fr', 'name_es',
        'description_en', 'description_de', 'description_ar', 'description_fr', 'description_es',
        'image',
    ];
}
