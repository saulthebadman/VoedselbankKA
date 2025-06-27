<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use Illuminate\Http\Request;

class KlantController extends Controller
{
    public function index()
    {
        $klanten = Klant::all();
        return view('klanten.index', compact('klanten'));
    }

    public function create()
    {
        return view('klanten.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'naam' => 'required|string|max:255',
            'email' => 'required|email|unique:klants,email',
            'wachtwoord' => 'required|string|min:8',
            'allergie' => 'nullable|string|max:255',
        ]);

        // Sla het wachtwoord veilig op (hashen)
        $validated['wachtwoord'] = bcrypt($validated['wachtwoord']);

        Klant::create($validated);

        return redirect()->route('klanten.index')->with('success', 'Klant succesvol toegevoegd.');
    }

    public function edit($id)
    {
        $klant = \App\Models\Klant::findOrFail($id);
        return view('klanten.edit', compact('klant'));
    }

    public function update(Request $request, $id)
    {
        $klant = \App\Models\Klant::findOrFail($id);

        $validated = $request->validate([
            'naam' => 'required|string|max:255',
            'email' => 'required|email|unique:klants,email,' . $klant->id,
            'telefoon' => 'nullable|string|max:255',
            'allergie' => 'nullable|string|max:255',
            'nummer' => 'nullable|string|max:255',
            // voeg hier andere velden toe indien nodig
        ]);

        $klant->update($validated);

        // Na opslaan: terug naar het overzicht, nieuwe gegevens direct zichtbaar
        return redirect()->route('klanten.index')->with('success', 'Klant succesvol bijgewerkt.');
    }

    public function destroy($id)
    {
        $klant = \App\Models\Klant::findOrFail($id);
        $klant->delete();

        return redirect()->route('klanten.index')->with('success', 'Klant succesvol verwijderd.');
    }

    public function show($id)
    {
        $klant = \App\Models\Klant::find($id);

        if (!$klant) {
            return view('klanten.show', ['klant' => null]);
        }

        return view('klanten.show', compact('klant'));
    }
}

