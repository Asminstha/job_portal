@extends('layouts.admin')
@section('title', 'Users')
@section('page-title', 'Users')
@section('page-subtitle', 'All registered users')

@section('content')

{{-- Role summary --}}
<div class="flex flex-wrap gap-3 mb-6">
    @foreach(['admin' => 'Admins', 'company_admin' => 'Company Admins', 'recruiter' => 'Recruiters', 'seeker' => 'Seekers'] as $role => $label)
        <div class="card px-4 py-2 flex items-center gap-2">
            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                {{ $roleCounts[$role] ?? 0 }}
            </span>
            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $label }}</span>
        </div>
    @endforeach
</div>

{{-- Search --}}
<form method="GET" class="flex flex-wrap gap-3 mb-6">
    <input type="text" name="q" value="{{ request('q') }}"
           class="form-input flex-1 min-w-48" placeholder="Search name or email...">
    <select name="role" class="form-input w-40">
        <option value="">All roles</option>
        <option value="seeker"       {{ request('role') === 'seeker'       ? 'selected' : '' }}>Seekers</option>
        <option value="company_admin"{{ request('role') === 'company_admin'? 'selected' : '' }}>Company Admins</option>
        <option value="recruiter"    {{ request('role') === 'recruiter'    ? 'selected' : '' }}>Recruiters</option>
        <option value="admin"        {{ request('role') === 'admin'        ? 'selected' : '' }}>Admins</option>
    </select>
    <button type="submit" class="btn-primary">Search</button>
    @if(request()->anyFilled(['q','role']))
        <a href="{{ route('admin.users.index') }}" class="btn-secondary">Clear</a>
    @endif
</form>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Company</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Joined</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors
                           {{ !$user->is_active ? 'opacity-60' : '' }}">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            @if($user->avatar)
                                <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}"
                                     class="w-8 h-8 rounded-full object-cover border border-gray-200 dark:border-gray-700 flex-shrink-0">
                            @else
                                <div class="w-8 h-8 rounded-full bg-brand-100 dark:bg-brand-900
                                            flex items-center justify-center text-brand-700 text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        @php
                            $roleClass = match($user->role) {
                                'admin'         => 'badge-red',
                                'company_admin' => 'badge-blue',
                                'recruiter'     => 'badge-purple',
                                default         => 'badge-gray',
                            };
                        @endphp
                        <span class="{{ $roleClass }}">
                            {{ ucfirst(str_replace('_',' ', $user->role)) }}
                        </span>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell text-xs text-gray-500 dark:text-gray-400">
                        {{ $user->company?->name ?? '—' }}
                    </td>
                    <td class="px-5 py-4 hidden lg:table-cell text-xs text-gray-500 dark:text-gray-400">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-5 py-4">
                        <span class="{{ $user->is_active ? 'badge-green' : 'badge-red' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        @if(!$user->isAdmin())
                        <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="text-xs px-2.5 py-1 rounded-lg border transition-colors
                                           {{ $user->is_active
                                               ? 'border-red-200 text-red-600 hover:bg-red-50 dark:border-red-800 dark:text-red-400'
                                               : 'border-green-200 text-green-600 hover:bg-green-50 dark:border-green-800 dark:text-green-400' }}">
                                {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-gray-400">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
        {{ $users->links() }}
    </div>
</div>

@endsection
