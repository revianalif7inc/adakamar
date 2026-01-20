<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    public function homestays()
    {
        return $this->hasMany(Homestay::class);
    }
}
