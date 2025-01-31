<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    protected $fillable = [
        'name',
        'owner',
    ];
    /** @use HasFactory<\Database\Factories\PlatformFactory> */
    use HasFactory;
}
