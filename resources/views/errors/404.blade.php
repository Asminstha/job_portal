@extends('layouts.public')
@section('title', 'Page Not Found')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-20">
    <div class="text-center max-w-md">
        <div class="text-8xl font-bold text-gray-200 dark:text-gray-800 mb-6 select-none">
            404
        </div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">
            Page not found
        </h1>
        <p class="text-gray-500 dark:text-gray-400 mb-8 leading-relaxed">
            The page you're looking for doesn't exist or has been moved.
            Let's get you back on track.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('home') }}" class="btn-primary px-6">
                Go to Homepage
            </a>
            <a href="{{ route('jobs.index') }}" class="btn-secondary px-6">
                Browse Jobs
            </a>
        </div>
    </div>
</div>
@endsection
