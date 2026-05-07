<?php

namespace App\Http\Requests\Agent;

use App\Http\Requests\Concerns\ValidatesPropertyListing;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
{
    use ValidatesPropertyListing;

    public function authorize(): bool
    {
        $user = $this->user();
        $property = $this->route('property');

        return $user !== null
            && ($user->isAgent() || $user->isAdmin())
            && $property !== null
            && (int) $property->owner_id === (int) $user->id;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->propertyRules(requiresImages: false);
    }

    protected function prepareForValidation(): void
    {
        $this->normalizePropertyInput();
    }
}
