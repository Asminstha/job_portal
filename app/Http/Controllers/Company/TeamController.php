<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $members = User::where('company_id', auth()->user()->company_id)
            ->where('id', '!=', auth()->id())
            ->orderBy('role')
            ->get();

        return view('company.team.index', compact('members'));
    }

   public function invite(Request $request): RedirectResponse
{
    $request->validate([
        'name'  => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:users,email'],
        'role'  => ['required', 'in:recruiter,company_admin'],
    ]);

    $tempPassword = 'Welcome@' . rand(1000, 9999);

    User::create([
        'company_id' => auth()->user()->company_id,
        'name'       => $request->name,
        'email'      => $request->email,
        'password'   => \Hash::make($tempPassword),
        'role'       => $request->role,
        'is_active'  => true,
    ]);

    // Store in session so it shows persistently until dismissed
    return back()
        ->with('team_invite_success', [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $tempPassword,
        ]);
}
    public function remove(string $userId): RedirectResponse
    {
        $user = User::where('company_id', auth()->user()->company_id)
            ->where('id', $userId)
            ->where('id', '!=', auth()->id())
            ->firstOrFail();

        $user->delete();

        return back()->with('success', 'Team member removed.');
    }
}
