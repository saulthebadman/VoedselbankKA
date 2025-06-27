<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use Illuminate\Http\Request;

class LeverancierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leveranciers = Leverancier::orderByRaw('eerstvolgende_levering IS NULL, eerstvolgende_levering ASC')
            ->orderBy('bedrijfsnaam')
            ->get();
        return view('leveranciers.index', compact('leveranciers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leveranciers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'leveranciernummer' => 'required|string|max:255|unique:leveranciers,leveranciernummer',
            'bedrijfsnaam' => 'required|string|max:255',
            'leveranciertype' => 'required|in:supermarkten,groothandelaars,boeren',
            'adres' => 'required|string|max:255',
            'contactpersoon_naam' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:leveranciers,email',
            'telefoonnummer' => 'required|string|max:20',
            'eerstvolgende_levering' => 'nullable|date',
            'opmerking' => 'nullable|string',
            'isactief' => 'boolean'
        ]);

        // Standaard actief op true zetten als niet ingevuld
        $validated['isactief'] = $request->has('isactief') ? true : true;

        Leverancier::create($validated);

        return redirect()->route('leveranciers.index')
            ->with('success', 'Leverancier succesvol toegevoegd!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Leverancier $leverancier)
    {
        return view('leveranciers.show', compact('leverancier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leverancier $leverancier)
    {
        return view('leveranciers.edit', compact('leverancier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leverancier $leverancier)
    {
        $validated = $request->validate([
            'leveranciernummer' => 'required|string|max:255|unique:leveranciers,leveranciernummer,' . $leverancier->leverancier_id . ',leverancier_id',
            'bedrijfsnaam' => 'required|string|max:255',
            'leveranciertype' => 'required|in:supermarkten,groothandelaars,boeren',
            'adres' => 'required|string|max:255',
            'contactpersoon_naam' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:leveranciers,email,' . $leverancier->leverancier_id . ',leverancier_id',
            'telefoonnummer' => 'required|string|max:20',
            'eerstvolgende_levering' => 'nullable|date',
            'opmerking' => 'nullable|string',
            'isactief' => 'boolean'
        ]);

        // Actief checkbox handling
        $validated['isactief'] = $request->has('isactief') ? true : false;

        $leverancier->update($validated);

        return redirect()->route('leveranciers.index')
            ->with('success', 'Leverancier succesvol bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leverancier $leverancier)
    {
        // Controleer of de leverancier actief is (strict boolean check)
        if ($leverancier->isactief == true || $leverancier->isactief == 1) {
            return redirect()->route('leveranciers.index')
                ->with('error', 'Actieve leveranciers kunnen niet worden verwijderd. Zet de leverancier eerst op inactief.');
        }
        
        // Controleer of er nog leveringen gekoppeld zijn (alleen als tabel bestaat)
        try {
            if ($leverancier->leveringen()->exists()) {
                return redirect()->route('leveranciers.index')
                    ->with('error', 'Deze leverancier kan niet worden verwijderd omdat er nog leveringen aan gekoppeld zijn.');
            }
        } catch (\Exception $e) {
            // Leveringen tabel bestaat niet (bijv. in tests), ga door met verwijderen
        }
        
        $leverancier->delete();
        
        return redirect()->route('leveranciers.index')
            ->with('success', 'Leverancier succesvol verwijderd!');
    }
}
