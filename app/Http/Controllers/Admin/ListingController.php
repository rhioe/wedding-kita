<?php
// app/Http/Controllers/Admin/ListingController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    /**
     * Display pending listings
     */
    public function pending(Request $request)
    {
        $query = Listing::with(['vendor.user', 'category', 'photos'])
            ->where('status', 'pending');
        
        // Search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('business_name', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%')
                  ->orWhereHas('vendor', function ($q) use ($search) {
                      $q->where('business_name', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('category', function ($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
            });
        }
        
        // Category filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
        // Sort
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'price_low':
                $query->orderBy('price');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
        }
        
        $listings = $query->paginate(10);
        $categories = Category::orderBy('name')->get();
        
        return view('admin.listings.pending', compact('listings', 'categories'));
    }
    
    /**
     * Show listing for review
     */
    public function review($id)
    {
        $listing = Listing::with(['vendor.user', 'category', 'photos'])
            ->findOrFail($id);
        
        // Ensure listing is pending
        if ($listing->status !== 'pending') {
            return redirect()->route('admin.listings.pending')
                ->with('error', 'This listing has already been reviewed.');
        }
        
        return view('admin.listings.review', compact('listing'));
    }
    
    /**
     * Approve a listing
     */
    public function approve($id)
    {
        $listing = Listing::findOrFail($id);
        
        // Validate status
        if ($listing->status !== 'pending') {
            return back()->with('error', 'This listing has already been reviewed.');
        }
        
        $listing->update(['status' => 'approved']);
        
        // TODO: Send notification to vendor
        
        return redirect()->route('admin.listings.pending')
            ->with('success', "Listing '{$listing->title}' has been approved!");
    }
    
    /**
     * Reject a listing
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);
        
        $listing = Listing::findOrFail($id);
        
        // Validate status
        if ($listing->status !== 'pending') {
            return back()->with('error', 'This listing has already been reviewed.');
        }
        
        $listing->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason
        ]);
        
        // TODO: Send notification to vendor with reason
        
        return redirect()->route('admin.listings.pending')
            ->with('warning', "Listing '{$listing->title}' has been rejected.");
    }
}