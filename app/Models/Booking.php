<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'homestay_id',
        'slug',
        'check_in_date',
        'check_out_date',
        'total_guests',
        'total_price',
        'status', // pending, confirmed, cancelled, completed
        'special_requests',
        'nama',
        'email',
        'nomor_hp',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Ensure total_price is always stored and returned as a non-negative float.
     */
    public function setTotalPriceAttribute($value)
    {
        $this->attributes['total_price'] = max(0, round((float) $value, 2));
    }

    public function getTotalPriceAttribute($value)
    {
        return max(0, (float) $value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function homestay()
    {
        return $this->belongsTo(Homestay::class);
    }

    /**
     * Generate unique slug for booking on create/save.
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlugForModel($model);
            }
        });

        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlugForModel($model);
            }
        });
    }

    protected static function generateUniqueSlugForModel($model)
    {
        $base = 'booking-' . ($model->id ?? time());
        // prefer customer name if available
        if (!empty($model->nama)) {
            $base = \Illuminate\Support\Str::slug($model->nama) . '-' . ($model->id ?? time());
        }

        $slug = $base;
        $i = 1;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    /**
     * Use `slug` for route model binding so booking links can use slugs.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
