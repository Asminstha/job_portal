@extends('layouts.public')
@section('title', 'Reset Password')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Set new password
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">
                Choose a strong password for your account.
            </p>
        </div>

        <div class="card p-8">
            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', request('email')) }}"
                           class="form-input @error('email') border-red-500 @enderror"
                           required autofocus>
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="form-label">New password</label>
                    <input type="password" id="password" name="password"
                           class="form-input @error('password') border-red-500 @enderror"
                           placeholder="Minimum 8 characters" required>
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="form-label">
                        Confirm new password
                    </label>
                    <input type="password" id="password_confirmation"
                           name="password_confirmation"
                           class="form-input" placeholder="Repeat password" required>
                </div>

                <button type="submit" class="btn-primary w-full justify-center py-2.5">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
