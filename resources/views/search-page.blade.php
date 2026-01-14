{{-- resources\views\search-page.blade.php --}}
@extends('layouts.master')

@section('title', 'Pencarian Vendor - WeddingKita')

@section('content')
<div class="py-8">
    @livewire('search.search-listings')
</div>
@endsection