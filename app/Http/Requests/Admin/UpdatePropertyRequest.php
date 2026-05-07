<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Concerns\ValidatesPropertyListing;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
{
    use ValidatesPropertyListing;

    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->propertyRules(requiresImages: false, includeAdminFields: true);
    }

    protected function prepareForValidation(): void
    {
        $this->normalizePropertyInput();
    }
}
