<?php

namespace Tests\Feature;

use App\Models\PropertyImage;
use Tests\TestCase;

class PropertyImageUrlTest extends TestCase
{
    public function test_it_returns_a_public_url_for_storage_prefixed_paths(): void
    {
        $image = new PropertyImage([
            'path' => 'storage/properties/9/example.jpg',
        ]);

        $this->assertSame(asset('storage/properties/9/example.jpg'), $image->url);
    }

    public function test_it_returns_a_public_disk_url_for_relative_paths(): void
    {
        $image = new PropertyImage([
            'path' => 'properties/9/example.jpg',
        ]);

        $this->assertSame(asset('storage/properties/9/example.jpg'), $image->url);
    }

    public function test_it_preserves_public_asset_paths(): void
    {
        $image = new PropertyImage([
            'path' => 'assets/img/listings/real-estate/01.jpg',
        ]);

        $this->assertSame(asset('assets/img/listings/real-estate/01.jpg'), $image->url);
    }
}
