<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            Klantenoverzicht
        </h2>
    </x-slot>

    <div class="flex justify-center mt-6">
        <div class="w-full max-w-5xl">
            @if(session('success'))
                @php
                    $msg = session('success');
                    $alertColor = 'bg-green-600';
                    if (str_contains($msg, 'verwijderd')) {
                        $alertColor = 'bg-red-600';
                    } elseif (str_contains($msg, 'bijgewerkt') || str_contains($msg, 'bewerkt')) {
                        $alertColor = 'bg-blue-600';
                    }
                @endphp
                <div 
                    x-data="{ show: true }" 
                    x-show="show" 
                    x-init="setTimeout(() => show = false, 3000)" 
                    class="mb-4"
                >
                    <div class="{{ $alertColor }} text-white text-center py-3 rounded transition-all duration-500">
                        {{ $msg }}
                    </div>
                </div>
            @endif

            <div class="flex justify-between items-center mb-4">
                <form method="GET" action="{{ route('klanten.index') }}" class="flex items-center space-x-2">
                    <input type="text" name="zoek" placeholder="Klant zoeken" value="{{ request('zoek') }}" class="border rounded px-2 py-1">
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Filter</button>
                    <a href="{{ route('klanten.index') }}" class="bg-gray-300 px-3 py-1 rounded">Reset</a>
                </form>
                <a href="{{ route('klanten.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Nieuwe klant</a>
            </div>

            <div class="overflow-x-auto rounded shadow">
                <table class="min-w-full bg-white border text-center">
                    <thead>
                        <tr>
                            <th class="px-2 py-2 border font-bold">Naam</th>
                            <th class="px-2 py-2 border font-bold">Email</th>
                            <th class="px-2 py-2 border font-bold">Nummer</th>
                            <th class="px-2 py-2 border font-bold">Adres</th>
                            <th class="px-2 py-2 border font-bold">Postcode</th>
                            <th class="px-2 py-2 border font-bold">Allergie</th>
                            <th class="px-2 py-2 border font-bold w-24">Actie</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($klanten as $klant)
                            <tr>
                                <td class="border px-2 py-2 font-semibold text-black hover:text-blue-600 transition-colors duration-200">
                                    <a href="{{ route('klanten.show', $klant->id) }}">{{ $klant->naam }}</a>
                                </td>
                                <td class="border px-2 py-2">{{ $klant->email }}</td>
                                <td class="border px-2 py-2">{{ $klant->nummer ?? '' }}</td>
                                <td class="border px-2 py-2">{{ $klant->adres ?? '' }}</td>
                                <td class="border px-2 py-2">{{ $klant->postcode ?? '' }}</td>
                                <td class="border px-2 py-2">{{ $klant->allergie ?? '' }}</td>
                                <td class="border px-2 py-2 w-24">
                                    <form action="{{ route('klanten.destroy', $klant->id) }}" method="POST" class="mb-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="block w-full text-center bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded transition"
                                                onclick="return confirm('Weet je zeker dat je deze klant wilt verwijderen?')">
                                            Delete
                                        </button>
                                    </form>
                                    <a href="{{ route('klanten.edit', $klant->id) }}"
                                       class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded transition">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">Geen klanten gevonden.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
                    <td colspan="7" class="text-center py-2">Geen klanten gevonden.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-app-layout>
