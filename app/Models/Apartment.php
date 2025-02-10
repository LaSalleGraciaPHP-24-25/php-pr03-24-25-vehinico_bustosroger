<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Apartment extends Model
{
    protected $fillable = ['address', 'city', 'postal_code', 'rented_price', 'rented', 'user_id'];
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Indicar que la relación es de muchos a muchos
    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'platform_apartment')
        ->withPivot('register_date', 'premium');

}
