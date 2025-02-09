<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    protected $fillable = ['name', 'owner'];

    public function apartments()
    {
        return $this->belongsToMany(Apartment::class)->withPivot('register_date', 'premium');
    }
}
