<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (! $user || ! $user->company) {
            return redirect()->route('login');
        }

        $company = $user->company;

        if (! $company->is_active) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Your company account has been suspended. Please contact support.');
        }

        if ($company->subscription_status === 'trial' && now()->gt($company->trial_ends_at)) {
            return redirect()->route('company.subscription.index')
                ->with('error', 'Your free trial has expired. Please upgrade to continue.');
        }

        if ($company->subscription_status === 'expired') {
            return redirect()->route('company.subscription.index')
                ->with('error', 'Your subscription has expired. Please renew to continue.');
        }

        return $next($request);
    }
}
