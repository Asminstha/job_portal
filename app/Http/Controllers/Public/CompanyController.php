<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index()
    {
        return view('public.companies.index', ['companies' => collect([])]);
    }

    public function show(string $company)
    {
        abort(404);
    }
}
