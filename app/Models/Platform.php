<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'owner'];

    // Indicar que la relación es de muchos a muchos
    public function apartments()
    {
        return $this->belongsToMany(Apartment::class, 'platform_apartment')
        ->withPivot('register_date', 'premium');
    }
}
