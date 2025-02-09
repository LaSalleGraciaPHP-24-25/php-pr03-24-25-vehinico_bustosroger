<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = ['address', 'city', 'postal_code', 'rented_price', 'rented', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Indicar que la relación es de muchos a muchos
    public function platforms()
    {
        return $this->belongsToMany(Platform::class)->withPivot('register_date', 'premium');
    }
}
