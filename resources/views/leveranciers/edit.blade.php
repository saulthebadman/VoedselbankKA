<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leverancier Bewerken') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('leveranciers.update', $leverancier) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Leveranciernummer -->
                        <div>
                            <label for="leveranciernummer" class="block text-sm font-medium text-gray-700">
                                Leveranciernummer *
                            </label>
                            <input type="text" 
                                   name="leveranciernummer" 
                                   id="leveranciernummer" 
                                   value="{{ old('leveranciernummer', $leverancier->leveranciernummer) }}"
                                   placeholder="bijv. SUP001, BOE001, GRO001"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('leveranciernummer')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Bedrijfsnaam -->
                        <div>
                            <label for="bedrijfsnaam" class="block text-sm font-medium text-gray-700">
                                Bedrijfsnaam *
                            </label>
                            <input type="text" 
                                   name="bedrijfsnaam" 
                                   id="bedrijfsnaam" 
                                   value="{{ old('bedrijfsnaam', $leverancier->bedrijfsnaam) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('bedrijfsnaam')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Leveranciertype -->
                        <div>
                            <label for="leveranciertype" class="block text-sm font-medium text-gray-700">
                                Leveranciertype *
                            </label>
                            <select name="leveranciertype" 
                                    id="leveranciertype" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecteer een type...</option>
                                @foreach(\App\Models\Leverancier::LEVERANCIERTYPE_OPTIONS as $value => $label)
                                    <option value="{{ $value }}" {{ old('leveranciertype', $leverancier->leveranciertype) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('leveranciertype')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Adres -->
                        <div>
                            <label for="adres" class="block text-sm font-medium text-gray-700">
                                Adres *
                            </label>
                            <input type="text" 
                                   name="adres" 
                                   id="adres" 
                                   value="{{ old('adres', $leverancier->adres) }}"
                                   placeholder="Straat huisnummer, postcode plaats"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('adres')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contactpersoon -->
                        <div>
                            <label for="contactpersoon_naam" class="block text-sm font-medium text-gray-700">
                                Naam Contactpersoon *
                            </label>
                            <input type="text" 
                                   name="contactpersoon_naam" 
                                   id="contactpersoon_naam" 
                                   value="{{ old('contactpersoon_naam', $leverancier->contactpersoon_naam) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('contactpersoon_naam')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                E-mailadres *
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email', $leverancier->email) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telefoonnummer" class="block text-sm font-medium text-gray-700">
                                Telefoonnummer *
                            </label>
                            <input type="tel" 
                                   name="telefoonnummer" 
                                   id="telefoonnummer" 
                                   value="{{ old('telefoonnummer', $leverancier->telefoonnummer) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('telefoonnummer')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Eerstvolgende levering -->
                        <div>
                            <label for="eerstvolgende_levering" class="block text-sm font-medium text-gray-700">
                                Eerstvolgende Levering (optioneel)
                            </label>
                            <input type="datetime-local" 
                                   name="eerstvolgende_levering" 
                                   id="eerstvolgende_levering" 
                                   value="{{ old('eerstvolgende_levering', $leverancier->eerstvolgende_levering ? $leverancier->eerstvolgende_levering->format('Y-m-d\TH:i') : '') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('eerstvolgende_levering')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Opmerking -->
                        <div>
                            <label for="opmerking" class="block text-sm font-medium text-gray-700">
                                Opmerking (optioneel)
                            </label>
                            <textarea name="opmerking" 
                                      id="opmerking" 
                                      rows="3"
                                      placeholder="Eventuele opmerkingen over deze leverancier..."
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('opmerking', $leverancier->opmerking) }}</textarea>
                            @error('opmerking')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actief checkbox -->
                        <div>
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="isactief" 
                                       id="isactief" 
                                       value="1"
                                       {{ old('isactief', $leverancier->isactief) ? 'checked' : '' }}
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="isactief" class="ml-2 block text-sm text-gray-900">
                                    Leverancier is actief
                                </label>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-between pt-4">
                            <a href="{{ route('leveranciers.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Annuleren
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Bijwerken
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
