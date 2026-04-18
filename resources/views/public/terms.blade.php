@extends('layouts.public')
@section('seo')
    <x-seo title="JobsNepal — Find Your Dream Job in Nepal"
        description="Browse {{ $totalJobs }}+ active jobs from {{ $totalCompanies }}+ companies in Nepal. Free for job seekers. Apply in seconds." />
@endsection

@section('title', 'Terms of Service — JobsNepal')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-16">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Terms of Service</h1>
    <p class="text-gray-500 dark:text-gray-400 mb-10 text-sm">Last updated: {{ date('F Y') }}</p>

    <div class="space-y-8">

        <section>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                1. Acceptance of Terms
            </h2>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                By using JobsNepal, you agree to these terms. If you do not agree, please do
                not use the platform.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                2. For Employers
            </h2>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                Companies may post genuine job openings only. Misleading or fraudulent listings
                will be removed and the account suspended. Subscription fees are non-refundable
                once a plan is activated.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                3. For Job Seekers
            </h2>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                Job seekers must provide accurate profile information. Applications submitted
                must be genuine. Creating multiple accounts or submitting false information
                will result in account termination.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                4. Limitation of Liability
            </h2>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                JobsNepal is a platform connecting employers and job seekers. We are not
                responsible for hiring decisions, employment outcomes, or disputes between
                employers and candidates.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                5. Contact
            </h2>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                Questions about these terms? Email
                <a href="mailto:legal@jobsnepal.com"
                   class="text-brand-600 dark:text-brand-400 hover:underline">
                    legal@jobsnepal.com
                </a>
            </p>
        </section>

    </div>
</div>
@endsection
