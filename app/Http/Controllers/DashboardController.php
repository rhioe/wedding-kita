<?php
// app/Http\Controllers\DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Redirect user to appropriate dashboard based on role
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Redirect based on user role
        switch($user->role) {
            case 'vendor':
                // Vendor dashboard
                return redirect()->route('vendor.dashboard');
                
            case 'admin':
                // Admin dashboard - DIRECT REDIRECT
                return redirect()->route('admin.dashboard');
                
            default:
                // Regular user dashboard
                return view('dashboard.index');
        }
    }
}