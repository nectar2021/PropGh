<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'company_name' => [
                'nullable',
                Rule::requiredIf(fn(): bool => (bool) $user?->isAgent()),
                'string',
                'max:255',
            ],
            'avatar' => ['nullable', File::image()->max('5mb')],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'That email address is already in use.',
            'phone.max' => 'Phone numbers may not be longer than 30 characters.',
            'company_name.required' => 'Agents must provide a company or agency name.',
            'avatar.image' => 'Your profile picture must be an image file.',
            'avatar.max' => 'Your profile picture may not be larger than 5 MB.',
        ];
    }
}
