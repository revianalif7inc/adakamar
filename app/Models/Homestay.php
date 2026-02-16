<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Homestay extends Model
{
    use HasFactory;

    protected $table = 'homestays';

    protected $fillable = [
        'owner_id',
        'category_id',
        'location_id',
        'name',
        'slug',
        'category',
        'description',
        'location',
        'price_per_night',
        'price_per_month',
        'price_per_year',
        'max_guests',
        'bedrooms',
        'bathrooms',
        'image_url',
        'images',
        'amenities',
        'rating',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'images' => 'array',
        'amenities' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Return list of gallery images ensuring primary image is first.
     */
    public function getGalleryAttribute()
    {
        $images = (array) ($this->images ?? []);
        if (!empty($this->image_url)) {
            array_unshift($images, $this->image_url);
        }
        // remove duplicates and keep order
        return array_values(array_unique($images));
    }

    /**
     * Ensure amenities is always an array.
     */
    public function getAmenitiesAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }
        return (array) ($value ?? []);
    }

    /**
     * Boot model events to generate slug when creating.
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug) && !empty($model->name)) {
                $model->slug = $model->generateUniqueSlug($model->name);
            }
        });

        // Ensure slug remains unique when name is updated but slug is empty
        static::saving(function ($model) {
            if (empty($model->slug) && !empty($model->name)) {
                $model->slug = $model->generateUniqueSlug($model->name);
            }
        });

        // Cleanup files when homestay is deleted
        static::deleting(function ($model) {
            try {
                if (!empty($model->image_url)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($model->image_url);
                }
                if (!empty($model->images) && is_array($model->images)) {
                    foreach ($model->images as $img) {
                        try {
                            \Illuminate\Support\Facades\Storage::disk('public')->delete($img);
                        } catch (\Throwable $e) {
                        }
                    }
                }
            } catch (\Throwable $e) {
            }
        });
    }

    /**
     * Generate a unique slug for the homestay.
     */
    protected function generateUniqueSlug(string $name)
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;
        while (self::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    /**
     * Apply filters from request or explicit array.
     */
    public function scopeFilter($query, $filters)
    {
        $filters = is_array($filters) ? $filters : (array) $filters;

        if ($search = $filters['search'] ?? request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($cat = $filters['category'] ?? request('category')) {
            // Accept category slug or id and match against many-to-many relation
            if (is_numeric($cat)) {
                $query->whereHas('categories', function ($q) use ($cat) {
                    $q->where('id', $cat);
                });
            } else {
                $query->whereHas('categories', function ($q) use ($cat) {
                    $q->where('slug', $cat);
                });
            }
        }

        if ($loc = $filters['location_id'] ?? request('location_id')) {
            $query->where('location_id', $loc);
        }

        if (isset($filters['min_price']) && $filters['min_price'] !== '') {
            $query->whereRaw('(COALESCE(price_per_month, price_per_year, price_per_night) >= ?)', [$filters['min_price']]);
        }
        if (isset($filters['max_price']) && $filters['max_price'] !== '') {
            $query->whereRaw('(COALESCE(price_per_month, price_per_year, price_per_night) <= ?)', [$filters['max_price']]);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', (bool) $filters['is_active']);
        }

        $sort = $filters['sort'] ?? request('sort');
        switch ($sort) {
            case 'price_asc':
                $query->orderByRaw('COALESCE(price_per_month, price_per_year, price_per_night) asc');
                break;
            case 'price_desc':
                $query->orderByRaw('COALESCE(price_per_month, price_per_year, price_per_night) desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'newest':
            default:
                // Default: show newest kamar first (most recently created)
                $query->latest('created_at');
        }

        return $query;
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'homestay_category', 'homestay_id', 'category_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Use `slug` for route model binding so URLs can use human-friendly slugs.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
