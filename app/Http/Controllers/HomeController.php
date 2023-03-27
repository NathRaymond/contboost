<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Usecase;

class HomeController extends Controller
{

    public function index()
    {
        $plans = Plan::active()
            ->with('usecases')
            ->withTranslation()
            ->get();

        $usecases = Usecase::active()
            ->withTranslation()
            ->get();

        return view('index', compact('plans', 'usecases'));
    }
}
