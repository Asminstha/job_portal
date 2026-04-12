@extends('layouts.app')
@section('title', 'Team')
@section('page-title', 'Team Members')
@section('page-subtitle', 'Manage who has access to your dashboard')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Team list --}}
    <div class="lg:col-span-2">
        <div class="card overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                <h2 class="font-semibold text-gray-900 dark:text-white">Current Members</h2>
            </div>

            {{-- Current user --}}
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800
                        flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-brand-100 dark:bg-brand-900
                            flex items-center justify-center
                            text-brand-700 dark:text-brand-300 font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-900 dark:text-white">
                        {{ auth()->user()->name }}
                        <span class="ml-1.5 text-xs text-gray-400">(you)</span>
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                </div>
                <span class="badge badge-blue">{{ ucfirst(str_replace('_',' ', auth()->user()->role)) }}</span>
            </div>

            @forelse($members as $member)
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800
                        flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800
                            flex items-center justify-center
                            text-gray-600 dark:text-gray-300 font-bold">
                    {{ strtoupper(substr($member->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-900 dark:text-white">{{ $member->name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $member->email }}</p>
                </div>
                <span class="badge badge-gray mr-3">
                    {{ ucfirst(str_replace('_',' ', $member->role)) }}
                </span>
                @if(auth()->user()->isCompanyAdmin())
                <form method="POST" action="{{ route('company.team.remove', $member->id) }}"
                      onsubmit="return confirm('Remove {{ $member->name }} from the team?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="text-xs text-red-500 hover:text-red-700 dark:hover:text-red-400">
                        Remove
                    </button>
                </form>
                @endif
            </div>
            @empty
            <div class="px-5 py-8 text-center text-sm text-gray-400 dark:text-gray-500">
                No other team members yet. Invite your colleagues below.
            </div>
            @endforelse
        </div>
    </div>

    {{-- Invite form --}}
    @if(auth()->user()->isCompanyAdmin())
    <div class="card p-6 h-fit">
        <h2 class="font-semibold text-gray-900 dark:text-white mb-5">Invite Team Member</h2>
        <form method="POST" action="{{ route('company.team.invite') }}" class="space-y-4">
            @csrf
            <div>
                <label class="form-label">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="form-input @error('name') border-red-500 @enderror"
                       placeholder="Ram Sharma">
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="form-input @error('email') border-red-500 @enderror"
                       placeholder="recruiter@company.com">
                @error('email') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Role <span class="text-red-500">*</span></label>
                <select name="role" class="form-input">
                    <option value="recruiter"      {{ old('role') === 'recruiter'      ? 'selected' : '' }}>Recruiter</option>
                    <option value="company_admin"  {{ old('role') === 'company_admin'  ? 'selected' : '' }}>Company Admin</option>
                </select>
            </div>
            <button type="submit" class="btn-primary w-full justify-center">
                Add Team Member
            </button>
            <p class="text-xs text-gray-400 dark:text-gray-500 text-center">
                A temporary password will be shown after adding. Share it securely with the team member.
            </p>
        </form>
    </div>
    @endif

</div>

@endsection
