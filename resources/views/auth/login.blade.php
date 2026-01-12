{{-- resources\views\auth\login.blade.php --}}

@extends('layouts.app')

@section('title', 'Login - WeddingKita')

@section('content')
<div class="min-h-[calc(100vh-200px)] flex items-center justify-center py-12">
    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                <i class="fas fa-lock text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-3">Welcome Back</h1>
            <p class="text-gray-600">Sign in to your WeddingKita account</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="space-y-6">
                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-gray-500"></i>
                            Email Address
                        </label>
                        <input type="email" name="email" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-colors"
                               placeholder="you@example.com">
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-gray-500"></i>
                            Password
                        </label>
                        <input type="password" name="password" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-colors"
                               placeholder="••••••••">
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" 
                                   class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                            <label for="remember" class="ml-2 text-sm text-gray-600">
                                Remember me
                            </label>
                        </div>
                        <a href="#" class="text-sm text-pink-600 hover:text-pink-700 font-medium">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Submit -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-pink-600 to-rose-600 text-white py-3.5 rounded-lg font-bold hover:opacity-90 transition-all shadow-lg hover:shadow-xl">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Sign In
                    </button>

                    <!-- Divider -->
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500">or continue with</span>
                        </div>
                    </div>

                    <!-- Social Login -->
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" 
                                class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="fab fa-google text-red-500"></i>
                            <span class="font-medium">Google</span>
                        </button>
                        <button type="button" 
                                class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="fab fa-facebook text-blue-500"></i>
                            <span class="font-medium">Facebook</span>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Register Link -->
            <div class="mt-8 pt-8 border-t text-center">
                <p class="text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-pink-600 font-medium hover:text-pink-700">
                        <i class="fas fa-user-plus mr-1"></i>
                        Create account
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection