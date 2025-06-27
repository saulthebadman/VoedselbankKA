<?php

namespace App\Http\Controllers;

use App\Models\Klant;

class DashboardController extends Controller
{
    public function index()
    {
        $klantCount = Klant::count();
        return view('dashboard', compact('klantCount'));
    }
}
