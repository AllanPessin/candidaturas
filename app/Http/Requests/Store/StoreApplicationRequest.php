<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
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
            'position' => 'required|string',
            'link' => 'required|string|',
            'contact' => 'nullable|string|',
            'applied_date' => 'required|date',
            'interview_date' => 'nullable|date|',
            'salary' => 'nulllable|decimal:2',
            'feedback' => 'nullable|string|',
            'status_id' => 'required|numeric|exists:statuses,id',
            'company_id' => 'required|string|exists:company,id',
            'city_id' => 'nullable|string|exists:city,id',
            'modality_id' => 'required|string|exists:modalities,id',
            'contract_id' => 'required|string|exists:contract,id',
            'category_id' => 'required|string|exists:category,id',
        ];
    }
}
