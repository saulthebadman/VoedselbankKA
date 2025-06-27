<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">
        @if(session('success'))
            <div class="mb-6">
                <div class="rounded-lg px-4 py-3 text-white font-semibold shadow-lg
                    @if(str_contains(session('success'), 'verwijderd')) bg-red-500
                    @elseif(str_contains(session('success'), 'bijgewerkt')) bg-blue-500
                    @else bg-green-500 @endif">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
            <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Klanten</h1>
            <a href="{{ route('klant.create') }}" class="inline-block bg-gradient-to-r from-green-500 to-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow hover:from-green-600 hover:to-green-800 transition">+ Nieuwe klant</a>
        </div>
        <div class="overflow-x-auto bg-white rounded-xl shadow-lg ring-1 ring-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-green-100 to-green-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Gezinsnaam</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Contactpersoon</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Adres</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Telefoon</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Gezinsgrootte</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actief</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Acties</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($klanten as $klant)
                    <tr class="hover:bg-green-50 transition">
                        <td class="px-4 py-3 font-semibold text-green-700">{{ $klant->gezinsnaam }}</td>
                        <td class="px-4 py-3">{{ $klant->voornaam }} {{ $klant->achternaam }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $klant->straat }} {{ $klant->huisnummer }}, {{ $klant->postcode }} {{ $klant->plaats }}</td>
                        <td class="px-4 py-3">{{ $klant->telefoonnummer }}</td>
                        <td class="px-4 py-3">{{ $klant->email }}</td>
                        <td class="px-4 py-3 text-center">{{ $klant->aantal_volwassenen + $klant->aantal_kinderen + $klant->aantal_babies }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($klant->actief)
                                <span class="inline-block px-2 py-1 text-xs font-bold text-green-800 bg-green-100 rounded-full">Ja</span>
                            @else
                                <span class="inline-block px-2 py-1 text-xs font-bold text-red-800 bg-red-100 rounded-full">Nee</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 flex flex-col sm:flex-row gap-2 justify-center items-center">
                            <a href="{{ route('klant.show', $klant) }}" class="bg-blue-100 text-blue-800 font-semibold px-3 py-1 rounded hover:bg-blue-200 transition">Bekijken</a>
                            <a href="{{ route('klant.edit', $klant) }}" class="bg-yellow-100 text-yellow-800 font-semibold px-3 py-1 rounded hover:bg-yellow-200 transition">Bewerken</a>
                            <form action="{{ route('klant.destroy', $klant) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze klant wilt verwijderen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-100 text-red-800 font-semibold px-3 py-1 rounded hover:bg-red-200 transition">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-400">Geen klanten gevonden.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>