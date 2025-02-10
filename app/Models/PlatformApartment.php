<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformApartment extends Model
{
    use HasFactory;

    protected $table = 'platform_apartment'; // Nombre correcto de la tabla pivot

    protected $fillable = [
        'apartment_id',
        'platform_id',
        'register_date',
        'premium',
    ];
}
