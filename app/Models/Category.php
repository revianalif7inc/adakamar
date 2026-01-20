<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'sort_order', 'is_pinned'];

    protected $casts = [
        'is_pinned' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function homestays()
    {
        return $this->belongsToMany(Homestay::class, 'homestay_category', 'category_id', 'homestay_id');
    }
}
