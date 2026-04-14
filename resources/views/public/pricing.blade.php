@extends('layouts.public')
@section('title', 'Pricing — JobsNepal')

@section('content')

{{-- Hero --}}
<section class="bg-gradient-to-br from-brand-700 to-brand-900 text-white py-16 px-4">
    <div class="max-w-3xl mx-auto text-center">
        <h1 class="text-4xl font-bold mb-4">Simple, Transparent Pricing</h1>
        <p class="text-brand-100 text-lg">
            Start free for 14 days. No credit card required.
            Upgrade when you're ready to scale.
        </p>
    </div>
</section>
{{-- Plans --}}
<section class="py-16 px-4 bg-gray-50 dark:bg-gray-950" x-data="{ yearly: false }">
    <div class="max-w-6xl mx-auto">

        {{-- Toggle monthly/yearly --}}
        <div class="flex justify-center mb-10">
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-1 flex gap-1">
                <button @click="yearly = false"
                        :class="!yearly ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-400'"
                        class="px-5 py-2 rounded-lg text-sm font-medium transition-all">
                    Monthly
                </button>
                <button @click="yearly = true"
                        :class="yearly ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-400'"
                        class="px-5 py-2 rounded-lg text-sm font-medium transition-all">
                    Yearly
                    <span class="ml-1.5 text-xs bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 px-1.5 py-0.5 rounded-full font-semibold">
                        Save 2 months
                    </span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                [
                    'name'        => 'Free',
                    'price_mo'    => 0,
                    'price_yr'    => 0,
                    'desc'        => 'Try the platform at no cost',
                    'jobs'        => '3 job postings',
                    'team'        => '1 user',
                    'ats'         => false,
                    'analytics'   => false,
                    'featured'    => false,
                    'cta'         => 'Start Free',
                    'cta_link'    => route('register.company'),
                    'popular'     => false,
                ],
                [
                    'name'        => 'Starter',
                    'price_mo'    => 1500,
                    'price_yr'    => 15000,
                    'desc'        => 'Perfect for small businesses',
                    'jobs'        => '10 job postings',
                    'team'        => '2 users',
                    'ats'         => true,
                    'analytics'   => false,
                    'featured'    => false,
                    'cta'         => 'Get Started',
                    'cta_link'    => route('register.company'),
                    'popular'     => false,
                ],
                [
                    'name'        => 'Professional',
                    'price_mo'    => 3500,
                    'price_yr'    => 35000,
                    'desc'        => 'For growing teams hiring regularly',
                    'jobs'        => 'Unlimited jobs',
                    'team'        => '5 users',
                    'ats'         => true,
                    'analytics'   => true,
                    'featured'    => true,
                    'cta'         => 'Start Free Trial',
                    'cta_link'    => route('register.company'),
                    'popular'     => true,
                ],
                [
                    'name'        => 'Agency',
                    'price_mo'    => 7000,
                    'price_yr'    => 70000,
                    'desc'        => 'For recruitment agencies',
                    'jobs'        => 'Unlimited jobs',
                    'team'        => '20 users',
                    'ats'         => true,
                    'analytics'   => true,
                    'featured'    => true,
                    'cta'         => 'Contact Sales',
                    'cta_link'    => 'mailto:sales@jobsnepal.com',
                    'popular'     => false,
                ],
            ] as $plan)

            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-6 rounded-2xl relative flex flex-col {{ $plan['popular'] ? 'ring-2 ring-blue-500 shadow-lg scale-105 z-10' : '' }}">

                @if($plan['popular'])
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                        <span class="bg-blue-600 text-white text-[10px] uppercase tracking-widest font-bold px-4 py-1 rounded-full shadow-md">
                            Most Popular
                        </span>
                    </div>
                @endif

                <div class="mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $plan['name'] }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $plan['desc'] }}</p>
                </div>

                <div class="mb-6 h-16">
                    <template x-if="!yearly">
                        <div class="flex items-baseline">
                            <span class="text-3xl font-extrabold text-gray-900 dark:text-white">
                                {{ $plan['price_mo'] == 0 ? 'Free' : 'NPR ' . number_format($plan['price_mo']) }}
                            </span>
                            <span x-show="yearly" class="text-gray-500 ml-1 text-sm">/mo</span>
                        </div>
                    </template>
                    <template x-if="yearly">
                        <div class="flex flex-col">
                            <div class="flex items-baseline">
                                <span class="text-3xl font-extrabold text-gray-900 dark:text-white">
                                    {{ $plan['price_yr'] == 0 ? 'Free' : 'NPR ' . number_format($plan['price_yr']) }}
                                </span>
                                <span class="text-gray-500 ml-1 text-sm">/yr</span>
                            </div>
                        </div>
                    </template>
                </div>

                <ul class="space-y-3 mb-8 flex-1">
                    @php
                        $features = [
                            [$plan['jobs'], true],
                            [$plan['team'], true],
                            ['ATS pipeline', $plan['ats']],
                            ['Analytics', $plan['analytics']],
                            ['Featured jobs', $plan['featured']],
                            ['Email support', true],
                            ['14-day free trial', $plan['name'] !== 'Free'],
                        ];
                    @endphp

                    @foreach($features as [$text, $included])
                    <li class="flex items-center gap-3 text-sm {{ $included ? 'text-gray-700 dark:text-gray-300' : 'text-gray-400 dark:text-gray-600' }}">
                        @if($included)
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            <svg class="w-5 h-5 text-gray-300 dark:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        @endif
                        {{ $text }}
                    </li>
                    @endforeach
                </ul>

                <a href="{{ $plan['cta_link'] }}"
                   class="block w-full py-3 px-4 rounded-xl text-center font-semibold transition-all
                   {{ $plan['popular'] ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                    {{ $plan['cta'] }}
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- FAQ --}}
<section class="py-16 px-4 bg-white dark:bg-gray-900">
    <div class="max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-10">
            Frequently Asked Questions
        </h2>
        <div class="space-y-4" x-data="{ open: null }">
            @foreach([
                [
                    'q' => 'Do I need a credit card to start?',
                    'a' => 'No. Your 14-day free trial starts immediately with no credit card required. You only pay when you decide to upgrade.',
                ],
                [
                    'q' => 'How do I pay? Do you accept eSewa?',
                    'a' => 'Yes! We accept eSewa, Khalti, bank transfer, and mobile banking. After payment, upload a screenshot and we activate your plan within 24 hours.',
                ],
                [
                    'q' => 'Can I change my plan later?',
                    'a' => 'Yes. You can upgrade at any time. Contact us and we will prorate the difference.',
                ],
                [
                    'q' => 'What happens when my trial ends?',
                    'a' => 'Your jobs will be paused but your data is safe. Upgrade to reactivate. You will receive reminder emails 7 and 2 days before expiry.',
                ],
                [
                    'q' => 'Can I add team members?',
                    'a' => 'Yes. Starter allows 2 users, Professional allows 5, and Agency allows 20. You can invite team members from your dashboard.',
                ],
                [
                    'q' => 'Is JobsNepal only for Nepal?',
                    'a' => 'The platform is built for Nepali companies but job seekers from anywhere can apply. We plan to expand to South Asian markets in 2025.',
                ],
            ] as $i => $faq)
            <div class="card overflow-hidden">
                <button @click="open = open === {{ $i }} ? null : {{ $i }}"
                        class="w-full flex items-center justify-between px-5 py-4
                               text-left hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    <span class="font-medium text-gray-900 dark:text-white text-sm">
                        {{ $faq['q'] }}
                    </span>
                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0 transition-transform"
                         :class="open === {{ $i }} ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open === {{ $i }}"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="px-5 pb-4 text-sm text-gray-600 dark:text-gray-400 leading-relaxed border-t border-gray-100 dark:border-gray-800 pt-3">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-14 px-4 bg-brand-600 dark:bg-brand-800">
    <div class="max-w-3xl mx-auto text-center text-white">
        <h2 class="text-3xl font-bold mb-4">Start Hiring Today</h2>
        <p class="text-brand-100 mb-8">
            14-day free trial. No credit card. Cancel anytime.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('register.company') }}"
               class="px-8 py-3.5 bg-white text-brand-700 font-semibold rounded-xl hover:bg-brand-50 transition-colors">
                Start Free Trial
            </a>
            <a href="mailto:sales@jobsnepal.com"
               class="px-8 py-3.5 border-2 border-white/60 text-white font-semibold rounded-xl hover:bg-white/10 transition-colors">
                Contact Sales
            </a>
        </div>
    </div>
</section>

@endsection
