<x-app-layout>

@section('content')
<div class="container mx-auto py-4 max-w-xl">
    <h1 class="text-2xl font-bold mb-4">Nieuwe klant toevoegen</h1>
    <form action="{{ route('klant.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block">Voornaam</label>
            <input type="text" name="voornaam" class="w-full border rounded px-2 py-1" required>
        </div>
        <div>
            <label class="block">Achternaam</label>
            <input type="text" name="achternaam" class="w-full border rounded px-2 py-1" required>
        </div>
        <div>
            <label class="block">Straat</label>
            <input type="text" name="straat" class="w-full border rounded px-2 py-1" required>
        </div>
        <div class="flex gap-2">
            <div class="flex-1">
                <label class="block">Huisnummer</label>
                <input type="text" name="huisnummer" class="w-full border rounded px-2 py-1" required>
            </div>
            <div class="flex-1">
                <label class="block">Postcode</label>
                <input type="text" name="postcode" class="w-full border rounded px-2 py-1" required>
            </div>
        </div>
        <div>
            <label class="block">Plaats</label>
            <input type="text" name="plaats" class="w-full border rounded px-2 py-1" required>
        </div>
        <div>
            <label class="block">Telefoonnummer</label>
            <input type="text" name="telefoonnummer" class="w-full border rounded px-2 py-1" required>
        </div>
        <div>
            <label class="block">Email</label>
            <input type="email" name="email" class="w-full border rounded px-2 py-1">
        </div>
        <div class="flex gap-2">
            <div class="flex-1">
                <label class="block">Aantal volwassenen</label>
                <input type="number" name="aantal_volwassenen" class="w-full border rounded px-2 py-1" value="1" min="1" required>
            </div>
            <div class="flex-1">
                <label class="block">Aantal kinderen</label>
                <input type="number" name="aantal_kinderen" class="w-full border rounded px-2 py-1" value="0" min="0" required>
            </div>
            <div class="flex-1">
                <label class="block">Aantal babies</label>
                <input type="number" name="aantal_babies" class="w-full border rounded px-2 py-1" value="0" min="0" required>
            </div>
        </div>
        <div>
            <label class="block">Actief</label>
            <select name="actief" class="w-full border rounded px-2 py-1">
                <option value="1">Ja</option>
                <option value="0">Nee</option>
            </select>
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Opslaan</button>
        <a href="{{ route('klant.index') }}" class="ml-2 text-gray-600 hover:underline">Annuleren</a>
    </form>
</div>
</x-app-layout>
