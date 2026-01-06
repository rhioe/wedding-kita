<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    // Validasi dengan pesan bahasa Indonesia - SIMPLIFIED
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255|min:2',
        'email' => 'required|string|email|max:255|unique:users',
        'whatsapp' => 'required|string|regex:/^62\d{9,12}$/|unique:users',
        'password' => [
            'required',
            'string',
            'min:6',
            'confirmed',
            function ($attribute, $value, $fail) {
                if (!preg_match('/[a-zA-Z]/', $value) || !preg_match('/[0-9]/', $value)) {
                    $fail('Password harus mengandung huruf dan angka.');
                }
            },
        ],
        'terms' => 'required|accepted',
        'role' => 'required|in:vendor',
    ], [
        'name.required' => 'Nama lengkap wajib diisi.',
        'name.min' => 'Nama minimal 2 karakter.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain.',
        'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
        'whatsapp.regex' => 'Format WhatsApp tidak valid. Gunakan format 628xxxx.',
        'whatsapp.unique' => 'Nomor WhatsApp sudah terdaftar. Silakan gunakan nomor lain.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
        'terms.required' => 'Anda harus menyetujui syarat dan ketentuan.',
        'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('error', 'Terdapat kesalahan dalam pengisian form.');
    }

    // Pastikan format WhatsApp benar
    $whatsapp = $request->whatsapp;
    
    // Hapus semua karakter non-digit
    $whatsapp = preg_replace('/\D/', '', $whatsapp);
    
    // Jika masih ada + di depan, hapus
    if (str_starts_with($whatsapp, '+')) {
        $whatsapp = substr($whatsapp, 1);
    }
    
    // Pastikan dimulai dengan 62 (tanpa 0)
    if (str_starts_with($whatsapp, '0')) {
        $whatsapp = '62' . substr($whatsapp, 1);
    } elseif (!str_starts_with($whatsapp, '62')) {
        $whatsapp = '62' . $whatsapp;
    }

    // Cek duplikat lagi untuk safety
    $existingEmail = User::where('email', $request->email)->first();
    if ($existingEmail) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Email sudah terdaftar. Silakan gunakan email lain.');
    }

    $existingWhatsapp = User::where('whatsapp', $whatsapp)->first();
    if ($existingWhatsapp) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Nomor WhatsApp sudah terdaftar. Silakan gunakan nomor lain.');
    }

    // Mulai transaction untuk rollback jika ada error
    try {
        // Buat user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $whatsapp,
            'phone' => $whatsapp,
            'role' => 'vendor',
            'password' => Hash::make($request->password),
        ]);

        // Buat profil vendor
        $vendor = Vendor::create([
            'user_id' => $user->id,
            'business_name' => $request->name,
            'slug' => \Str::slug($request->name) . '-' . uniqid(),
            'status' => 'pending',
            'description' => 'Vendor baru WeddingKita',
            'location' => 'Indonesia',
        ]);

        Auth::login($user);
        
        return redirect()->route('dashboard')
            ->with('success', 'Pendaftaran berhasil! Silakan lengkapi profil vendor Anda.');

    } catch (\Exception $e) {
        // Jika ada error, hapus user yang sudah dibuat (rollback)
        if (isset($user)) {
            $user->delete();
        }
        
        \Log::error('Registration failed: ' . $e->getMessage());
        
        return redirect()->back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
    }
}
}