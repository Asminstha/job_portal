<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureWithinPlanLimits
{
    public function handle(Request $request, Closure $next): Response
    {
        $user    = auth()->user();
        $company = $user->company;
        $plan    = $company->activePlan();

        // null max_jobs means unlimited
        if ($plan->max_jobs !== null) {
            $activeJobs = $company->jobs()
                ->withoutGlobalScopes()
                ->whereIn('status', ['active', 'paused', 'draft'])
                ->count();

            if ($activeJobs >= $plan->max_jobs) {
                return redirect()->route('company.jobs.index')
                    ->with('error', "You have reached the {$plan->max_jobs} job limit on your {$plan->name} plan. Please upgrade to post more jobs.");
            }
        }

        return $next($request);
    }
}
