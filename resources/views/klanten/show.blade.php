<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Klantgegevens
        </h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto">
        @if(!$klant)
            <div class="bg-red-600 text-white text-center py-3 rounded">
                Geen gegevens beschikbaar voor deze klant.
            </div>
        @else
            <div class="bg-white shadow rounded p-6">
                <div class="mb-2"><strong>Naam:</strong> {{ $klant->naam }}</div>
                <div class="mb-2"><strong>E-mail:</strong> {{ $klant->email }}</div>
                <div class="mb-2"><strong>Nummer:</strong> {{ $klant->nummer ?? '-' }}</div>
                <div class="mb-2"><strong>Telefoon:</strong> {{ $klant->telefoon ?? '-' }}</div>
                <div class="mb-2"><strong>Allergieën:</strong> {{ $klant->allergie ?? '-' }}</div>
                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('klanten.edit', $klant->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Bewerken</a>
                    <form action="{{ route('klanten.destroy', $klant->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze klant wilt verwijderen?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Verwijderen</button>
                    </form>
                </div>
            </div>
        @endif
        <div class="mt-4">
            <a href="{{ route('klanten.index') }}" class="text-blue-600 underline">Terug naar overzicht</a>
        </div>
    </div>
</x-app-layout>

