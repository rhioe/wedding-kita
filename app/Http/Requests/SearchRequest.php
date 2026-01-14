<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Search boleh diakses siapa saja (public)
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
            // Search query
            'q' => 'nullable|string|min:2|max:100',
            
            // Filters
            'filters' => 'nullable|array',
            'filters.category_id' => 'nullable|integer|exists:categories,id',
            'filters.location' => 'nullable|string|max:100',
            'filters.min_price' => 'nullable|numeric|min:0',
            'filters.max_price' => 'nullable|numeric|min:0',
            'filters.featured' => 'nullable|boolean',
            'filters.vendor_id' => 'nullable|integer|exists:vendors,id',
            
            // Sorting
            'sort' => 'nullable|string|in:newest,price_low,price_high,popular,featured',
            
            // Pagination
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Transform empty string to null
        $this->merge([
            'q' => $this->q ? trim($this->q) : null,
            'filters' => $this->filters ?: [],
            'sort' => $this->sort ?: 'newest',
            'per_page' => $this->per_page ?: 12,
        ]);
    }

    /**
     * Get validated data dengan default values
     */
    public function validatedData(): array
    {
        return [
            'q' => $this->input('q'),
            'filters' => $this->input('filters', []),
            'sort' => $this->input('sort', 'newest'),
            'per_page' => (int) $this->input('per_page', 12),
        ];
    }
}