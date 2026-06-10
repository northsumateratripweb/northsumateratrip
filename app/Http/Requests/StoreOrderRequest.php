<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_whatsapp' => 'nullable|string|max:20',
            'trip_date' => 'required|date|after_or_equal:today',
            'trip_end_date' => 'nullable|date|after_or_equal:trip_date',
            'trip_type' => 'nullable|string|max:100',
            'pax_adult' => 'required|integer|min:1',
            'pax_child' => 'required|integer|min:0',
            'notes' => 'nullable|string|max:1000',
            'hotel_category' => 'nullable|string',
            'hotel_1' => 'nullable|string|max:255',
            'hotel_2' => 'nullable|string|max:255',
            'hotel_3' => 'nullable|string|max:255',
            'hotel_4' => 'nullable|string|max:255',
            'flight_info' => 'nullable|string|max:500',
            'use_drone' => 'nullable|boolean',
            'agree_terms' => 'accepted',
        ];
    }

    public function messages()
    {
        return [
            'agree_terms.accepted' => 'Anda harus menyetujui Syarat & Ketentuan sebelum memesan.',
        ];
    }
}
