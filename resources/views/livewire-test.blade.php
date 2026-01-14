<?php
// resources/views/livewire-test.blade.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Livewire - WeddingKita</title>
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Test Livewire Search Component</h1>
        
        @livewire('search.search-listings')
    </div>
    
    @livewireScripts
</body>
</html>