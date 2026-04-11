@extends('layouts.public')
@section('title', 'Admin Panel')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-16 text-center">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
        Admin Panel
    </h1>
    <p class="text-gray-500 dark:text-gray-400">
        Platform admin dashboard —
    </p>
    <div class="mt-4 inline-block badge badge-red">
        Logged in as: {{ auth()->user()->role }}
    </div>
</div>
@endsection
