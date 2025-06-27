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
        $leveranciers = Leverancier::orderBy('bedrijfsnaam')->get();
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
            'bedrijfsnaam' => 'required|string|max:255',
            'adres' => 'required|string|max:255',
            'contactpersoon_naam' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:leveranciers,email',
            'telefoonnummer' => 'required|string|max:20',
            'eerstvolgende_levering' => 'nullable|date',
            'actief' => 'boolean'
        ]);

        // Standaard actief op true zetten als niet ingevuld
        $validated['actief'] = $request->has('actief') ? true : true;

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
            'bedrijfsnaam' => 'required|string|max:255',
            'adres' => 'required|string|max:255',
            'contactpersoon_naam' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:leveranciers,email,' . $leverancier->leverancier_id . ',leverancier_id',
            'telefoonnummer' => 'required|string|max:20',
            'eerstvolgende_levering' => 'nullable|date',
            'actief' => 'boolean'
        ]);

        // Actief checkbox handling
        $validated['actief'] = $request->has('actief') ? true : false;

        $leverancier->update($validated);

        return redirect()->route('leveranciers.index')
            ->with('success', 'Leverancier succesvol bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leverancier $leverancier)
    {
        $leverancier->delete();
        
        return redirect()->route('leveranciers.index')
            ->with('success', 'Leverancier succesvol verwijderd!');
    }
}
