<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function index(): View
    {
        $company      = auth()->user()->company;
        $plans        = Plan::where('is_active', true)->orderBy('sort_order')->get();
        $currentPlan  = $company->activePlan();
        $subscription = $company->activeSubscription;

        return view('company.subscription.index',
            compact('company', 'plans', 'currentPlan', 'subscription'));
    }
}
