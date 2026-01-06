<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vendor Area') - WeddingKita</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- JANGAN TAMBAH Alpine.js DI SINI -->
    <!-- Livewire sudah include Alpine -->
    
    @livewireStyles
</head>
<body class="bg-gray-50">
    @include('vendor.components.header')
    
    <main class="pt-16">
        @yield('content')
    </main>
    
    @livewireScripts {{-- Alpine.js sudah include di sini --}}
</body>
</html>