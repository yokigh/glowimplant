<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'country', 'state', 'city', 'building_number',
    'amount', 'currency', 'payment_status','stripe_payment_id','last_four_digits','card_type','cart_ids','user_id','invoice_number',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
