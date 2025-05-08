<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_en', 'name_de', 'name_fr', 'name_es', 'name_ar',
        'country_id', 'email', 'phone', 'url_facebook', 'url_whatsapp',
        'url_instagram', 'url_tiktok', 'url_x', 'url_youtube',
        'map', 'address',
        'description_en', 'description_de', 'description_fr', 'description_es', 'description_ar'
    ];

    // تعريف العلاقة مع جدول countries
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }


}
