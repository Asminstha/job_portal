@extends('layouts.public')
@section('title', 'Access Denied')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-20">
    <div class="text-center max-w-md">
        <div class="text-8xl font-bold text-gray-200 dark:text-gray-800 mb-6 select-none">
            403
        </div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">
            Access denied
        </h1>
        <p class="text-gray-500 dark:text-gray-400 mb-8 leading-relaxed">
            You don't have permission to access this page.
            Please log in with an account that has the required access.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('login') }}" class="btn-primary px-6">
                Sign In
            </a>
            <a href="{{ route('home') }}" class="btn-secondary px-6">
                Go Home
            </a>
        </div>
    </div>
</div>
@endsection
