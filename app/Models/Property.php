<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Property extends Model
{
    protected $fillable = [
        'owner_id',
        'title',
        'slug',
        'description',
        'price',
        'price_period',
        'deposit',
        'listing_type',
        'property_type',
        'bedrooms',
        'bathrooms',
        'garage_spaces',
        'area',
        'year_built',
        'floor',
        'total_rooms',
        'address',
        'city',
        'region',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'map_embed_url',
        'amenities',
        'pets_allowed',
        'status',
        'visibility',
        'is_featured',
        'is_verified',
        'views',
        'published_at',
    ];

    protected $casts = [
        'amenities' => 'array',
        'pets_allowed' => 'array',
        'is_featured' => 'boolean',
        'is_verified' => 'boolean',
        'published_at' => 'datetime',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getCoverImageAttribute(): ?PropertyImage
    {
        return $this->images->firstWhere('is_cover', true) ?? $this->images->first();
    }

    public function getIsNewAttribute(): bool
    {
        if (! $this->published_at) {
            return false;
        }

        return $this->published_at->greaterThanOrEqualTo(Carbon::now()->subDays(7));
    }
}
