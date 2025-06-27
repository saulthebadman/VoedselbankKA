<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Leverancier Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('leveranciers.edit', $leverancier) }}" 
                   class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Bewerken
                </a>
                <a href="{{ route('leveranciers.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Terug naar Overzicht
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Bedrijfsinformatie -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                                Bedrijfsinformatie
                            </h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Bedrijfsnaam</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leverancier->bedrijfsnaam }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Adres</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leverancier->adres }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Eerstvolgende Levering</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    @if($leverancier->eerstvolgende_levering)
                                        {{ $leverancier->eerstvolgende_levering->format('d-m-Y \o\m H:i') }}
                                        @if($leverancier->eerstvolgende_levering->isPast())
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2">
                                                Verlopen
                                            </span>
                                        @elseif($leverancier->eerstvolgende_levering->isToday())
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 ml-2">
                                                Vandaag
                                            </span>
                                        @elseif($leverancier->eerstvolgende_levering->isTomorrow())
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-2">
                                                Morgen
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-gray-500">Niet gepland</span>
                                    @endif
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Status</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    @if($leverancier->actief)
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
                        
                        <!-- Contactinformatie -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                                Contactinformatie
                            </h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Contactpersoon</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $leverancier->contactpersoon_naam }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">E-mailadres</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <a href="mailto:{{ $leverancier->email }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        {{ $leverancier->email }}
                                    </a>
                                </p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Telefoonnummer</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <a href="tel:{{ $leverancier->telefoonnummer }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        {{ $leverancier->telefoonnummer }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Metadata -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-500">
                            <div>
                                <span class="font-medium">Toegevoegd op:</span>
                                {{ $leverancier->created_at->format('d-m-Y \o\m H:i') }}
                            </div>
                            <div>
                                <span class="font-medium">Laatst bijgewerkt:</span>
                                {{ $leverancier->updated_at->format('d-m-Y \o\m H:i') }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actie Knoppen -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <form action="{{ route('leveranciers.destroy', $leverancier) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Weet je zeker dat je deze leverancier wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Leverancier Verwijderen
                                </button>
                            </form>
                            
                            <div class="flex space-x-2">
                                <a href="{{ route('leveranciers.edit', $leverancier) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    Bewerken
                                </a>
                                <a href="{{ route('leveranciers.index') }}" 
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
