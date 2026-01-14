<?php
// app/Services/SearchService.php

namespace App\Services;

use App\Models\Listing;
use App\Http\Requests\SearchRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchService
{
    protected $listing;

    public function __construct(Listing $listing)
    {
        $this->listing = $listing;
    }

    /**
     * Main search method dengan SearchRequest
     */
    public function search(SearchRequest $request): LengthAwarePaginator
    {
        $validated = $request->validatedData();
        
        $query = $this->listing->with(['vendor', 'category', 'photos'])
            ->where('status', 'approved')
            ->whereNotNull('published_at');

        // Hanya apply search query jika ada kata kunci
        if (!empty($validated['q']) && strlen(trim($validated['q'])) >= 2) {
            $this->applySearchQuery($query, $validated['q']);
        }

        // Apply filters
        if (!empty($validated['filters'])) {
            $this->applyFilters($query, $validated['filters']);
        }

        // Apply sorting
        $this->applySorting($query, $validated['sort']);

        return $query->paginate($validated['per_page']);
    }

    /**
     * Apply full-text search query
     */
    protected function applySearchQuery($query, string $searchTerm): void
    {
        $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'like', '%' . $searchTerm . '%')
              ->orWhere('description', 'like', '%' . $searchTerm . '%')
              ->orWhere('location', 'like', '%' . $searchTerm . '%')
              ->orWhere('business_name', 'like', '%' . $searchTerm . '%')
              ->orWhereHas('vendor', function ($vendorQuery) use ($searchTerm) {
                  $vendorQuery->where('business_name', 'like', '%' . $searchTerm . '%');
              })
              ->orWhereHas('category', function ($categoryQuery) use ($searchTerm) {
                  $categoryQuery->where('name', 'like', '%' . $searchTerm . '%');
              });
        });
    }

    /**
     * Apply berbagai filter
     */
    protected function applyFilters($query, array $filters): void
    {
        // Filter kategori
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Filter lokasi
        if (!empty($filters['location'])) {
            $query->where('location', 'like', '%' . $filters['location'] . '%');
        }

        // Filter harga range
        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        // Filter featured only
        if (isset($filters['featured']) && $filters['featured'] === true) {
            $query->where('is_featured', true);
        }

        // Filter vendor
        if (!empty($filters['vendor_id'])) {
            $query->where('vendor_id', $filters['vendor_id']);
        }
    }

    /**
     * Apply sorting
     */
    protected function applySorting($query, string $sortBy): void
    {
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('views_count', 'desc');
                break;
            case 'featured':
                $query->orderBy('is_featured', 'desc')->orderBy('published_at', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('published_at', 'desc');
        }
    }

    /**
     * Get filter options untuk UI
     */
    public function getFilterOptions(): array
    {
        return [
            'categories' => \App\Models\Category::orderBy('name')->get(),
            'locations' => Listing::whereNotNull('location')
                ->select('location')
                ->distinct()
                ->orderBy('location')
                ->pluck('location'),
            'price_range' => [
                'min' => Listing::min('price') ?? 0,
                'max' => Listing::max('price') ?? 100000000,
            ]
        ];
    }
}