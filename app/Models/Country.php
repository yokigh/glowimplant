<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name','currency'];
    public function users()
{
    return $this->hasMany(User::class);  // تأكد من أن العلاقة صحيحة في النموذج الآخر
}
public function contacts()
    {
        return $this->hasMany(ContactUs::class, 'country_id');
    }

}
