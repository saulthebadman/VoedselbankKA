<x-app-layout>

@section('content')
<div class="container mx-auto py-4 max-w-xl">
    <h1 class="text-2xl font-bold mb-4">Klantgegevens</h1>
    <div class="bg-white p-4 rounded shadow">
        <div class="mb-2"><strong>Gezinsnaam:</strong> {{ $klant->gezinsnaam }}</div>
        <div class="mb-2"><strong>Contactpersoon:</strong> {{ $klant->voornaam }} {{ $klant->achternaam }}</div>
        <div class="mb-2"><strong>Adres:</strong> {{ $klant->straat }} {{ $klant->huisnummer }}, {{ $klant->postcode }} {{ $klant->plaats }}</div>
        <div class="mb-2"><strong>Telefoonnummer:</strong> {{ $klant->telefoonnummer }}</div>
        <div class="mb-2"><strong>Email:</strong> {{ $klant->email }}</div>
        <div class="mb-2"><strong>Gezinsgrootte:</strong> {{ $klant->aantal_volwassenen + $klant->aantal_kinderen + $klant->aantal_babies }}</div>
        <div class="mb-2"><strong>Volwassenen:</strong> {{ $klant->aantal_volwassenen }}</div>
        <div class="mb-2"><strong>Kinderen:</strong> {{ $klant->aantal_kinderen }}</div>
        <div class="mb-2"><strong>Babies:</strong> {{ $klant->aantal_babies }}</div>
        <div class="mb-2"><strong>Actief:</strong> {{ $klant->actief ? 'Ja' : 'Nee' }}</div>
        <div class="mb-2"><strong>Aanmelddatum:</strong> {{ $klant->aanmelddatum }}</div>
    </div>
    <div class="mt-4 flex gap-2">
        <a href="{{ route('klant.edit', $klant) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Bewerken</a>
        <form action="{{ route('klant.destroy', $klant) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze klant wilt verwijderen?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Verwijderen</button>
        </form>
        <a href="{{ route('klant.index') }}" class="ml-2 text-gray-600 hover:underline">Terug naar overzicht</a>
    </div>
</div>
</x-app-layout>
