<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'ref', 'diameter', 'height', 'image', 'np', 'nr', 
        'description_en', 'description_de', 'description_fr', 'description_es', 'description_ar', 
        'subcategory_id','status_pay','status_order','notes',
    ];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }
    

}

