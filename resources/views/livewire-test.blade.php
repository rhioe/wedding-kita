<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livewire Test</title>
    
    <!-- TAILWIND CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen p-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8 p-6 bg-white rounded-xl shadow">
            <h1 class="text-3xl font-bold text-gray-800">🚀 Livewire Component Test</h1>
            <p class="text-gray-600 mt-2">Create Listing Wizard - Form muncul tapi perlu styling</p>
        </div>
        
        <!-- Livewire Component -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <livewire:vendor.listings.create-listing-wizard />
        </div>
        
        <!-- Debug Info -->
        <div class="mt-6 p-4 bg-blue-50 rounded-lg text-sm">
            <p>✅ Livewire Component Loaded</p>
            <p>⚠️ Styling perlu diperbaiki</p>
        </div>
    </div>
    
    @livewireScripts
    
    <!-- Tailwind Config untuk custom styles -->
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    'wedding-purple': '#8B5CF6',
                    'wedding-pink': '#EC4899',
                    'wedding-gold': '#F59E0B',
                }
            }
        }
    }
    </script>
</body>
</html>