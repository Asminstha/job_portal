@extends('layouts.public')
@section('title', 'Create Job Seeker Account')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create your account</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                Find your dream job — always free for job seekers
            </p>
        </div>

        <div class="card p-8">
            <form method="POST" action="{{ route('register.seeker.post') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="form-label">Full name <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name') }}"
                           class="form-input @error('name') border-red-500 @enderror"
                           placeholder="Ram Bahadur Thapa"
                           autofocus>
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="form-label">Email address <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           class="form-input @error('email') border-red-500 @enderror"
                           placeholder="you@gmail.com">
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="form-label">Phone number</label>
                    <input type="text" id="phone" name="phone"
                           value="{{ old('phone') }}"
                           class="form-input"
                           placeholder="+977 98XXXXXXXX">
                </div>

                <div>
                    <label for="password" class="form-label">Password <span class="text-red-500">*</span></label>
                    <div x-data="{ show: false }" class="relative">
                        <input :type="show ? 'text' : 'password'"
                               id="password" name="password"
                               class="form-input pr-10 @error('password') border-red-500 @enderror"
                               placeholder="Minimum 8 characters">
                        <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="form-label">Confirm password <span class="text-red-500">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="form-input"
                           placeholder="Repeat your password">
                </div>

                <button type="submit" class="btn-primary w-full justify-center py-3 text-base">
                    Create Free Account
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-5">
            Already have an account?
            <a href="{{ route('login') }}" class="text-brand-600 dark:text-brand-400 font-medium hover:underline">Sign in</a>
        </p>
    </div>
</div>
@endsection
