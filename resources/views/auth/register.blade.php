@extends('layouts.app')

@section('title', 'Daftar Akun Vendor - WeddingKita')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 to-rose-50 py-8 px-4">
    <div class="max-w-lg mx-auto">

        @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center gap-2 text-red-700 mb-2">
                <i class="fas fa-exclamation-circle"></i>
                <span class="font-medium">Terdapat kesalahan:</span>
            </div>
            <ul class="text-red-600 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li class="flex items-center gap-2">
                        <i class="fas fa-times text-xs"></i>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center gap-2 text-red-700">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <!-- Card - SAMA SEPERTI REFERENSI -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-pink-100">
            <!-- Header -->
            <div class="bg-gradient-to-r from-pink-600 to-rose-600 px-6 py-8 text-center">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-store-alt text-white text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Daftar Akun Vendor</h1>
                <p class="text-pink-100 text-sm">Buat akun dalam 1 menit</p>
            </div>

            <!-- Form --->
            <form method="POST" action="{{ route('register') }}" id="registrationForm" class="p-6">
                @csrf
                <input type="hidden" name="whatsapp" id="whatsappNumber">
                <input type="hidden" name="role" value="vendor">
                
                <!-- Nama Lengkap -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-medium mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"
                        placeholder="Nama Anda" required>
                    <p id="nameError" class="text-sm mt-1 hidden"></p>
                </div>

                <!-- Email -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-medium mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"
                           placeholder="vendor@example.com" required>
                    <p id="emailError" class="text-sm mt-1 hidden"></p>
                </div>

                <!-- WhatsApp - SAMA PERSIS REFERENSI -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-medium mb-2">
                        WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="phoneInput" name="phone" value="{{ old('phone') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"
                           required>
                    <p id="phoneError" class="text-sm mt-1 hidden"></p>
                    <p class="text-gray-500 text-xs mt-2">Pilih negara dari dropdown bendera</p>
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-medium mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition pr-10"
                               placeholder="Minimal 6 karakter" minlength="6" required 
                               autocomplete="new-password">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                        </button>
                    </div>
                    <p id="passwordError" class="text-sm mt-1 hidden"></p>
                </div>

                <!-- Confirm Password -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-medium mb-2">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition pr-10"
                               placeholder="Ulangi password" minlength="6" required 
                               autocomplete="new-password">
                        <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                        </button>
                    </div>
                </div>

                <!-- Terms -->
                <div class="mb-6 p-4 bg-pink-50 rounded-lg border border-pink-100">
                    <label class="flex items-start">
                        <input type="checkbox" id="terms" name="terms" required 
                               class="mt-1 mr-3 rounded text-pink-600 focus:ring-pink-500">
                        <span class="text-gray-700 text-sm">
                            Saya menyetujui <a href="#" class="text-pink-600 font-medium hover:underline">Syarat & Ketentuan</a> Wedding Marketplace.
                        </span>
                    </label>
                    <p id="termsError" class="text-sm mt-2 hidden"></p>
                </div>

                <!-- Submit -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-pink-600 to-rose-600 text-white py-3 rounded-lg font-bold shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    Buat Akun Sekarang
                </button>

                <!-- Login Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-600">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-pink-600 font-medium hover:underline">
                            Login di sini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include intl-tel-input - SAMA SEPERTI REFERENSI -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

<script>
// Initialize intl-tel-input - SAMA PERSIS REFERENSI ANDA
const phoneInputField = document.querySelector("#phoneInput");
const iti = window.intlTelInput(phoneInputField, {
    initialCountry: "id",
    separateDialCode: true,
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
});

console.log('intlTelInput initialized:', iti);

// Password toggle
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordField = document.getElementById('password');
    const icon = this.querySelector('i');
    const type = passwordField.type === 'password' ? 'text' : 'password';
    passwordField.type = type;
    icon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
});

document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
    const confirmField = document.getElementById('password_confirmation');
    const icon = this.querySelector('i');
    const type = confirmField.type === 'password' ? 'text' : 'password';
    confirmField.type = type;
    icon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
});

// Real-time validation - SAMA SEPERTI REFERENSI
const emailEl = document.getElementById('email');
const passwordEl = document.getElementById('password');
const confirmEl = document.getElementById('password_confirmation');
const termsEl = document.getElementById('terms');

// Email validation
emailEl.addEventListener('input', function() {
    const errorEl = document.getElementById('emailError');
    const email = this.value.trim();
    
    if (!email) {
        showError(errorEl, 'Email wajib diisi', 'red');
        return;
    }
    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showError(errorEl, 'Format email tidak valid', 'red');
        return;
    }
    
    showError(errorEl, '✓ Email valid', 'green');
});

// Phone validation
phoneInputField.addEventListener('input', function() {
    const errorEl = document.getElementById('phoneError');
    
    if (!iti.isValidNumber()) {
        showError(errorEl, 'Nomor WhatsApp tidak valid', 'red');
    } else {
        showError(errorEl, '✓ Nomor valid', 'green');
    }
});

// Password validation
passwordEl.addEventListener('input', validatePassword);
confirmEl.addEventListener('input', validatePassword);

function validatePassword() {
    const errorEl = document.getElementById('passwordError');
    const password = passwordEl.value;
    const confirm = confirmEl.value;
    
    if (!password) {
        showError(errorEl, 'Password wajib diisi', 'red');
        return;
    }
    
    if (password.length < 6) {
        showError(errorEl, 'Minimal 6 karakter', 'red');
        return;
    }
    
    // Check for combination of letters and numbers
    const hasLetter = /[a-zA-Z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    
    if (!hasLetter || !hasNumber) {
        showError(errorEl, 'Harus kombinasi huruf dan angka', 'red');
        return;
    }
    
    if (confirm && password !== confirm) {
        showError(errorEl, 'Password tidak cocok', 'red');
        return;
    }
    
    if (password && confirm && password === confirm) {
        showError(errorEl, '✓ Password cocok', 'green');
        return;
    }
    
    showError(errorEl, '✓ Password valid', 'green');
}

// Terms validation
termsEl.addEventListener('change', function() {
    const errorEl = document.getElementById('termsError');
    
    if (!this.checked) {
        showError(errorEl, 'Harus menyetujui syarat & ketentuan', 'red');
    } else {
        showError(errorEl, '✓ Disetujui', 'green');
    }
});

// Form submit
document.getElementById('registrationForm').addEventListener('submit', function(e) {
    // Validasi final
    const password = passwordEl.value;
    const hasLetter = /[a-zA-Z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    
    if (!hasLetter || !hasNumber) {
        e.preventDefault();
        showError(document.getElementById('passwordError'), 'Harus kombinasi huruf dan angka', 'red');
        passwordEl.focus();
        return false;
    }

    // Phone validation
    if (!iti.isValidNumber()) {
        e.preventDefault();
        showError(document.getElementById('phoneError'), 'Nomor WhatsApp tidak valid', 'red');
        phoneInputField.focus();
        return false;
    }
    
    // Password match
    if (passwordEl.value !== confirmEl.value) {
        e.preventDefault();
        showError(document.getElementById('passwordError'), 'Password tidak cocok', 'red');
        passwordEl.focus();
        return false;
    }
    
    // Terms check
    if (!termsEl.checked) {
        e.preventDefault();
        showError(document.getElementById('termsError'), 'Harus menyetujui syarat & ketentuan', 'red');
        return false;
    }
    
    // Format WhatsApp number untuk backend (628xxxxxxxxxx)
    const fullNumber = iti.getNumber();
    console.log('Full number:', fullNumber);
    
    let whatsappNumber = fullNumber.replace(/\D/g, ''); // Remove all non-digits
    
    // Remove leading 0 if exists
    if (whatsappNumber.startsWith('0')) {
        whatsappNumber = whatsappNumber.substring(1);
    }
    
    // Ensure starts with 62
    if (!whatsappNumber.startsWith('62')) {
        whatsappNumber = '62' + whatsappNumber;
    }
    
    console.log('Formatted WhatsApp:', whatsappNumber);
    document.getElementById('whatsappNumber').value = whatsappNumber;
});

// Helper function - SAMA SEPERTI REFERENSI
function showError(element, message, color) {
    if (!element) return;
    
    element.textContent = message;
    element.className = `text-sm mt-1 ${color === 'green' ? 'text-green-600' : 'text-red-600'}`;
    element.style.display = 'block';
}
</script>
@endsection