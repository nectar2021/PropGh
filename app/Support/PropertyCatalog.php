<?php

namespace App\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PropertyCatalog
{
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

    public static function currencySymbol(?string $currency = null): string
    {
        $currencies = self::currencyOptions();
        $defaultCurrency = self::defaultCurrency();
        $resolvedCurrency = strtoupper((string) ($currency ?: $defaultCurrency));

        return $currencies[$resolvedCurrency]['symbol']
            ?? $currencies[$defaultCurrency]['symbol']
            ?? 'GH₵';
    }

    /**
     * @return array<string, string>
     */
    public static function listingTypes(): array
    {
        return [
            'sale' => 'For sale',
            'rent' => 'For rent',
            'shortlet' => 'Shortlet',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function propertyTypes(): array
    {
        return [
            'land' => 'Land',
            'house' => 'House',
            'apartment' => 'Apartment',
            'townhouse' => 'Townhouse',
            'vacation_home' => 'Vacation Home',
            'office' => 'Office',
            'warehouse' => 'Warehouse',
            'retail_space' => 'Retail Space',
            'commercial' => 'Commercial',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function pricePeriods(): array
    {
        return [
            'day' => 'Daily',
            'week' => 'Weekly',
            'month' => 'Monthly',
            'year' => 'Yearly',
        ];
    }

    /**
     * @return list<string>
     */
    public static function ghanaRegions(): array
    {
        return [
            'Ahafo',
            'Ashanti',
            'Bono',
            'Bono East',
            'Central',
            'Eastern',
            'Greater Accra',
            'North East',
            'Northern',
            'Oti',
            'Savannah',
            'Upper East',
            'Upper West',
            'Volta',
            'Western',
            'Western North',
        ];
    }

    /**
     * @return array<string, list<string>>
     */
    public static function propertyTypeGroups(): array
    {
        return [
            'land' => ['land'],
            'residential' => ['house', 'apartment', 'townhouse', 'vacation_home'],
            'commercial' => ['office', 'warehouse', 'retail_space', 'commercial'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function propertyTypeGroupMap(): array
    {
        $groupMap = [];

        foreach (self::propertyTypeGroups() as $group => $propertyTypes) {
            foreach ($propertyTypes as $propertyType) {
                $groupMap[$propertyType] = $group;
            }
        }

        return $groupMap;
    }

    public static function normalizePropertyType(?string $propertyType): string
    {
        $normalized = Str::of((string) $propertyType)
            ->trim()
            ->lower()
            ->replace('-', '_')
            ->value();

        $aliases = [
            'vacation_home' => 'vacation_home',
            'vacation home' => 'vacation_home',
            'retail_space' => 'retail_space',
            'retail space' => 'retail_space',
            'commercial' => 'commercial',
            'commercial property' => 'commercial',
            'commercial_property' => 'commercial',
        ];

        return $aliases[$normalized] ?? $normalized;
    }

    public static function groupFor(?string $propertyType): string
    {
        $normalizedType = self::normalizePropertyType($propertyType);

        return self::propertyTypeGroupMap()[$normalizedType] ?? 'residential';
    }

    public static function isLand(?string $propertyType): bool
    {
        return self::groupFor($propertyType) === 'land';
    }

    public static function isResidential(?string $propertyType): bool
    {
        return self::groupFor($propertyType) === 'residential';
    }

    public static function isCommercial(?string $propertyType): bool
    {
        return self::groupFor($propertyType) === 'commercial';
    }

    /**
     * @return array<string, array{title:string, description:string, property_types:list<string>, options:array<string, string>}>
     */
    public static function amenityOptionSets(): array
    {
        return [
            'land' => [
                'title' => 'Land amenities',
                'description' => 'Utilities, title status, and access details for plots and parcels.',
                'property_types' => ['land'],
                'options' => self::landAmenityOptions(),
            ],
            'residential' => [
                'title' => 'Residential amenities',
                'description' => 'Comfort and lifestyle features for homes, apartments, and shortlets.',
                'property_types' => self::propertyTypeGroups()['residential'],
                'options' => self::residentialAmenityOptions(),
            ],
            'office' => [
                'title' => 'Office & commercial amenities',
                'description' => 'Operational features for offices and general commercial spaces.',
                'property_types' => ['office', 'commercial'],
                'options' => self::officeAmenityOptions(),
            ],
            'warehouse' => [
                'title' => 'Warehouse amenities',
                'description' => 'Logistics and operations-ready features for industrial inventory space.',
                'property_types' => ['warehouse'],
                'options' => self::warehouseAmenityOptions(),
            ],
            'retail_space' => [
                'title' => 'Retail amenities',
                'description' => 'Customer-facing and visibility features for storefront listings.',
                'property_types' => ['retail_space'],
                'options' => self::retailAmenityOptions(),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function amenityOptionsFor(?string $propertyType): array
    {
        $normalizedType = self::normalizePropertyType($propertyType);

        return match ($normalizedType) {
            'land' => self::landAmenityOptions(),
            'warehouse' => self::warehouseAmenityOptions(),
            'retail_space' => self::retailAmenityOptions(),
            'office', 'commercial' => self::officeAmenityOptions(),
            default => self::residentialAmenityOptions(),
        };
    }

    /**
     * @return list<string>
     */
    public static function propertyTypeVariants(?string $propertyType): array
    {
        $normalized = self::normalizePropertyType($propertyType);
        $variants = [
            $normalized,
            str_replace('_', '-', $normalized),
            str_replace('_', ' ', $normalized),
        ];

        if ($normalized === 'commercial') {
            $variants[] = 'commercial-property';
            $variants[] = 'commercial property';
        }

        if ($normalized === 'land') {
            $variants[] = 'lands';
        }

        return array_values(array_unique(array_filter($variants)));
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function normalizeListingData(array $data): array
    {
        $propertyType = self::normalizePropertyType($data['property_type'] ?? '');
        $normalizedData = [
            ...$data,
            'listing_type' => Str::of((string) ($data['listing_type'] ?? ''))->trim()->lower()->value(),
            'property_type' => $propertyType,
            'currency' => Str::of((string) ($data['currency'] ?? self::defaultCurrency()))->trim()->upper()->value(),
            'price_period' => Str::of((string) ($data['price_period'] ?? ''))->trim()->lower()->value(),
            'bedrooms' => self::nullableInteger($data['bedrooms'] ?? null),
            'bathrooms' => self::nullableInteger($data['bathrooms'] ?? null),
            'garage_spaces' => self::nullableInteger($data['garage_spaces'] ?? null),
            'floor' => self::nullableInteger($data['floor'] ?? null),
            'total_rooms' => self::nullableInteger($data['total_rooms'] ?? null),
            'year_built' => self::nullableInteger($data['year_built'] ?? null),
            'amenities' => array_values(array_filter($data['amenities'] ?? [])),
            'pets_allowed' => array_values(array_filter($data['pets_allowed'] ?? [])),
        ];

        if (self::isLand($propertyType)) {
            $normalizedData['bedrooms'] = null;
            $normalizedData['bathrooms'] = null;
            $normalizedData['garage_spaces'] = null;
            $normalizedData['floor'] = null;
            $normalizedData['total_rooms'] = null;
            $normalizedData['year_built'] = null;
            $normalizedData['pets_allowed'] = [];
        }

        if (self::isCommercial($propertyType)) {
            $normalizedData['bedrooms'] = null;
            $normalizedData['bathrooms'] = null;
            $normalizedData['total_rooms'] = null;
            $normalizedData['pets_allowed'] = [];
        }

        return $normalizedData;
    }

    private static function nullableInteger(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (int) $value;
    }

    /**
     * @return list<string>
     */
    public static function amenityLabelsFor(?string $propertyType): array
    {
        return array_values(self::amenityOptionsFor($propertyType));
    }

    /**
     * @return list<string>
     */
    public static function flatAmenityLabels(): array
    {
        return array_values(array_unique(Arr::flatten(array_map(
            static fn(array $set): array => array_values($set['options']),
            self::amenityOptionSets(),
        ))));
    }

    /**
     * @return array<string, string>
     */
    public static function amenityIcons(): array
    {
        return [
            'titled' => 'fi-badge',
            'fenced' => 'fi-shield',
            'roadside' => 'fi-navigation',
            'serviced' => 'fi-zap',
            'litigation-free' => 'fi-check-circle',
            'utility-access' => 'fi-plug',
            'wifi' => 'fi-wifi',
            'air-conditioning' => 'fi-wind',
            'parking' => 'fi-car',
            'laundry' => 'fi-droplet',
            'pool' => 'fi-droplet',
            'gym' => 'fi-zap',
            'balcony' => 'fi-sun',
            'security-cameras' => 'fi-eye',
            'backup-power' => 'fi-zap',
            'elevator' => 'fi-layers',
            'conference-room' => 'fi-briefcase',
            'loading-bay' => 'fi-package',
            'cctv' => 'fi-eye',
            'security' => 'fi-lock',
            'frontage' => 'fi-home',
            'truck-access' => 'fi-truck',
            'high-clearance' => 'fi-maximize',
            'power-supply' => 'fi-plug',
            'signage-visibility' => 'fi-image',
            'washroom' => 'fi-shower',
            'high-foot-traffic' => 'fi-users',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function petOptions(): array
    {
        return [
            'cats' => 'Cats',
            'dogs' => 'Dogs',
            'small-pets' => 'Small pets',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function petEmojis(): array
    {
        return [
            'cats' => '🐱',
            'dogs' => '🐶',
            'small-pets' => '🐹',
        ];
    }

    /**
     * @return list<string>
     */
    public static function petLabels(): array
    {
        return array_values(self::petOptions());
    }

    /**
     * @return array<string, string>
     */
    private static function landAmenityOptions(): array
    {
        return [
            'titled' => 'Titled',
            'fenced' => 'Fenced',
            'roadside' => 'Roadside',
            'serviced' => 'Serviced',
            'litigation-free' => 'Litigation free',
            'utility-access' => 'Utility access',
        ];
    }

    /**
     * @return array<string, string>
     */
    private static function residentialAmenityOptions(): array
    {
        return [
            'wifi' => 'WiFi',
            'air-conditioning' => 'Air conditioning',
            'parking' => 'Parking',
            'laundry' => 'Laundry',
            'pool' => 'Pool',
            'gym' => 'Gym',
            'balcony' => 'Balcony',
            'security-cameras' => 'Security cameras',
        ];
    }

    /**
     * @return array<string, string>
     */
    private static function officeAmenityOptions(): array
    {
        return [
            'parking' => 'Parking',
            'backup-power' => 'Backup power',
            'elevator' => 'Elevator',
            'conference-room' => 'Conference room',
            'cctv' => 'CCTV',
            'security' => 'Security',
            'frontage' => 'Frontage',
        ];
    }

    /**
     * @return array<string, string>
     */
    private static function warehouseAmenityOptions(): array
    {
        return [
            'loading-bay' => 'Loading bay',
            'truck-access' => 'Truck access',
            'high-clearance' => 'High clearance',
            'power-supply' => 'Power supply',
            'security' => 'Security',
            'parking' => 'Parking',
            'backup-power' => 'Backup power',
            'cctv' => 'CCTV',
        ];
    }

    /**
     * @return array<string, string>
     */
    private static function retailAmenityOptions(): array
    {
        return [
            'frontage' => 'Frontage',
            'signage-visibility' => 'Signage visibility',
            'washroom' => 'Washroom',
            'parking' => 'Parking',
            'high-foot-traffic' => 'High foot traffic',
            'backup-power' => 'Backup power',
            'security' => 'Security',
            'cctv' => 'CCTV',
        ];
    }
}
