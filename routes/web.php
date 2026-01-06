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
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes (accessible without authentication)
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/test', function () {
    return 'WeddingKita API is working!';
});

// Guest routes (only accessible when NOT logged in)
Route::middleware('guest')->group(function () {
    // Registration
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Authenticated routes (require login)
Route::middleware('auth')->group(function () {
    // Dashboard (redirect berdasarkan role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
    
    // ==================== VENDOR ROUTES ====================
    Route::middleware('role:vendor')->prefix('vendor')->name('vendor.')->group(function () {
        // Dashboard Vendor - SIMPLE CLOSURE
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
            
            return view('dashboard.vendor', compact('vendor', 'stats', 'recent_leads', 'profile_completion'));
            
        })->name('dashboard');
        
        // Profile Completion - SIMPLE PLACEHOLDER
        Route::get('/profile/complete', function () {
            return 'Profile Completion Form - Under Development';
        })->name('profile.complete');
        
        // Create Listing - SIMPLE PLACEHOLDER
        Route::get('/listings/create', function () {
            return 'Create Listing Form - Under Development';
        })->name('listings.create');
        
        // Listings Index - SIMPLE PLACEHOLDER
        Route::get('/listings', function () {
            return 'My Listings - Under Development';
        })->name('listings.index');
        
        // Leads - SIMPLE PLACEHOLDER
        Route::get('/leads', function () {
            return 'Leads & Messages - Under Development';
        })->name('leads.index');
        
        // Settings - SIMPLE PLACEHOLDER
        Route::get('/settings', function () {
            return 'Settings - Under Development';
        })->name('settings');
    });
    
    // ==================== ADMIN ROUTES ====================
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard Admin - SIMPLE PLACEHOLDER
        Route::get('/dashboard', function () {
            return 'Admin Dashboard - Coming Soon';
        })->name('dashboard');
        
        // Pending Listings - SIMPLE PLACEHOLDER
        Route::get('/listings/pending', function () {
            return 'Pending Listings - Coming Soon';
        })->name('listings.pending');
    });
    
    // Logout
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});

// ==================== PUBLIC LISTINGS ====================
Route::get('/listings', function () {
    return 'Public Listings - Coming Soon';
})->name('listings.public.index');

Route::get('/listings/{listing:slug}', function ($slug) {
    return 'Listing Detail: ' . $slug;
})->name('listings.public.show');

// ==================== VENDOR PUBLIC PROFILE ====================
Route::get('/vendors/{vendor:slug}', function ($slug) {
    return 'Vendor Profile: ' . $slug;
})->name('vendors.public.show');

// Static pages
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

// Catch-all for 404 (must be last)
Route::fallback(function () {
    return view('errors.404');
});