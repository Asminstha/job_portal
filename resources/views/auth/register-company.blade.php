@extends('layouts.public')
@section('title', 'Register Your Company')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-lg">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Register your company</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                Start your 14-day free trial. No credit card required.
            </p>
        </div>

        <div class="card p-8">
            <form method="POST" action="{{ route('register.company.post') }}" class="space-y-5">
                @csrf

                {{-- Company Info --}}
                <div class="pb-4 border-b border-gray-100 dark:border-gray-800">
                    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide mb-4">
                        Company Information
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <label for="company_name" class="form-label">Company name <span class="text-red-500">*</span></label>
                            <input type="text" id="company_name" name="company_name"
                                   value="{{ old('company_name') }}"
                                   class="form-input @error('company_name') border-red-500 @enderror"
                                   placeholder="Fusemachines Nepal Pvt. Ltd.">
                            @error('company_name') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="industry" class="form-label">Industry <span class="text-red-500">*</span></label>
                            <select id="industry" name="industry"
                                    class="form-input @error('industry') border-red-500 @enderror">
                                <option value="">Select industry</option>
                                @foreach(['Information Technology','Software Development','BPO / KPO','Banking & Finance','Healthcare','Education & Training','Media & Communications','E-Commerce','Manufacturing','Hospitality','Others'] as $ind)
                                    <option value="{{ $ind }}" {{ old('industry') === $ind ? 'selected' : '' }}>{{ $ind }}</option>
                                @endforeach
                            </select>
                            @error('industry') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Admin Info --}}
                <div>
                    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide mb-4">
                        Your Account
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="form-label">Your full name <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name"
                                   value="{{ old('name') }}"
                                   class="form-input @error('name') border-red-500 @enderror"
                                   placeholder="Ram Sharma">
                            @error('name') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="form-label">Work email <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email') }}"
                                   class="form-input @error('email') border-red-500 @enderror"
                                   placeholder="hr@company.com">
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
                            <input type="password" id="password" name="password"
                                   class="form-input @error('password') border-red-500 @enderror"
                                   placeholder="Minimum 8 characters">
                            @error('password') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="form-label">Confirm password <span class="text-red-500">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-input"
                                   placeholder="Repeat your password">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full justify-center py-3 text-base">
                    Start Free Trial
                </button>

                <p class="text-center text-xs text-gray-400 dark:text-gray-500">
                    By registering you agree to our Terms of Service and Privacy Policy.
                </p>
            </form>
        </div>

        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-5">
            Already have an account?
            <a href="{{ route('login') }}" class="text-brand-600 dark:text-brand-400 font-medium hover:underline">Sign in</a>
        </p>
    </div>
</div>
@endsection
