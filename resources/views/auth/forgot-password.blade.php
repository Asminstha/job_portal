@extends('layouts.public')
@section('title', 'Forgot Password')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12
                        bg-brand-100 dark:bg-brand-900 rounded-xl mb-4">
                <svg class="w-6 h-6 text-brand-600 dark:text-brand-400"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1
                             1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Forgot your password?
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">
                Enter your email and we'll send you a reset link.
            </p>
        </div>

        <div class="card p-8">
            @if(session('success'))
                <div class="mb-5 p-4 bg-green-50 dark:bg-green-900/30 border
                            border-green-200 dark:border-green-700 rounded-lg">
                    <p class="text-sm text-green-800 dark:text-green-200">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           class="form-input @error('email') border-red-500 @enderror"
                           placeholder="you@company.com" autofocus>
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary w-full justify-center py-2.5">
                    Send Reset Link
                </button>
            </form>

            <div class="mt-5 text-center text-sm text-gray-500 dark:text-gray-400">
                Remember your password?
                <a href="{{ route('login') }}"
                   class="text-brand-600 dark:text-brand-400 font-medium hover:underline">
                    Sign in
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
