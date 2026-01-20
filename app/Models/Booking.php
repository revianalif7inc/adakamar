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
        'check_in_date',
        'check_out_date',
        'total_guests',
        'total_price',
        'status', // pending, confirmed, cancelled, completed
        'special_requests',
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
}
