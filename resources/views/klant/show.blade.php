<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Klant Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('klant.edit', $klant) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    📝 Bewerken
                </a>
                <a href="{{ route('klant.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← Terug naar Overzicht
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Persoonlijke informatie -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                                Persoonlijke informatie
                            </h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Gezinsnaam</label>
                                <p class="mt-1 text-sm text-gray-900 font-mono">{{ $klant->gezinsnaam }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Voornaam</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $klant->voornaam }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Achternaam</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $klant->achternaam }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Adres</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $klant->straat }} {{ $klant->huisnummer }}, {{ $klant->postcode }} {{ $klant->plaats }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Aanmelddatum</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    @if($klant->aanmelddatum)
                                        {{ \Carbon\Carbon::parse($klant->aanmelddatum)->format('d-m-Y') }}
                                    @else
                                        <span class="text-gray-500">Niet ingesteld</span>
                                    @endif
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Status</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    @if($klant->actief)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Actief
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Inactief
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <!-- Contactinformatie & Gezinssamenstelling -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                                Contactinformatie
                            </h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">E-mailadres</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    @if($klant->email)
                                        <a href="mailto:{{ $klant->email }}" 
                                           class="text-blue-600 hover:text-blue-900">
                                            {{ $klant->email }}
                                        </a>
                                    @else
                                        <span class="text-gray-500">Niet opgegeven</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Telefoonnummer</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <a href="tel:{{ $klant->telefoonnummer }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        {{ $klant->telefoonnummer }}
                                    </a>
                                </p>
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 mt-8">
                                Gezinssamenstelling
                            </h3>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Totaal gezinsgrootte</label>
                                <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $klant->aantal_volwassenen + $klant->aantal_kinderen + $klant->aantal_babies }} personen</p>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Volwassenen</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $klant->aantal_volwassenen }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Kinderen</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $klant->aantal_kinderen }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Babies</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $klant->aantal_babies }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Metadata -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-500">
                            <div>
                                <span class="font-medium">Toegevoegd op:</span>
                                @if($klant->created_at)
                                    {{ $klant->created_at->format('d-m-Y \o\m H:i') }}
                                @else
                                    Onbekend
                                @endif
                            </div>
                            <div>
                                <span class="font-medium">Laatst bijgewerkt:</span>
                                @if($klant->updated_at)
                                    {{ $klant->updated_at->format('d-m-Y \o\m H:i') }}
                                @else
                                    Onbekend
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actie Knoppen -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <form action="{{ route('klant.destroy', $klant) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Weet je zeker dat je deze klant wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Klant Verwijderen
                                </button>
                            </form>
                            
                            <div class="flex space-x-2">
                                <a href="{{ route('klant.edit', $klant) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    Bewerken
                                </a>
                                <a href="{{ route('klant.index') }}" 
                                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Terug naar Overzicht
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
