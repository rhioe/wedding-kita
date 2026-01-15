<?php

// routes/web.php

use App\Http\Controllers\Admin\ListingController as AdminListingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Vendor\ListingController as VendorListingController;
use Illuminate\Support\Facades\Route;

// ==================== PUBLIC ROUTES ====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/listings', [HomeController::class, 'browse'])->name('listings.index');
Route::get('/listings/{slug}', [HomeController::class, 'showListing'])->name('listings.show');
Route::get('/contact/{id}', [HomeController::class, 'contact'])->name('listings.contact');

Route::get('/test', function () {
    return 'WeddingKita API is working!';
});

// ==================== GUEST ROUTES (Not Logged In) ====================
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// ==================== AUTHENTICATED ROUTES (Logged In) ====================
Route::middleware('auth')->group(function () {
    // Dashboard - redirect berdasarkan role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

    // ==================== VENDOR ROUTES ====================
    Route::middleware('role:vendor')->prefix('vendor')->name('vendor.')->group(function () {
        // Dashboard
        Route::get('/dashboard', function () {
            $user = auth()->user();
            $vendor = $user->vendor;

            if (! $vendor) {
                $vendor = \App\Models\Vendor::create([
                    'user_id' => $user->id,
                    'business_name' => $user->name,
                    'slug' => \Str::slug($user->name).'-'.uniqid(),
                    'status' => 'pending',
                    'description' => 'Vendor baru WeddingKita',
                    'location' => 'Indonesia',
                ]);
            }

            $stats = [
                'total_listings' => $vendor->listings()->count() ?? 0,
                'total_leads' => 0,
            ];

            $recent_leads = [];
            $profile_completion = 40;

            return view('vendor.dashboard', compact('vendor', 'stats', 'recent_leads', 'profile_completion'));
        })->name('dashboard');

        // Profile Completion
        Route::get('/profile/complete', function () {
            return view('vendor.profile.complete');
        })->name('profile.complete');

        // ===== LISTINGS ROUTES =====
        Route::prefix('listings')->name('listings.')->group(function () {
            // Index
            Route::get('/', [VendorListingController::class, 'index'])->name('index');

            // Create listing view
            Route::get('/create', function () {
                return view('vendor.listings.create');
            })->name('create');
        });

        // Leads (Placeholder)
        Route::get('/leads', function () {
            return 'Leads & Messages - Under Development';
        })->name('leads.index');

        // Settings (Placeholder)
        Route::get('/settings', function () {
            return 'Settings - Under Development';
        })->name('settings');
    });

    // ==================== ADMIN ROUTES ====================
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Listings Management
        Route::prefix('listings')->name('listings.')->group(function () {
            // Pending listings
            Route::get('/pending', [AdminListingController::class, 'pending'])->name('pending');

            // Review listing
            Route::get('/review/{id}', [AdminListingController::class, 'review'])->name('review');

            // Approve listing
            Route::post('/approve/{id}', [AdminListingController::class, 'approve'])->name('approve');

            // Reject listing
            Route::post('/reject/{id}', [AdminListingController::class, 'reject'])->name('reject');

            // API untuk count pending (untuk badge di sidebar)
            Route::get('/pending-count', function () {
                $count = \App\Models\Listing::where('status', 'pending')->count();

                return response()->json(['count' => $count]);
            })->name('pending-count');
        });
    });

    // Logout
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});

// ==================== STATIC PAGES ====================
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

// ==================== DEVELOPMENT TEST ROUTES ====================

// ==================== SEARCH LIVEWIRE ROUTES ====================
Route::get('/search', function () {
    return view('search-page');
})->name('search.page');

// ==================== 404 CATCH-ALL ====================
Route::fallback(function () {
    return view('errors.404');
});
