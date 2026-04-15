<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    // ── Show login form ────────────────────────────────────────
    public function showLogin(): View
    {
        return view('auth.login');
    }

    // ── Handle login ───────────────────────────────────────────
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'These credentials do not match our records.']);
        }

        $user = Auth::user();

        if (! $user->is_active) {
            Auth::logout();
            return back()->withErrors(['email' => 'Your account has been deactivated. Please contact support.']);
        }

        $request->session()->regenerate();

        return redirect()->intended($user->dashboardRoute());
    }

    // ── Show register choice page ──────────────────────────────
    public function showRegister(): View
    {
        return view('auth.register');
    }

    // ── Show company registration form ─────────────────────────
    public function showRegisterCompany(): View
    {
        return view('auth.register-company');
    }

    // ── Handle company registration ────────────────────────────
    public function registerCompany(Request $request): RedirectResponse
    {
        $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'industry'     => ['required', 'string', 'max:255'],
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'unique:users,email'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Create company
                $company = Company::create([
                    'name'                => $request->company_name,
                    'slug'                => $this->generateCompanySlug($request->company_name),
                    'email'               => $request->email,
                    'phone'               => $request->phone,
                    'industry'            => $request->industry,
                    'subscription_status' => 'trial',
                    'trial_ends_at'       => now()->addDays(14),
                    'plan_id'             => Plan::where('slug', 'free')->first()?->id,
                ]);

                // Create company admin user
                $user = User::create([
                    'company_id' => $company->id,
                    'name'       => $request->name,
                    'email'      => $request->email,
                    'password'   => Hash::make($request->password),
                    'phone'      => $request->phone,
                    'role'       => 'company_admin',
                    'is_active'  => true,
                ]);

                Auth::login($user);
                return $company;
            });

// Notify admin of new company
app(NotificationService::class)->newCompanyRegistered(
    Company::where('email', $request->email)->first()
);


        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Something went wrong. Please try again.']);
        }

        return redirect()->route('company.dashboard')
            ->with('success', 'Welcome! Your 14-day free trial has started.');
    }

    // ── Show seeker registration form ──────────────────────────
    public function showRegisterSeeker(): View
    {
        return view('auth.register-seeker');
    }

    // ── Handle seeker registration ─────────────────────────────
    public function registerSeeker(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'phone'      => $request->phone,
            'role'       => 'seeker',
            'company_id' => null,
            'is_active'  => true,
        ]);

        Auth::login($user);

        return redirect()->route('seeker.dashboard')
            ->with('success', 'Welcome to JobsNepal! Complete your profile to get started.');
    }

    // ── Logout ─────────────────────────────────────────────────
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    // ── Private helpers ────────────────────────────────────────
    private function generateCompanySlug(string $name): string
    {
        $base  = Str::slug($name);
        $slug  = $base;
        $count = 1;
        while (Company::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $count++;
        }
        return $slug;
    }


// ── Forgot password form ───────────────────────────────
public function showForgotPassword(): View
{
    return view('auth.forgot-password');
}

// ── Send reset link ────────────────────────────────────
public function sendResetLink(Request $request): RedirectResponse
{
    $request->validate(['email' => ['required', 'email']]);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? back()->with('success', 'Password reset link sent to your email.')
        : back()->withErrors(['email' => __($status)]);
}

// ── Show reset form ────────────────────────────────────
public function showResetPassword(Request $request): View
{
    return view('auth.reset-password', ['token' => $request->route('token')]);
}

// ── Handle password reset ──────────────────────────────
public function resetPassword(Request $request): RedirectResponse
{
    $request->validate([
        'token'    => ['required'],
        'email'    => ['required', 'email'],
        'password' => ['required', 'min:8', 'confirmed'],
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill(['password' => Hash::make($password)])->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('success', 'Password reset successfully. Please log in.')
        : back()->withErrors(['email' => [__($status)]]);
}

}
