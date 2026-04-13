<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function index(): View
    {
        $subscriptions = Subscription::with(['company', 'plan'])
            ->latest()
            ->paginate(20);

        $stats = [
            'total_revenue' => Subscription::where('status', 'active')->sum('amount_paid'),
            'this_month'    => Subscription::where('status', 'active')
                                  ->whereMonth('created_at', now()->month)
                                  ->sum('amount_paid'),
            'pending'       => Subscription::where('status', 'pending')->count(),
            'active'        => Subscription::where('status', 'active')->count(),
        ];

        return view('admin.subscriptions.index', compact('subscriptions', 'stats'));
    }

    public function approve(Subscription $subscription): RedirectResponse
    {
        $subscription->update([
            'status'               => 'active',
            'current_period_start' => now(),
            'current_period_end'   => $subscription->billing_cycle === 'yearly'
                                        ? now()->addYear()
                                        : now()->addMonth(),
        ]);

        $subscription->company->update([
            'subscription_status' => 'active',
            'plan_id'             => $subscription->plan_id,
        ]);

        return back()->with('success',
            "Subscription approved for {$subscription->company->name}.");
    }

    public function reject(Subscription $subscription): RedirectResponse
    {
        $subscription->update(['status' => 'cancelled']);

        return back()->with('success',
            "Subscription rejected for {$subscription->company->name}.");
    }
}
