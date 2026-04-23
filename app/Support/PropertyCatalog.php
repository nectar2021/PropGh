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
            'vacation-home' => 'Vacation Home',
            'office' => 'Office',
            'warehouse' => 'Warehouse',
            'retail-space' => 'Retail Space',
            'commercial-property' => 'Commercial',
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
     * @return array<string, list<string>>
     */
    public static function propertyTypeGroups(): array
    {
        return [
            'land' => ['land'],
            'residential' => ['house', 'apartment', 'townhouse', 'vacation-home'],
            'commercial' => ['office', 'warehouse', 'retail-space', 'commercial-property'],
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
            ->replace('_', '-')
            ->value();

        $aliases = [
            'vacation-home' => 'vacation-home',
            'vacation home' => 'vacation-home',
            'vacation_home' => 'vacation-home',
            'retail-space' => 'retail-space',
            'retail space' => 'retail-space',
            'retail_space' => 'retail-space',
            'commercial' => 'commercial-property',
            'commercial property' => 'commercial-property',
            'commercial-property' => 'commercial-property',
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
                'property_types' => ['office', 'commercial-property'],
                'options' => self::officeAmenityOptions(),
            ],
            'warehouse' => [
                'title' => 'Warehouse amenities',
                'description' => 'Logistics and operations-ready features for industrial inventory space.',
                'property_types' => ['warehouse'],
                'options' => self::warehouseAmenityOptions(),
            ],
            'retail-space' => [
                'title' => 'Retail amenities',
                'description' => 'Customer-facing and visibility features for storefront listings.',
                'property_types' => ['retail-space'],
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
            'retail-space' => self::retailAmenityOptions(),
            'office', 'commercial-property' => self::officeAmenityOptions(),
            default => self::residentialAmenityOptions(),
        };
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
            static fn (array $set): array => array_values($set['options']),
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
