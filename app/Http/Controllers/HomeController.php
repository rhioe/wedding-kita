<?php

// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the wedding marketplace homepage
     *
     * Layer 1: Wireframe Structure
     * Layer 2: Visual Style (via Blade/Tailwind)
     * Layer 3: Tech Stack (Livewire ready)
     * Layer 4: UX Behavior (infinite scroll ready)
     * Layer 5: Performance (optimized queries)
     */
    public function index(Request $request)
    {
        // Layer 5: Performance - Optimized queries dengan eager loading
        $featuredListings = Listing::with(['vendor', 'category', 'photos'])
            ->where('status', 'approved')
            ->whereNotNull('published_at')
            ->where('is_featured', true)
            ->orderBy('published_at', 'desc')
            ->take(8) // Mobile optimal: 8 items
            ->get();

        $popularListings = Listing::with(['vendor', 'category', 'photos'])
            ->where('status', 'approved')
            ->whereNotNull('published_at')
            ->orderBy('views_count', 'desc')
            ->take(12) // Desktop optimal: 12 items
            ->get();

        // Layer 1: Wireframe - Data untuk quick categories
        $categories = Category::all();

        // Layer 4: UX - Prepare untuk infinite scroll
        $totalListings = Listing::published()->count();
        $perPage = 12; // Untuk infinite scroll batch size

        return view('home', compact(
            'featuredListings',
            'popularListings',
            'categories',
            'totalListings',
            'perPage'
        ));
    }

    /**
     * Display listing detail page
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function showListing($slug)
    {
        $listing = Listing::with(['vendor', 'category', 'photos'])
            ->where('slug', $slug)
            ->where('status', 'approved')
            ->whereNotNull('published_at')
            ->firstOrFail();

        // Layer 4: UX - Increment views count
        $listing->incrementViews();

        return view('listings.show', compact('listing'));
    }

    /**
     * Display all listings (browse page)
     *
     * @return \Illuminate\View\View
     */
    public function browse(Request $request)
    {
        // Layer 3: Tech - Query builder untuk filter
        $query = Listing::with(['vendor', 'category', 'photos'])
            ->where('status', 'approved')
            ->whereNotNull('published_at');

        // Filter by category
        if ($request->has('category') && $request->category != 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Filter by location
        if ($request->has('location') && ! empty($request->location)) {
            $query->where('location', 'like', '%'.$request->location.'%');
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort options
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('views_count', 'desc');
                break;
            default: // newest
                $query->orderBy('published_at', 'desc');
        }

        // Layer 4: UX - Pagination untuk performance
        $listings = $query->paginate(12);

        $categories = Category::all();

        return view('listings.index', compact('listings', 'categories'));
    }

    /**
     * Handle WhatsApp contact click
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contact(Request $request, $id)
    {
        $listing = Listing::findOrFail($id);

        // Increment WhatsApp clicks
        $listing->incrementWhatsAppClicks();

        // WhatsApp message template
        $message = urlencode(
            'Halo '.($listing->vendor->business_name ?? 'Vendor').",\n".
            "Saya lihat listing Anda di WeddingKita:\n".
            $listing->title."\n".
            "Bisa konsultasi lebih lanjut?\n\n".
            'Ref: WK-'.$listing->id.'-'.time()
        );

        // Pastikan nomor WhatsApp ada
        $whatsappNumber = $listing->whatsapp_number ?? $listing->vendor->whatsapp_number ?? '6281234567890';
        $whatsappNumber = preg_replace('/[^0-9]/', '', $whatsappNumber); // Hapus karakter non-digit

        $whatsappUrl = 'https://wa.me/'.$whatsappNumber.'?text='.$message;

        return redirect()->away($whatsappUrl);
    }
}
