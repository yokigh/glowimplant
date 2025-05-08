<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'country_id',
        'old_price',
        'new_price',
    ];

    // الربط مع نموذج المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // الربط مع نموذج المنتج
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // الربط مع نموذج الدولة
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
