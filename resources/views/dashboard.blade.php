<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard - Voedselbank Maaskantje') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welkomstbericht -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">Welkom bij de Voedselbank Maaskantje</h3>
                    <p class="text-gray-600">Beheer hier alle aspecten van de voedselbank: leveranciers, klanten, voorraad en voedselpakketten.</p>
                </div>
            </div>

            <!-- Eerstvolgende Levering -->
            @if($eerstvolgendeLevering)
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-1">🚚 Eerstvolgende Levering</h3>
                            <p class="text-blue-100 mb-3">
                                <strong>{{ $eerstvolgendeLevering->bedrijfsnaam }}</strong><br>
                                {{ $eerstvolgendeLevering->eerstvolgende_levering->format('d-m-Y \o\m H:i') }}
                            </p>
                            <p class="text-sm text-blue-100">
                                Contactpersoon: {{ $eerstvolgendeLevering->contactpersoon_naam }}<br>
                                Telefoon: {{ $eerstvolgendeLevering->telefoonnummer }}
                            </p>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('leveranciers.show', $eerstvolgendeLevering->leverancier_id) }}" 
                               class="bg-white text-blue-600 hover:bg-blue-50 font-bold py-3 px-6 rounded-lg transition duration-200 inline-block">
                                Bekijk Details →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-gray-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-700">
                    <h3 class="text-lg font-semibold mb-2">📅 Geen geplande leveringen</h3>
                    <p class="text-gray-600">Er zijn momenteel geen leveringen gepland. Plan een nieuwe levering via leveranciers beheer.</p>
                </div>
            </div>
            @endif

            <!-- Snelle acties -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                
                <!-- Leveranciers -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Leveranciers</dt>
                                    <dd class="text-lg font-medium text-gray-900">Beheren</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-5">
                            <a href="{{ route('leveranciers.index') }}" 
                               class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Ga naar Leveranciers
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Klanten (placeholder) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Klanten</dt>
                                    <dd class="text-lg font-medium text-gray-900">Beheren</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-5">
                            <button class="w-full bg-gray-400 text-white font-bold py-2 px-4 rounded cursor-not-allowed" disabled>
                                Binnenkort beschikbaar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Voorraad (placeholder) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Voorraad</dt>
                                    <dd class="text-lg font-medium text-gray-900">Beheren</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-5">
                            <button class="w-full bg-gray-400 text-white font-bold py-2 px-4 rounded cursor-not-allowed" disabled>
                                Binnenkort beschikbaar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Voedselpakketten (placeholder) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h1.586a1 1 0 01.707.293l1.414 1.414a1 1 0 00.707.293H15a2 2 0 012 2v2M5 8v10a2 2 0 002 2h10a2 2 0 002-2V10m0 0V8a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293L13.293 4.293A1 1 0 0012.586 4H11a2 2 0 00-2 2v2m0 0h10m-10 0V6a2 2 0 012-2h1.586a1 1 0 01.707.293l1.414 1.414a1 1 0 00.707.293H15a2 2 0 012 2v2"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Voedselpakketten</dt>
                                    <dd class="text-lg font-medium text-gray-900">Samenstellen</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-5">
                            <button class="w-full bg-gray-400 text-white font-bold py-2 px-4 rounded cursor-not-allowed" disabled>
                                Binnenkort beschikbaar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
