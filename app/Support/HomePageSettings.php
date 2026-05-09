<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;

class HomePageSettings
{
    /**
     * @return array<string, string>
     */
    public static function textDefaults(): array
    {
        return [
            'home_meta_title' => 'Propsgh | Real Estate - Homepage',
            'home_meta_description' => 'Discover verified properties, rentals, and shortlets across Ghana with Propsgh.',
            'home_hero_title' => 'Easy way to find a perfect property',
            'home_hero_subtitle' => 'We provide a complete service for the sale, purchase or rental of real estate.',
            'home_hero_primary_label' => 'Buy',
            'home_hero_secondary_label' => 'Sell',
            'home_hero_tertiary_label' => 'Rent',
            'home_search_listing_type_label' => 'Looking for',
            'home_search_property_type_label' => 'Property type',
            'home_search_location_label' => 'Location',
            'home_search_location_placeholder' => 'Any city / area',
            'home_search_budget_label' => 'Budget',
            'home_search_submit_label' => 'Search',
            'home_category_land_label' => 'Lands',
            'home_category_house_label' => 'Houses',
            'home_category_apartment_label' => 'Apartments',
            'home_category_townhouse_label' => 'Townhouses',
            'home_category_office_label' => 'Office',
            'home_category_more_label' => 'More',
            'home_category_offers_suffix' => 'offers',
            'home_top_offers_heading' => 'Top offers',
            'home_top_offers_empty_state' => 'No properties available yet.',
            'home_city_heading' => 'Search by city',
            'home_city_sale_label' => 'for sale',
            'home_city_rent_label' => 'for rent',
            'home_city_empty_state' => 'No cities available yet.',
            'home_action_buy_title' => 'Buy a property',
            'home_action_buy_button_label' => 'Find a home',
            'home_action_buy_button_url' => route('properties.index', ['listing_type' => 'sale']),
            'home_action_sell_title' => 'Sell a property',
            'home_action_sell_button_label' => 'Place an ad',
            'home_action_sell_button_url' => route('properties.index', ['listing_type' => 'sale']),
            'home_action_rent_title' => 'Rent a property',
            'home_action_rent_button_label' => 'Find a rental',
            'home_action_rent_button_url' => route('properties.index', ['listing_type' => 'rent']),
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function imageDefaults(): array
    {
        return [
            'home_hero_primary_image_path' => 'assets/img/home/real-estate/hero/01.jpg',
            'home_hero_secondary_image_path' => 'assets/img/home/real-estate/hero/02.png',
            'home_hero_tertiary_image_path' => 'assets/img/home/real-estate/hero/03.jpg',
            'home_action_buy_image_path' => 'assets/img/home/real-estate/categories/01.png',
            'home_action_sell_image_path' => 'assets/img/home/real-estate/categories/02.png',
            'home_action_rent_image_path' => 'assets/img/home/real-estate/categories/03.png',
            'home_city_image_1_path' => 'assets/img/home/real-estate/cities/01.jpg',
            'home_city_image_2_path' => 'assets/img/home/real-estate/cities/02.jpg',
            'home_city_image_3_path' => 'assets/img/home/real-estate/cities/03.jpg',
            'home_city_image_4_path' => 'assets/img/home/real-estate/cities/04.jpg',
            'home_city_image_5_path' => 'assets/img/home/real-estate/cities/05.jpg',
            'home_city_image_6_path' => 'assets/img/home/real-estate/cities/06.jpg',
        ];
    }

    /**
     * @return array<string, array{key:string, folder:string}>
     */
    public static function imageSettingInputs(): array
    {
        return [
            'home_hero_primary_image' => [
                'key' => 'home_hero_primary_image_path',
                'folder' => 'branding/home',
            ],
            'home_hero_secondary_image' => [
                'key' => 'home_hero_secondary_image_path',
                'folder' => 'branding/home',
            ],
            'home_hero_tertiary_image' => [
                'key' => 'home_hero_tertiary_image_path',
                'folder' => 'branding/home',
            ],
            'home_action_buy_image' => [
                'key' => 'home_action_buy_image_path',
                'folder' => 'branding/home',
            ],
            'home_action_sell_image' => [
                'key' => 'home_action_sell_image_path',
                'folder' => 'branding/home',
            ],
            'home_action_rent_image' => [
                'key' => 'home_action_rent_image_path',
                'folder' => 'branding/home',
            ],
            'home_city_image_1' => [
                'key' => 'home_city_image_1_path',
                'folder' => 'branding/home/cities',
            ],
            'home_city_image_2' => [
                'key' => 'home_city_image_2_path',
                'folder' => 'branding/home/cities',
            ],
            'home_city_image_3' => [
                'key' => 'home_city_image_3_path',
                'folder' => 'branding/home/cities',
            ],
            'home_city_image_4' => [
                'key' => 'home_city_image_4_path',
                'folder' => 'branding/home/cities',
            ],
            'home_city_image_5' => [
                'key' => 'home_city_image_5_path',
                'folder' => 'branding/home/cities',
            ],
            'home_city_image_6' => [
                'key' => 'home_city_image_6_path',
                'folder' => 'branding/home/cities',
            ],
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function textSettingKeys(): array
    {
        return array_keys(self::textDefaults());
    }

    /**
     * @return array<int, string>
     */
    public static function imageSettingKeys(): array
    {
        return array_map(
            static fn (array $config): string => $config['key'],
            self::imageSettingInputs(),
        );
    }

    /**
     * @return array<int, string>
     */
    public static function allSettingKeys(): array
    {
        return array_merge(self::textSettingKeys(), self::imageSettingKeys());
    }

    /**
     * @return array<string, array<int, string>|string>
     */
    public static function validationRules(): array
    {
        $rules = [
            'home_meta_title' => ['nullable', 'string', 'max:255'],
            'home_meta_description' => ['nullable', 'string', 'max:255'],
            'home_hero_title' => ['nullable', 'string', 'max:255'],
            'home_hero_subtitle' => ['nullable', 'string', 'max:500'],
            'home_hero_primary_label' => ['nullable', 'string', 'max:50'],
            'home_hero_secondary_label' => ['nullable', 'string', 'max:50'],
            'home_hero_tertiary_label' => ['nullable', 'string', 'max:50'],
            'home_search_listing_type_label' => ['nullable', 'string', 'max:100'],
            'home_search_property_type_label' => ['nullable', 'string', 'max:100'],
            'home_search_location_label' => ['nullable', 'string', 'max:100'],
            'home_search_location_placeholder' => ['nullable', 'string', 'max:100'],
            'home_search_budget_label' => ['nullable', 'string', 'max:100'],
            'home_search_submit_label' => ['nullable', 'string', 'max:100'],
            'home_category_land_label' => ['nullable', 'string', 'max:100'],
            'home_category_house_label' => ['nullable', 'string', 'max:100'],
            'home_category_apartment_label' => ['nullable', 'string', 'max:100'],
            'home_category_townhouse_label' => ['nullable', 'string', 'max:100'],
            'home_category_office_label' => ['nullable', 'string', 'max:100'],
            'home_category_more_label' => ['nullable', 'string', 'max:100'],
            'home_category_offers_suffix' => ['nullable', 'string', 'max:100'],
            'home_top_offers_heading' => ['nullable', 'string', 'max:100'],
            'home_top_offers_empty_state' => ['nullable', 'string', 'max:255'],
            'home_city_heading' => ['nullable', 'string', 'max:100'],
            'home_city_sale_label' => ['nullable', 'string', 'max:100'],
            'home_city_rent_label' => ['nullable', 'string', 'max:100'],
            'home_city_empty_state' => ['nullable', 'string', 'max:255'],
            'home_action_buy_title' => ['nullable', 'string', 'max:100'],
            'home_action_buy_button_label' => ['nullable', 'string', 'max:100'],
            'home_action_buy_button_url' => ['nullable', 'string', 'max:255'],
            'home_action_sell_title' => ['nullable', 'string', 'max:100'],
            'home_action_sell_button_label' => ['nullable', 'string', 'max:100'],
            'home_action_sell_button_url' => ['nullable', 'string', 'max:255'],
            'home_action_rent_title' => ['nullable', 'string', 'max:100'],
            'home_action_rent_button_label' => ['nullable', 'string', 'max:100'],
            'home_action_rent_button_url' => ['nullable', 'string', 'max:255'],
        ];

        foreach (array_keys(self::imageSettingInputs()) as $inputName) {
            $rules[$inputName] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'];
            $rules[self::removeInputName($inputName)] = ['nullable', 'boolean'];
        }

        return $rules;
    }

    /**
     * @return array<int, array{label:string,input:string,setting:string,remove:string}>
     */
    public static function heroImageFields(): array
    {
        return [
            [
                'label' => 'Hero image 1',
                'input' => 'home_hero_primary_image',
                'setting' => 'home_hero_primary_image_path',
                'remove' => self::removeInputName('home_hero_primary_image'),
            ],
            [
                'label' => 'Hero image 2',
                'input' => 'home_hero_secondary_image',
                'setting' => 'home_hero_secondary_image_path',
                'remove' => self::removeInputName('home_hero_secondary_image'),
            ],
            [
                'label' => 'Hero image 3',
                'input' => 'home_hero_tertiary_image',
                'setting' => 'home_hero_tertiary_image_path',
                'remove' => self::removeInputName('home_hero_tertiary_image'),
            ],
        ];
    }

    /**
     * @return array<int, array{label:string,input:string,setting:string,remove:string}>
     */
    public static function cityImageFields(): array
    {
        return [
            [
                'label' => 'City image 1',
                'input' => 'home_city_image_1',
                'setting' => 'home_city_image_1_path',
                'remove' => self::removeInputName('home_city_image_1'),
            ],
            [
                'label' => 'City image 2',
                'input' => 'home_city_image_2',
                'setting' => 'home_city_image_2_path',
                'remove' => self::removeInputName('home_city_image_2'),
            ],
            [
                'label' => 'City image 3',
                'input' => 'home_city_image_3',
                'setting' => 'home_city_image_3_path',
                'remove' => self::removeInputName('home_city_image_3'),
            ],
            [
                'label' => 'City image 4',
                'input' => 'home_city_image_4',
                'setting' => 'home_city_image_4_path',
                'remove' => self::removeInputName('home_city_image_4'),
            ],
            [
                'label' => 'City image 5',
                'input' => 'home_city_image_5',
                'setting' => 'home_city_image_5_path',
                'remove' => self::removeInputName('home_city_image_5'),
            ],
            [
                'label' => 'City image 6',
                'input' => 'home_city_image_6',
                'setting' => 'home_city_image_6_path',
                'remove' => self::removeInputName('home_city_image_6'),
            ],
        ];
    }

    /**
     * @return array<int, array{title:string,title_key:string,button_label_key:string,button_url_key:string,image_input:string,image_setting:string,remove_key:string,placeholder_url:string}>
     */
    public static function actionCardFields(): array
    {
        return [
            [
                'title' => 'Buy card',
                'title_key' => 'home_action_buy_title',
                'button_label_key' => 'home_action_buy_button_label',
                'button_url_key' => 'home_action_buy_button_url',
                'image_input' => 'home_action_buy_image',
                'image_setting' => 'home_action_buy_image_path',
                'remove_key' => self::removeInputName('home_action_buy_image'),
                'placeholder_url' => route('properties.index', ['listing_type' => 'sale']),
            ],
            [
                'title' => 'Sell card',
                'title_key' => 'home_action_sell_title',
                'button_label_key' => 'home_action_sell_button_label',
                'button_url_key' => 'home_action_sell_button_url',
                'image_input' => 'home_action_sell_image',
                'image_setting' => 'home_action_sell_image_path',
                'remove_key' => self::removeInputName('home_action_sell_image'),
                'placeholder_url' => route('properties.index', ['listing_type' => 'sale']),
            ],
            [
                'title' => 'Rent card',
                'title_key' => 'home_action_rent_title',
                'button_label_key' => 'home_action_rent_button_label',
                'button_url_key' => 'home_action_rent_button_url',
                'image_input' => 'home_action_rent_image',
                'image_setting' => 'home_action_rent_image_path',
                'remove_key' => self::removeInputName('home_action_rent_image'),
                'placeholder_url' => route('properties.index', ['listing_type' => 'rent']),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function resolved(): array
    {
        $textDefaults = self::textDefaults();
        $imageDefaults = self::imageDefaults();

        $textSettings = $textDefaults;
        $storedSettings = array_fill_keys(self::allSettingKeys(), null);

        try {
            if (Schema::hasTable('site_settings')) {
                $storedSettings = SiteSetting::getMany(self::allSettingKeys());

                foreach ($storedSettings as $key => $value) {
                    if ($value === null || $value === '' || ! array_key_exists($key, $textSettings)) {
                        continue;
                    }

                    $textSettings[$key] = $value;
                }
            }
        } catch (\Throwable) {
            $textSettings = $textDefaults;
            $storedSettings = array_fill_keys(self::allSettingKeys(), null);
        }

        return [
            'metaTitle' => $textSettings['home_meta_title'],
            'metaDescription' => $textSettings['home_meta_description'],
            'hero' => [
                'title' => $textSettings['home_hero_title'],
                'subtitle' => $textSettings['home_hero_subtitle'],
                'slides' => [
                    [
                        'label' => $textSettings['home_hero_primary_label'],
                        'imageUrl' => self::imageUrl($storedSettings['home_hero_primary_image_path'], $imageDefaults['home_hero_primary_image_path']),
                    ],
                    [
                        'label' => $textSettings['home_hero_secondary_label'],
                        'imageUrl' => self::imageUrl($storedSettings['home_hero_secondary_image_path'], $imageDefaults['home_hero_secondary_image_path']),
                    ],
                    [
                        'label' => $textSettings['home_hero_tertiary_label'],
                        'imageUrl' => self::imageUrl($storedSettings['home_hero_tertiary_image_path'], $imageDefaults['home_hero_tertiary_image_path']),
                    ],
                ],
            ],
            'search' => [
                'listingTypeLabel' => $textSettings['home_search_listing_type_label'],
                'propertyTypeLabel' => $textSettings['home_search_property_type_label'],
                'locationLabel' => $textSettings['home_search_location_label'],
                'locationPlaceholder' => $textSettings['home_search_location_placeholder'],
                'budgetLabel' => $textSettings['home_search_budget_label'],
                'submitLabel' => $textSettings['home_search_submit_label'],
            ],
            'categories' => [
                'labels' => [
                    'land' => $textSettings['home_category_land_label'],
                    'house' => $textSettings['home_category_house_label'],
                    'apartment' => $textSettings['home_category_apartment_label'],
                    'townhouse' => $textSettings['home_category_townhouse_label'],
                    'office' => $textSettings['home_category_office_label'],
                ],
                'moreLabel' => $textSettings['home_category_more_label'],
                'offersSuffix' => $textSettings['home_category_offers_suffix'],
            ],
            'topOffersHeading' => $textSettings['home_top_offers_heading'],
            'topOffersEmptyState' => $textSettings['home_top_offers_empty_state'],
            'cityHeading' => $textSettings['home_city_heading'],
            'citySaleLabel' => $textSettings['home_city_sale_label'],
            'cityRentLabel' => $textSettings['home_city_rent_label'],
            'cityEmptyState' => $textSettings['home_city_empty_state'],
            'cityImages' => [
                self::imageUrl($storedSettings['home_city_image_1_path'], $imageDefaults['home_city_image_1_path']),
                self::imageUrl($storedSettings['home_city_image_2_path'], $imageDefaults['home_city_image_2_path']),
                self::imageUrl($storedSettings['home_city_image_3_path'], $imageDefaults['home_city_image_3_path']),
                self::imageUrl($storedSettings['home_city_image_4_path'], $imageDefaults['home_city_image_4_path']),
                self::imageUrl($storedSettings['home_city_image_5_path'], $imageDefaults['home_city_image_5_path']),
                self::imageUrl($storedSettings['home_city_image_6_path'], $imageDefaults['home_city_image_6_path']),
            ],
            'actionCards' => [
                'buy' => [
                    'title' => $textSettings['home_action_buy_title'],
                    'buttonLabel' => $textSettings['home_action_buy_button_label'],
                    'buttonUrl' => $textSettings['home_action_buy_button_url'],
                    'imageUrl' => self::imageUrl($storedSettings['home_action_buy_image_path'], $imageDefaults['home_action_buy_image_path']),
                ],
                'sell' => [
                    'title' => $textSettings['home_action_sell_title'],
                    'buttonLabel' => $textSettings['home_action_sell_button_label'],
                    'buttonUrl' => $textSettings['home_action_sell_button_url'],
                    'imageUrl' => self::imageUrl($storedSettings['home_action_sell_image_path'], $imageDefaults['home_action_sell_image_path']),
                ],
                'rent' => [
                    'title' => $textSettings['home_action_rent_title'],
                    'buttonLabel' => $textSettings['home_action_rent_button_label'],
                    'buttonUrl' => $textSettings['home_action_rent_button_url'],
                    'imageUrl' => self::imageUrl($storedSettings['home_action_rent_image_path'], $imageDefaults['home_action_rent_image_path']),
                ],
            ],
        ];
    }

    public static function removeInputName(string $inputName): string
    {
        return 'remove_'.$inputName;
    }

    private static function imageUrl(?string $storedPath, string $defaultAssetPath): string
    {
        if ($storedPath) {
            return asset('storage/'.$storedPath);
        }

        return asset($defaultAssetPath);
    }
}
