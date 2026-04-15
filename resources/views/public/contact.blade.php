@extends('layouts.public')

@section('seo')
    <x-seo title="Contact Us — JobsNepal"
        description="Get in touch with the JobsNepal team. We are here to help with any questions about job posting, pricing, or technical support." />
@endsection

@section('content')
    {{-- Hero --}}
    <section class="bg-gradient-to-br from-brand-700 to-brand-900 text-white py-14 px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-3xl font-bold mb-3">Get in Touch</h1>
            <p class="text-brand-100">
                Have a question? We'd love to hear from you.
                Send us a message and we'll respond within 24 hours.
            </p>
        </div>
    </section>

    <section class="py-14 px-4 bg-gray-50 dark:bg-gray-950">
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Contact info cards --}}
                <div class="space-y-4">

                    <div class="card p-5">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-brand-100 dark:bg-brand-900 rounded-xl
                                    flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0
                                             002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Email Us</h3>
                                <a href="mailto:hello@jobsnepal.com"
                                    class="text-brand-600 dark:text-brand-400 text-sm hover:underline">
                                    hello@jobsnepal.com
                                </a>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    General inquiries
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card p-5">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-xl
                                    flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1
                                             0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1
                                             1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2
                                             2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Call Us</h3>
                                <p class="text-brand-600 dark:text-brand-400 text-sm">+977 01-XXXXXXX</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    Sun–Fri, 10am–6pm NPT
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card p-5">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-xl
                                    flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827
                                             0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Office</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Baneshwor, Kathmandu<br>Bagmati Province, Nepal
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card p-5">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-amber-100 dark:bg-amber-900 rounded-xl
                                    flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3
                                             2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0
                                             1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9
                                             0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm">
                                    Billing Support
                                </h3>
                                <a href="mailto:billing@jobsnepal.com"
                                    class="text-brand-600 dark:text-brand-400 text-sm hover:underline">
                                    billing@jobsnepal.com
                                </a>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    Plans, payments, invoices
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Contact form --}}
                <div class="lg:col-span-2">
                    <div class="card p-8">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">
                            Send us a Message
                        </h2>

                        @if (session('success'))
                            <div
                                class="mb-6 p-4 bg-green-50 dark:bg-green-900/30
                                    border border-green-200 dark:border-green-700 rounded-xl">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1
                                                 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0
                                                 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                        {{ session('success') }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.send') }}" x-data="{ submitting: false }"
                            @submit="submitting = true" class="space-y-5">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="form-label">
                                        Your Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-input @error('name') border-red-500 @enderror" placeholder="Ram Sharma">
                                    @error('name')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="form-label">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-input @error('email') border-red-500 @enderror"
                                        placeholder="you@example.com">
                                    @error('email')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Phone (optional) --}}
                            <div>
                                <label class="form-label">
                                    Phone Number
                                    <span class="text-gray-400 dark:text-gray-500 font-normal text-xs ml-1">
                                        (optional)
                                    </span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0
                             01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1
                             1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2
                             2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <input type="tel" name="phone" value="{{ old('phone') }}"
                                        class="form-input pl-10 @error('phone') border-red-500 @enderror"
                                        placeholder="+977 98XXXXXXXX">
                                </div>
                                @error('phone')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                    We may call you if your query is urgent
                                </p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="form-label">
                                        Topic <span class="text-red-500">*</span>
                                    </label>
                                    <select name="type" class="form-input @error('type') border-red-500 @enderror">
                                        <option value="">Select topic</option>
                                        <option value="general" {{ old('type') === 'general' ? 'selected' : '' }}>
                                            General Inquiry
                                        </option>
                                        <option value="billing" {{ old('type') === 'billing' ? 'selected' : '' }}>
                                            Billing & Payments
                                        </option>
                                        <option value="support" {{ old('type') === 'support' ? 'selected' : '' }}>
                                            Technical Support
                                        </option>
                                        <option value="partnership" {{ old('type') === 'partnership' ? 'selected' : '' }}>
                                            Partnership
                                        </option>
                                    </select>
                                    @error('type')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="form-label">
                                        Subject <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="subject" value="{{ old('subject') }}"
                                        class="form-input @error('subject') border-red-500 @enderror"
                                        placeholder="How can we help?">
                                    @error('subject')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="form-label">
                                    Message <span class="text-red-500">*</span>
                                </label>
                                <textarea name="message" rows="6" class="form-input resize-y @error('message') border-red-500 @enderror"
                                    placeholder="Tell us more about your question or issue...">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" :disabled="submitting"
                                class="btn-primary px-8 py-3 disabled:opacity-60
                                       disabled:cursor-not-allowed">
                                <span x-show="!submitting">Send Message</span>
                                <span x-show="submitting" x-cloak>Sending...</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
