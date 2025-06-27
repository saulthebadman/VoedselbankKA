<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leverancier;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Vind de eerstvolgende levering van alle actieve leveranciers
        $eerstvolgendeLevering = Leverancier::where('isactief', true)
            ->whereNotNull('eerstvolgende_levering')
            ->where('eerstvolgende_levering', '>=', Carbon::now())
            ->orderBy('eerstvolgende_levering', 'asc')
            ->first();

        return view('dashboard', compact('eerstvolgendeLevering'));
    }
}
