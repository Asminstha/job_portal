<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('seeker.dashboard');
    }
}
