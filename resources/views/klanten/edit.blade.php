<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Klant bewerken
        </h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto">
        <form method="POST" action="{{ route('klanten.update', $klant->id) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="nummer">Nummer</label>
                <input type="text" name="nummer" id="nummer" value="{{ old('nummer', $klant->nummer) }}" class="border rounded w-full px-2 py-1">
            </div>
            <div>
                <label for="naam">Naam</label>
                <input type="text" name="naam" id="naam" value="{{ old('naam', $klant->naam) }}" class="border rounded w-full px-2 py-1">
            </div>
            <div>
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" value="{{ old('email', $klant->email) }}" class="border rounded w-full px-2 py-1">
            </div>
            <div>
                <label for="telefoon">Telefoon</label>
                <input type="text" name="telefoon" id="telefoon" value="{{ old('telefoon', $klant->telefoon) }}" class="border rounded w-full px-2 py-1">
            </div>
            <div>
                <label for="allergie">Allergieën</label>
                <input type="text" name="allergie" id="allergie" value="{{ old('allergie', $klant->allergie) }}" class="border rounded w-full px-2 py-1">
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Opslaan</button>
                <a href="{{ route('klanten.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Annuleren</a>
            </div>
        </form>
    </div>
</x-app-layout>
