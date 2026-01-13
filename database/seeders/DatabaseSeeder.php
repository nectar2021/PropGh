<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminEmail = env('ADMIN_EMAIL', 'admin@propsgh.com');
        $adminPassword = env('ADMIN_PASSWORD', 'Admin@12345');

        $admin = User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => env('ADMIN_NAME', 'Propsgh Admin'),
                'password' => Hash::make($adminPassword),
                'is_admin' => true,
                'role' => 'admin',
                'phone' => '+233200000000',
                'avatar_path' => 'assets/img/listings/real-estate/single/avatar.jpg',
            ]
        );

        $agent = User::firstOrCreate(
            ['email' => 'agent@propsgh.com'],
            [
                'name' => 'Liza Williams',
                'password' => Hash::make('Agent@12345'),
                'is_admin' => false,
                'role' => 'agent',
                'phone' => '745-854-4264',
                'avatar_path' => 'assets/img/listings/real-estate/single/avatar.jpg',
            ]
        );

        $host = User::firstOrCreate(
            ['email' => 'host@propsgh.com'],
            [
                'name' => 'Marcus Hill',
                'password' => Hash::make('Host@12345'),
                'is_admin' => false,
                'role' => 'host',
                'phone' => '+233500000000',
                'avatar_path' => 'assets/img/listings/real-estate/single/avatar.jpg',
            ]
        );

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'role' => 'host',
            ]
        );

        $properties = [
            [
                'title' => '40 S 9th St, Brooklyn, NY 11249',
                'price' => 1620,
                'area' => 65,
                'bedrooms' => 2,
                'bathrooms' => 1,
                'garage_spaces' => 1,
                'is_verified' => true,
                'image_set' => ['assets/img/listings/real-estate/01.jpg'],
            ],
            [
                'title' => '517 82nd St, Brooklyn, NY 11209',
                'price' => 1320,
                'area' => 45,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'garage_spaces' => 0,
                'image_set' => ['assets/img/listings/real-estate/02.jpg'],
            ],
            [
                'title' => '3811 Ditmars Blvd Astoria, NY 11105',
                'price' => 1890,
                'area' => 75,
                'bedrooms' => 2,
                'bathrooms' => 1,
                'garage_spaces' => 1,
                'is_featured' => true,
                'image_set' => ['assets/img/listings/real-estate/03.jpg'],
            ],
            [
                'title' => '67-04 Myrtle Ave Glendale, NY 11385',
                'price' => 1170,
                'area' => 42,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'garage_spaces' => 0,
                'is_verified' => true,
                'image_set' => ['assets/img/listings/real-estate/04.jpg'],
            ],
            [
                'title' => '444 Park Ave, Brooklyn, NY 11205',
                'price' => 1250,
                'area' => 54,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'garage_spaces' => 0,
                'is_verified' => true,
                'image_set' => ['assets/img/listings/real-estate/05.jpg'],
            ],
            [
                'title' => '929 Hart St, Brooklyn, NY 11237',
                'price' => 2750,
                'area' => 108,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'garage_spaces' => 1,
                'image_set' => ['assets/img/listings/real-estate/06.jpg'],
            ],
        ];

        foreach ($properties as $index => $data) {
            $title = $data['title'];
            $slug = Str::slug($title);

            $property = Property::updateOrCreate(
                ['slug' => $slug],
                [
                    'owner_id' => $index % 2 === 0 ? $agent->id : $host->id,
                    'title' => $title,
                    'description' => 'Comfortable living area, renovated kitchen, and easy access to transportation hubs.',
                    'price' => $data['price'],
                    'price_period' => 'month',
                    'deposit' => $data['price'] * 2,
                    'listing_type' => 'rent',
                    'property_type' => 'Apartment',
                    'bedrooms' => $data['bedrooms'],
                    'bathrooms' => $data['bathrooms'],
                    'garage_spaces' => $data['garage_spaces'],
                    'area' => $data['area'],
                    'year_built' => 2023,
                    'floor' => 3,
                    'total_rooms' => max(2, $data['bedrooms'] + 1),
                    'address' => $title,
                    'city' => 'Brooklyn',
                    'region' => 'NY',
                    'country' => 'USA',
                    'postal_code' => '11211',
                    'latitude' => 40.7128,
                    'longitude' => -73.9352,
                    'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2311.3724100313693!2d-73.82417211551919!3d42.62335692577899!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89dde016efd1fe73%3A0x6861561b35064fe9!2sGlendale%20Ave!5e0!3m2!1sen!2suk!4v1726842151281!5m2!1sen!2suk',
                    'amenities' => [
                        'WiFi',
                        'Dishwasher',
                        'Air conditioning',
                        'Parking place',
                        'Laundry',
                        'Iron',
                        'Security cameras',
                        'No smoking',
                        'Pets allowed',
                    ],
                    'pets_allowed' => ['Cats', 'Dogs'],
                    'status' => 'live',
                    'visibility' => 'public',
                    'is_featured' => $data['is_featured'] ?? false,
                    'is_verified' => $data['is_verified'] ?? false,
                    'views' => 120 + ($index * 10),
                    'published_at' => now()->subDays($index + 1),
                ]
            );

            PropertyImage::where('property_id', $property->id)->delete();
            foreach ($data['image_set'] as $imageIndex => $path) {
                PropertyImage::create([
                    'property_id' => $property->id,
                    'path' => $path,
                    'is_cover' => $imageIndex === 0,
                    'sort_order' => $imageIndex,
                ]);
            }
        }
    }
}
