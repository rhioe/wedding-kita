<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Vendor\ListingController;
use App\Http\Controllers\Admin\ListingController as AdminListingController;
// Tambahkan ini
use App\Http\Controllers\Admin\AdminController;

// ==================== PUBLIC ROUTES ====================
Route::get('/', function () {
    return view('home');
})->name('home');

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
        // ... existing vendor routes (tetap sama) ...
        // Dashboard
        Route::get('/dashboard', function () {
            $user = auth()->user();
            $vendor = $user->vendor;
            
            if (!$vendor) {
                $vendor = \App\Models\Vendor::create([
                    'user_id' => $user->id,
                    'business_name' => $user->name,
                    'slug' => \Str::slug($user->name) . '-' . uniqid(),
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
            Route::get('/', [ListingController::class, 'index'])->name('index');
            
            // ✅ FIX: PAKAI VIEW, BUKAN LANGSUNG KE LIVEWIRE
            Route::get('/create', function () {
                return view('vendor.listings.create');
            })->name('create');
            
            // Edit, Delete, etc bisa ditambah nanti
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

// ==================== PUBLIC LISTING ROUTES ====================
Route::get('/listings', function () {
    return 'Public Listings - Coming Soon';
})->name('listings.public.index');

Route::get('/listings/{listing:slug}', function ($slug) {
    return 'Listing Detail: ' . $slug;
})->name('listings.public.show');

// ==================== PUBLIC VENDOR ROUTES ====================
Route::get('/vendors/{vendor:slug}', function ($slug) {
    return 'Vendor Profile: ' . $slug;
})->name('vendors.public.show');

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
// ⚠️ COMMENT/HAPUS DI PRODUCTION
if (app()->environment('local', 'development')) {
    Route::middleware('auth')->group(function () {
        Route::get('/test-upload', function() {
            return view('test-upload');
        })->name('test.upload');
        
        Route::post('/test-upload-handle', function(\Illuminate\Http\Request $request) {
            $data = [
                'total_files' => count($request->file('photos') ?? []),
                'files' => [],
            ];
            
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $file) {
                    $data['files'][] = [
                        'index' => $index,
                        'name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'mime' => $file->getMimeType(),
                    ];
                }
            }
            
            return response()->json($data);
        })->name('test.upload.handle');
    });
}

// ==================== 404 CATCH-ALL ====================
Route::fallback(function () {
    return view('errors.404');
});