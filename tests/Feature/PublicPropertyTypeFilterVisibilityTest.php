<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPropertyTypeFilterVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_uses_supported_commercial_property_type_values(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Commercial');
        $response->assertSee('property_type=commercial', false);
        $response->assertDontSee('property_type=commercial-property', false);
    }

    public function test_properties_page_shows_canonical_commercial_property_filter_option(): void
    {
        $response = $this->get(route('properties.index', ['property_type' => 'commercial-property']));

        $response->assertStatus(200);
        $response->assertSee('Commercial');
        $response->assertSee('value="commercial"', false);
        $response->assertDontSee('value="commercial-property"', false);
    }

    public function test_home_page_shows_office_as_a_category_card_before_more_dropdown(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Townhouses', 'Office', 'More']);
    }

    public function test_home_page_more_dropdown_items_link_to_property_results_pages(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('data-more-toggle', false);
        $response->assertSee(route('properties.index', ['property_type' => 'warehouse']), false);
        $response->assertSee(route('properties.index', ['property_type' => 'retail_space']), false);
        $response->assertSee(route('properties.index', ['property_type' => 'vacation_home']), false);
        $response->assertSee(route('properties.index', ['property_type' => 'commercial']), false);
        $response->assertDontSee('<a class="hover-effect-underline stretched-link" href="#">More</a>', false);
    }
}
