<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nieuwe klant toevoegen
        </h2>
    </x-slot>

    <div class="py-6">
        <form method="POST" action="{{ route('klanten.store') }}" class="space-y-4 max-w-xl mx-auto">
            @csrf
            <div>
                <label for="naam">Naam <span class="text-red-600">*</span></label>
                <input type="text" name="naam" id="naam" value="{{ old('naam') }}" class="border rounded w-full px-2 py-1">
            </div>
            <div>
                <label for="email">Email <span class="text-red-600">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="border rounded w-full px-2 py-1">
            </div>
            <div class="flex space-x-2">
                <div class="w-1/2">
                    <label for="wachtwoord">Wachtwoord <span class="text-red-600">*</span></label>
                    <input type="password" name="wachtwoord" id="wachtwoord" class="border rounded w-full px-2 py-1">
                    @error('wachtwoord')
                        <div class="text-red-600 text-sm mt-1">Dit veld is verplicht.</div>
                    @enderror
                </div>
                <div class="w-1/2">
                    <label for="wachtwoord_bevestig">Bevestig wachtwoord</label>
                    <input type="password" name="wachtwoord_bevestig" id="wachtwoord_bevestig" class="border rounded w-full px-2 py-1">
                </div>
            </div>
            <div>
                <label for="adres">Adres</label>
                <input type="text" name="adres" id="adres" value="{{ old('adres') }}" class="border rounded w-full px-2 py-1">
            </div>
            <div class="flex space-x-2">
                <div class="w-1/2">
                    <label for="postcode">Postcode</label>
                    <input type="text" name="postcode" id="postcode" value="{{ old('postcode') }}" class="border rounded w-full px-2 py-1">
                </div>
                <div class="w-1/2">
                    <label for="plaats">Plaats</label>
                    <input type="text" name="plaats" id="plaats" value="{{ old('plaats') }}" class="border rounded w-full px-2 py-1">
                </div>
            </div>
            <div>
                <label for="telefoonnummer">Telefoonnummer</label>
                <input type="text" name="telefoonnummer" id="telefoonnummer" value="{{ old('telefoonnummer') }}" class="border rounded w-full px-2 py-1">
            </div>
            <div>
                <label for="allergie">Allergieën</label>
                <input type="text" name="allergie" id="allergie" value="{{ old('allergie') }}" class="border rounded w-full px-2 py-1">
            </div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Opslaan</button>
        </form>
    </div>
</x-app-layout>
