<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function index(): View
    {
        $company     = auth()->user()->company;
        $plans       = Plan::where('is_active', true)->orderBy('sort_order')->get();
        $currentPlan = $company->activePlan();
        $subscription = $company->activeSubscription;

        $pendingRequest = Subscription::where('company_id', $company->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        return view('company.subscription.index',
            compact('company', 'plans', 'currentPlan', 'subscription', 'pendingRequest'));
    }

    public function requestUpgrade(Request $request): RedirectResponse
    {
        $company = auth()->user()->company;

        $request->validate([
            'plan_id'        => ['required', 'exists:plans,id'],
            'billing_cycle'  => ['required', 'in:monthly,yearly'],
            'payment_method' => ['required', 'string', 'max:50'],
            'payment_proof'  => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'payment_ref'    => ['nullable', 'string', 'max:100'],
        ]);

        $plan = Plan::findOrFail($request->plan_id);

        // Store payment proof
        $proofPath = $request->file('payment_proof')
            ->store('payment-proofs', 'public');

        $amount = $request->billing_cycle === 'yearly'
            ? $plan->price_yearly
            : $plan->price_monthly;

        Subscription::create([
            'company_id'       => $company->id,
            'plan_id'          => $plan->id,
            'billing_cycle'    => $request->billing_cycle,
            'amount_paid'      => $amount,
            'currency'         => 'NPR',
            'payment_method'   => $request->payment_method,
            'payment_reference'=> $request->payment_ref,
            'payment_proof'    => $proofPath,
            'status'           => 'pending',
        ]);

        return back()->with('success',
            'Upgrade request submitted! We will verify your payment and activate your plan within 24 hours.');
    }
}
