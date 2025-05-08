<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en', 'name_de', 'name_fr', 'name_es', 'name_ar',
        'description_en', 'description_de', 'description_fr', 'description_es', 'description_ar',
        'event_date', 'image',
    ];
}
