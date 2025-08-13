<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('partner'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:500',
            'event_date' => 'required|date',
            'registration_start' => 'required|date|before:event_date',
            'registration_end' => 'required|date|after:registration_start|before:event_date',
            'status' => 'required|in:draft,active,completed,cancelled',
            'partner_id' => 'nullable|exists:partners,id',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Event name is required.',
            'location.required' => 'Event location is required.',
            'event_date.required' => 'Event date is required.',
            'registration_start.before' => 'Registration start must be before event date.',
            'registration_end.after' => 'Registration end must be after registration start.',
            'registration_end.before' => 'Registration end must be before event date.',
        ];
    }
}