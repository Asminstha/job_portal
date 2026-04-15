@extends('layouts.public')
@section('title', 'Privacy Policy — JobsNepal')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-16">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Privacy Policy</h1>
    <p class="text-gray-500 dark:text-gray-400 mb-10 text-sm">Last updated: {{ date('F Y') }}</p>

    <div class="prose prose-gray dark:prose-invert max-w-none space-y-8">

        <section>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                1. Information We Collect
            </h2>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                We collect information you provide directly to us when creating an account,
                posting jobs, or applying for positions. This includes your name, email address,
                phone number, professional profile information, and resume or CV documents.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                2. How We Use Your Information
            </h2>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                We use the information we collect to operate the platform, connect job seekers
                with employers, send notifications about applications, and improve our services.
                We do not sell your personal information to third parties.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                3. Data Security
            </h2>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                We implement industry-standard security measures to protect your information.
                All data is transmitted over HTTPS and stored securely in our database.
                Passwords are hashed and never stored in plain text.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                4. Contact
            </h2>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                For privacy-related questions, contact us at
                <a href="mailto:privacy@jobsnepal.com"
                   class="text-brand-600 dark:text-brand-400 hover:underline">
                    privacy@jobsnepal.com
                </a>
            </p>
        </section>

    </div>
</div>
@endsection
