<?php

// app\Http\Controllers\Vendor\ListingController.php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    /**
     * Show step 1 form - Business Information
     */
    public function createStep1()
    {
        $categories = [
            'Fotografer',
            'Venue',
            'Catering',
            'Makeup Artist',
            'Undangan',
            'Dekorasi',
            'Sewa Busana',
            'Wedding Organizer',
            'Entertainment',
            'Katering',
            'Videografer',
            'Lainnya',
        ];

        return view('vendor.listings.create-step1', compact('categories'));
    }

    /**
     * Store step 1 data in session
     */
    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|min:3|max:100',
            'category' => 'required|string',
            'location' => 'required|string|min:3',
            'description' => 'required|min:50|max:2000',
            'year_established' => 'nullable|integer|min:1900|max:'.date('Y'),
            'whatsapp_number' => 'required|string|min:10',
            'instagram' => 'nullable|string',
            'website' => 'nullable|url',
        ]);

        // Store in session for multi-step form
        session(['listing_step1' => $validated]);

        return redirect()->route('vendor.listings.create.step2');
    }

    /**
     * Show step 2 form - Photos
     */
    public function createStep2()
    {
        // Check if step 1 data exists
        if (! session()->has('listing_step1')) {
            return redirect()->route('vendor.listings.create.step1');
        }

        return view('vendor.listings.create-step2');
    }

    /**
     * Store step 2 data (photos) in session
     */
    public function storeStep2(Request $request)
    {
        $request->validate([
            'photos' => 'required|array|min:1|max:20',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'thumbnail_index' => 'required|integer|min:0',
        ]);

        // Store photo info in session (will handle actual upload in final step)
        session([
            'listing_photos' => $request->file('photos'),
            'listing_thumbnail_index' => $request->thumbnail_index,
        ]);

        return redirect()->route('vendor.listings.create.step3');
    }

    /**
     * Show step 3 form - Package & Pricing
     */
    public function createStep3()
    {
        // Check if step 2 data exists
        if (! session()->has('listing_photos')) {
            return redirect()->route('vendor.listings.create.step1');
        }

        return view('vendor.listings.create-step3');
    }

    /**
     * Store step 3 data in session
     */
    public function storeStep3(Request $request)
    {
        $validated = $request->validate([
            'package_name' => 'required|min:3|max:100',
            'price' => 'required|numeric|min:1000',
            'package_description' => 'nullable|string|max:1000',
            'validity_period' => 'nullable|string|max:50',
            'terms_accepted' => 'required|accepted',
        ]);

        // Format price (remove dots, commas)
        $validated['price'] = str_replace(['.', ','], '', $validated['price']);

        session(['listing_step3' => $validated]);

        return redirect()->route('vendor.listings.create.step4');
    }

    /**
     * Show step 4 form - Confirmation
     */
    public function createStep4()
    {
        // Check if all previous steps completed
        if (! session()->has('listing_step1') ||
            ! session()->has('listing_photos') ||
            ! session()->has('listing_step3')) {
            return redirect()->route('vendor.listings.create.step1');
        }

        $data = [
            'step1' => session('listing_step1'),
            'photos' => session('listing_photos'),
            'thumbnail_index' => session('listing_thumbnail_index', 0),
            'step3' => session('listing_step3'),
        ];

        return view('vendor.listings.create-step4', $data);
    }

    /**
     * Store final listing to database
     */
    public function store(Request $request)
    {
        // Final validation
        if (! session()->has('listing_step1') ||
            ! session()->has('listing_photos') ||
            ! session()->has('listing_step3')) {
            return redirect()->route('vendor.listings.create.step1')
                ->with('error', 'Session expired. Please start over.');
        }

        try {
            // Get vendor ID
            $vendor = Auth::user()->vendor;

            if (! $vendor) {
                return redirect()->route('vendor.dashboard')
                    ->with('error', 'Vendor profile not found. Please complete your profile first.');
            }

            // Upload photos and get paths
            $photoPaths = [];
            $photos = session('listing_photos');

            foreach ($photos as $photo) {
                $path = $photo->store('listings/photos', 'public');
                $photoPaths[] = $path;
            }

            // Create listing
            $listing = Listing::create([
                'vendor_id' => $vendor->id,
                'title' => session('listing_step3.package_name'),
                'category' => session('listing_step1.category'),
                'description' => session('listing_step1.description'),
                'price' => session('listing_step3.price'),
                'location' => session('listing_step1.location'),
                'photos' => json_encode($photoPaths),
                'thumbnail_index' => session('listing_thumbnail_index', 0),
                'whatsapp_number' => session('listing_step1.whatsapp_number'),
                'instagram' => session('listing_step1.instagram'),
                'website' => session('listing_step1.website'),
                'year_established' => session('listing_step1.year_established'),
                'validity_period' => session('listing_step3.validity_period'),
                'package_description' => session('listing_step3.package_description'),
                'status' => 'pending',
            ]);

            // Clear session data
            session()->forget([
                'listing_step1',
                'listing_photos',
                'listing_thumbnail_index',
                'listing_step3',
            ]);

            return redirect()->route('vendor.dashboard')
                ->with('success', 'Listing created successfully! It will be reviewed by admin.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating listing: '.$e->getMessage());
        }
    }
}
