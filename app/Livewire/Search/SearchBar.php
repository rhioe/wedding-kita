<?php

// app/Livewire/Search/SearchBar.php

namespace App\Livewire\Search;

use Livewire\Component;

class SearchBar extends Component
{
    public $q = '';

    public function updatedQ()
    {
        // Hanya log, tidak redirect otomatis
        \Log::info('SearchBar typing', ['q' => $this->q, 'length' => strlen($this->q)]);

        // Auto-search dilakukan di SearchListings component
        // Tidak perlu redirect di sini
    }

    public function render()
    {
        return view('livewire.search.search-bar');
    }
}
