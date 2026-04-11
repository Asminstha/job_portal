<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        return view('public.jobs.index', ['jobs' => collect([])]);
    }

    public function show(string $job)
    {
        abort(404);
    }
}
