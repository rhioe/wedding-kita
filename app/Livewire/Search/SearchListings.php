<?php
// app/Livewire/Search/SearchListings.php

namespace App\Livewire\Search;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\SearchService;
use App\Http\Requests\SearchRequest;

class SearchListings extends Component
{
    use WithPagination;

    // Search parameters
    public $q = '';
    public $filters = [
        'category_id' => null,
        'location' => null,
        'min_price' => null,
        'max_price' => null,
        'featured' => false,
    ];
    public $sort = 'newest';
    public $perPage = 12;

    // UI state
    public $showFilters = false;
    public $filterOptions = [];

    protected $queryString = [
        'q' => ['except' => ''],
        'filters' => ['except' => []],
        'sort' => ['except' => 'newest'],
        'page' => ['except' => 1],
    ];

    protected $listeners = ['refreshSearch' => '$refresh'];

    public function mount(SearchService $searchService)
    {
        $this->filterOptions = $searchService->getFilterOptions();
    }

    public function updated($property)
    {
        // Debounce untuk search input
        if ($property === 'q') {
            $this->resetPage();
            $this->dispatch('refreshSearch');
        }
        
        // Reset page jika filter berubah
        if (str_starts_with($property, 'filters')) {
            $this->resetPage();
        }
    }

    public function applyFilters()
    {
        $this->resetPage();
        $this->showFilters = false;
        $this->dispatch('refreshSearch');
    }

    public function clearFilters()
    {
        $this->filters = [
            'category_id' => null,
            'location' => null,
            'min_price' => null,
            'max_price' => null,
            'featured' => false,
        ];
        $this->resetPage();
        $this->dispatch('refreshSearch');
    }

    public function render(SearchService $searchService)
    {
        // Create SearchRequest dari component state
        $requestData = [
            'q' => $this->q,
            'filters' => array_filter($this->filters, function($value) {
                return !is_null($value) && $value !== false && $value !== '';
            }),
            'sort' => $this->sort,
            'per_page' => $this->perPage,
        ];

        $request = new SearchRequest();
        $request->merge($requestData);

        // Get results
        $listings = $searchService->search($request);

        return view('livewire.search.search-listings', [
            'listings' => $listings,
            'categories' => $this->filterOptions['categories'],
            'locations' => $this->filterOptions['locations'],
            'priceRange' => $this->filterOptions['price_range'],
        ]);
    }
}