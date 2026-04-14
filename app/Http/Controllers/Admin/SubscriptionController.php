<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Services\NotificationService;

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

    public function approve(string $id): RedirectResponse
{
    $subscription = Subscription::findOrFail($id);

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

// Notify company
    app(NotificationService::class)->subscriptionActivated($subscription->fresh());


    return back()->with('success',
        "Subscription approved for {$subscription->company->name}.");
}

public function reject(string $id): RedirectResponse
{
    $subscription = Subscription::findOrFail($id);
    $subscription->update(['status' => 'cancelled']);

    return back()->with('success',
        "Subscription rejected for {$subscription->company->name}.");
}
}
