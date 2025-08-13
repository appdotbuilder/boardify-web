<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGreetingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('customer');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'template_id' => 'required|exists:greeting_templates,id',
            'custom_message' => 'required|string|max:500',
            'sender_name' => 'required|string|max:255',
            'display_duration' => 'required|in:3,5,7',
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
            'event_id.required' => 'Please select an event.',
            'event_id.exists' => 'Selected event is invalid.',
            'template_id.required' => 'Please select a greeting template.',
            'template_id.exists' => 'Selected template is invalid.',
            'custom_message.required' => 'Please enter your greeting message.',
            'custom_message.max' => 'Message cannot exceed 500 characters.',
            'sender_name.required' => 'Please enter your name.',
            'display_duration.required' => 'Please select display duration.',
            'display_duration.in' => 'Display duration must be 3, 5, or 7 seconds.',
        ];
    }
}