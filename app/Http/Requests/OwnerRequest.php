<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OwnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'surname' => 'required|string|max:50',
            'phone' => ['required', 'regex:/^\+?[0-9]{8,15}$/'],
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'cars' => 'nullable|array',
            'cars.*' => 'exists:cars,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('messages.name_required'),
            'name.max' => __('messages.name_max'),

            'surname.required' => __('messages.surname_required'),
            'surname.max' => __('messages.surname_max'),

            'phone.required' => __('messages.phone_required'),
            'phone.regex' => __('messages.phone_regex'),

            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.email_email'),
            'email.max' => __('messages.email_max'),

            'address.required' => __('messages.address_required'),
            'address.max' => __('messages.address_max'),

            'cars.array' => __('messages.cars_array'),
            'cars.*.exists' => __('messages.cars_exists')
        ];
    }
}
