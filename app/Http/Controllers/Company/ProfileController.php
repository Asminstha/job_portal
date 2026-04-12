<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $company = auth()->user()->company;
        return view('company.profile.edit', compact('company'));
    }

    public function update(Request $request): RedirectResponse
    {
        $company = auth()->user()->company;

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'phone'       => ['nullable', 'string', 'max:20'],
            'website'     => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'industry'    => ['nullable', 'string', 'max:100'],
            'size'        => ['nullable', 'in:1-10,11-50,51-200,201-500,500+'],
            'address'     => ['nullable', 'string', 'max:255'],
            'city'        => ['nullable', 'string', 'max:100'],
            'country'     => ['nullable', 'string', 'max:100'],
            'logo'        => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        } else {
            unset($data['logo']);
        }

        $company->update($data);

        return back()->with('success', 'Company profile updated successfully!');
    }
}
