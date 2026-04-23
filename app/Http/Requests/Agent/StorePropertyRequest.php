<?php

namespace App\Http\Requests\Agent;

use App\Support\PropertyCatalog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StorePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null && ($user->isAgent() || $user->isAdmin());
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'listing_type' => ['required', Rule::in(array_keys(PropertyCatalog::listingTypes()))],
            'property_type' => ['required', Rule::in(array_keys(PropertyCatalog::propertyTypes()))],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'area' => ['required', 'numeric', 'min:0.01'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'region' => ['required', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:40'],
            'country' => ['required', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90', 'required_with:longitude'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180', 'required_with:latitude'],
            'map_embed_url' => ['nullable', 'url', 'max:2048'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', Rule::in(array_keys(PropertyCatalog::currencyOptions()))],
            'price_period' => ['required', Rule::in(array_keys(PropertyCatalog::pricePeriods()))],
            'deposit' => ['nullable', 'numeric', 'min:0'],
            'bedrooms' => $this->residentialIntegerRules(),
            'bathrooms' => $this->residentialIntegerRules(),
            'garage_spaces' => $this->nonLandIntegerRules(),
            'total_rooms' => $this->residentialIntegerRules(),
            'floor' => $this->nonLandIntegerRules(),
            'year_built' => $this->yearBuiltRules(),
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['string', Rule::in(PropertyCatalog::amenityLabelsFor($this->propertyType()))],
            'pets_allowed' => [
                Rule::excludeIf(! $this->isResidentialProperty()),
                'nullable',
                'array',
            ],
            'pets_allowed.*' => [
                Rule::excludeIf(! $this->isResidentialProperty()),
                'string',
                Rule::in(PropertyCatalog::petLabels()),
            ],
            'images' => ['required', 'array', 'min:1', 'max:10'],
            'images.*' => ['required', File::image()->max(8 * 1024)],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'listing_type' => 'listing type',
            'property_type' => 'property type',
            'postal_code' => 'postal code',
            'map_embed_url' => 'map embed URL',
            'price_period' => 'price period',
            'currency' => 'currency',
            'garage_spaces' => 'parking spaces',
            'total_rooms' => 'total rooms',
            'year_built' => 'year built',
            'pets_allowed' => 'pets allowed',
            'images.*' => 'property image',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'images.required' => 'Upload at least one property image.',
            'images.*.image' => 'Each uploaded file must be an image.',
            'amenities.*.in' => 'One of the selected amenities does not apply to this property type.',
            'pets_allowed.*.in' => 'The selected pet option is not available for this property type.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'listing_type' => Str::of((string) $this->input('listing_type'))->trim()->lower()->value(),
            'property_type' => PropertyCatalog::normalizePropertyType($this->input('property_type')),
            'currency' => Str::of((string) $this->input('currency', PropertyCatalog::defaultCurrency()))
                ->trim()
                ->upper()
                ->value(),
            'price_period' => Str::of((string) $this->input('price_period'))->trim()->lower()->value(),
        ]);
    }

    /**
     * @return array<int, mixed>
     */
    private function residentialIntegerRules(): array
    {
        return [
            Rule::excludeIf(! $this->isResidentialProperty()),
            'nullable',
            'integer',
            'min:0',
        ];
    }

    /**
     * @return array<int, mixed>
     */
    private function nonLandIntegerRules(): array
    {
        return [
            Rule::excludeIf($this->isLandProperty()),
            'nullable',
            'integer',
            'min:0',
        ];
    }

    /**
     * @return array<int, mixed>
     */
    private function yearBuiltRules(): array
    {
        return [
            Rule::excludeIf($this->isLandProperty()),
            'nullable',
            'integer',
            'min:1800',
            'max:'.(now()->year + 1),
        ];
    }

    private function propertyType(): string
    {
        return PropertyCatalog::normalizePropertyType($this->input('property_type'));
    }

    private function isLandProperty(): bool
    {
        return PropertyCatalog::isLand($this->propertyType());
    }

    private function isResidentialProperty(): bool
    {
        return PropertyCatalog::isResidential($this->propertyType());
    }
}
