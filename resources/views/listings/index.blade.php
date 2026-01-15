    {{-- resources\views\listings\index.blade.php --}}
    @extends('layouts.master')

    @section('title', 'Semua Vendor - WeddingKita')

    @section('content')
    <div class="py-8">
        @livewire('search.search-listings')
    </div>
    @endsection