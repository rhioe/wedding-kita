<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. ROUTE PUBLIK (tanpa autentikasi)
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/test', function () {
    return 'WeddingKita API is working!';
});

// 2. ROUTE GUEST (hanya bisa diakses saat TIDAK login)
Route::middleware('guest')->group(function () {
    // 2.1 Registrasi
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // 2.2 Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// 3. ROUTE AUTHENTICATED (perlu login)
Route::middleware('auth')->group(function () {
    // 3.1 Dashboard (redirect berdasarkan role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // 3.2 Profile
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
    
    // 3.3 VENDOR ROUTES
    Route::middleware('role:vendor')->prefix('vendor')->name('vendor.')->group(function () {
        // 3.3.1 Dashboard Vendor - SIMPLE CLOSURE (tetap pakai yang lama)
        Route::get('/dashboard', function () {
            $user = auth()->user();
            
            // Get or create vendor profile
            $vendor = $user->vendor;
            
            if (!$vendor) {
                // Create basic vendor profile
                $vendor = \App\Models\Vendor::create([
                    'user_id' => $user->id,
                    'business_name' => $user->name,
                    'slug' => \Str::slug($user->name) . '-' . uniqid(),
                    'status' => 'pending',
                    'description' => 'Vendor baru WeddingKita',
                    'location' => 'Indonesia',
                ]);
            }
            
            // Simple stats
            $stats = [
                'total_listings' => $vendor->listings()->count() ?? 0,
                'total_leads' => 0,
            ];
            
            $recent_leads = [];
            
            // Calculate profile completion (simple)
            $profile_completion = 40; // Default
            
            return view('vendor.dashboard', compact('vendor', 'stats', 'recent_leads', 'profile_completion'));
            
        })->name('dashboard');
        
        // 3.3.2 Profile Completion - TETAP dari folder baru
        Route::get('/profile/complete', function () {
            return view('vendor.profile.complete');
        })->name('profile.complete');
        
        // 3.3.3 CREATE LISTING - LIVEWIRE VERSION
        Route::prefix('listings')->name('listings.')->group(function () {
            // Listings index
            Route::get('/', [\App\Http\Controllers\Vendor\ListingController::class, 'index'])->name('index');
            
            // Create Listing (LIVEWIRE SINGLE PAGE)
            Route::get('/create', function () {
                return view('vendor.listings.create');
            })->name('create');
            
            // TIDAK PERLU route multi-step controller karena kita pakai Livewire
            // Hapus route: /create/step1, /create/step2, dst...
        });
        
        // 3.3.4 Leads - SIMPLE PLACEHOLDER
        Route::get('/leads', function () {
            return 'Leads & Messages - Under Development';
        })->name('leads.index');
        
        // 3.3.5 Settings - SIMPLE PLACEHOLDER
        Route::get('/settings', function () {
            return 'Settings - Under Development';
        })->name('settings');
    });
    
    // 3.4 ADMIN ROUTES
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // 3.4.1 Dashboard Admin - SIMPLE PLACEHOLDER
        Route::get('/dashboard', function () {
            return 'Admin Dashboard - Coming Soon';
        })->name('dashboard');
        
        // 3.4.2 Pending Listings - SIMPLE PLACEHOLDER
        Route::get('/listings/pending', function () {
            return 'Pending Listings - Coming Soon';
        })->name('listings.pending');
    });
    
    // 3.5 Logout
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});

// 4. ROUTE LISTING PUBLIK
Route::get('/listings', function () {
    return 'Public Listings - Coming Soon';
})->name('listings.public.index');

Route::get('/listings/{listing:slug}', function ($slug) {
    return 'Listing Detail: ' . $slug;
})->name('listings.public.show');

// 5. ROUTE VENDOR PROFILE PUBLIK
Route::get('/vendors/{vendor:slug}', function ($slug) {
    return 'Vendor Profile: ' . $slug;
})->name('vendors.public.show');

// 6. ROUTE STATIC PAGES
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

// 7. TEST ROUTES (HAPUS SETELAH PRODUCTION)
Route::middleware('auth')->group(function () {
    Route::get('/test-wizard', function() {
        return view('test-wizard');
    });
    
    Route::get('/livewire-test', function() {
        return view('livewire-test');
    });
});

// 8. CATCH-ALL untuk 404 (harus paling akhir)
Route::fallback(function () {
    return view('errors.404');
});