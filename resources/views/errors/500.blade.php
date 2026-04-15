@extends('layouts.public')
@section('title', 'Server Error')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-20">
    <div class="text-center max-w-md">
        <div class="text-8xl font-bold text-gray-200 dark:text-gray-800 mb-6 select-none">
            500
        </div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">
            Something went wrong
        </h1>
        <p class="text-gray-500 dark:text-gray-400 mb-8 leading-relaxed">
            We're experiencing a technical issue. Our team has been notified.
            Please try again in a few minutes.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('home') }}" class="btn-primary px-6">
                Go to Homepage
            </a>
            <a href="{{ route('contact') }}" class="btn-secondary px-6">
                Contact Support
            </a>
        </div>
    </div>
</div>
@endsection
