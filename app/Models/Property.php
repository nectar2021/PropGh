<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Property extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'title',
        'slug',
        'description',
        'price',
        'currency',
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

    /**
     * @var array<string, string>
     */
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

    protected function currencySymbol(): Attribute
    {
        return Attribute::make(
            get: fn () => static::currencySymbolFor($this->currency),
        );
    }

    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->currency_symbol.' '.number_format((float) $this->price),
        );
    }

    public function getIsNewAttribute(): bool
    {
        if (! $this->published_at) {
            return false;
        }

        return $this->published_at->greaterThanOrEqualTo(Carbon::now()->subDays(7));
    }

    /**
     * @return array<string, array{label:string, symbol:string}>
     */
    public static function currencyOptions(): array
    {
        /** @var array<string, array{label:string, symbol:string}> $currencies */
        $currencies = config('properties.currencies', []);

        return $currencies;
    }

    public static function defaultCurrency(): string
    {
        return (string) config('properties.default_currency', 'GHS');
    }

    /**
     * @return array{label:string, symbol:string}
     */
    public static function currencyDefinition(?string $currency): array
    {
        $currencies = static::currencyOptions();
        $defaultCurrency = static::defaultCurrency();

        return $currencies[(string) $currency]
            ?? $currencies[$defaultCurrency]
            ?? ['label' => 'Ghana Cedi', 'symbol' => 'GH₵'];
    }

    public static function currencySymbolFor(?string $currency): string
    {
        return static::currencyDefinition($currency)['symbol'];
    }

    public static function defaultCurrencySymbol(): string
    {
        return static::currencySymbolFor(static::defaultCurrency());
    }
}
