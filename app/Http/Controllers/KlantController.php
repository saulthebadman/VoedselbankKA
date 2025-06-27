<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use Illuminate\Http\Request;

class KlantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $klanten = \App\Models\Klant::orderBy('klant_id', 'desc')->get();
        return view('klant.index', compact('klanten'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('klant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'voornaam' => 'required',
            'achternaam' => 'required',
            'straat' => 'required',
            'huisnummer' => 'required',
            'postcode' => 'required',
            'plaats' => 'required',
            'telefoonnummer' => 'required',
            'email' => 'nullable|email',
            'aantal_volwassenen' => 'required|integer|min:1',
            'aantal_kinderen' => 'required|integer|min:0',
            'aantal_babies' => 'required|integer|min:0',
            'actief' => 'required|boolean',
        ]);
        $data['gezinsnaam'] = 'Familie ' . $data['achternaam'];
        $data['aanmelddatum'] = now();
        $klant = \App\Models\Klant::create($data);
        return redirect()->route('klant.index')->with('success', 'Klant aangemaakt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Klant $klant)
    {
        return view('klant.show', compact('klant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Klant $klant)
    {
        return view('klant.edit', compact('klant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Klant $klant)
    {
        $data = $request->validate([
            'voornaam' => 'required',
            'achternaam' => 'required',
            'straat' => 'required',
            'huisnummer' => 'required',
            'postcode' => 'required',
            'plaats' => 'required',
            'telefoonnummer' => 'required',
            'email' => 'nullable|email',
            'aantal_volwassenen' => 'required|integer|min:1',
            'aantal_kinderen' => 'required|integer|min:0',
            'aantal_babies' => 'required|integer|min:0',
            'actief' => 'required|boolean',
        ]);
        $data['gezinsnaam'] = 'Familie ' . $data['achternaam'];
        $klant->update($data);
        return redirect()->route('klant.index')->with('success', 'Klant bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Klant $klant)
    {
        if (!$klant->actief) {
            return redirect()->route('klant.index')->with('success', 'Inactieve klanten kunnen niet worden verwijderd.');
        }
        $klant->delete();
        return redirect()->route('klant.index')->with('success', 'Klant verwijderd!');
    }
}
