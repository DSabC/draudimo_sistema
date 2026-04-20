<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarRequest extends FormRequest
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
            'reg_number' => ['required', 'regex:/^[A-Z]{3}[0-9]{3}$/', 'unique:cars,reg_number,' . optional($this->route('car'))->id],
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'owner_id' => 'nullable|exists:owners,id',
            'photos' => ['nullable', 'array'],
            'photos.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'reg_number.required' => __('messages.reg_number_required'),
            'reg_number.regex' => __('messages.reg_number_regex'),
            'reg_number.unique' => __('messages.reg_number_unique'),

            'brand.required' => __('messages.brand_required'),
            'brand.max' => __('messages.brand_max'),

            'model.required' => __('messages.model_required'),
            'model.max' => __('messages.model_max'),

            'owner_id.exists' => __('messages.owner_id_required'),
        ];

    }
}
