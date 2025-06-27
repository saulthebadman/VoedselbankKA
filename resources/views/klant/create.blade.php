<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nieuwe Klant Toevoegen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('klant.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Voornaam -->
                        <div>
                            <label for="voornaam" class="block text-sm font-medium text-gray-700">
                                Voornaam *
                            </label>
                            <input type="text" 
                                   name="voornaam" 
                                   id="voornaam" 
                                   value="{{ old('voornaam') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        
                        <!-- Achternaam -->
                        <div>
                            <label for="achternaam" class="block text-sm font-medium text-gray-700">
                                Achternaam *
                            </label>
                            <input type="text" 
                                   name="achternaam" 
                                   id="achternaam" 
                                   value="{{ old('achternaam') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Straat -->
                        <div>
                            <label for="straat" class="block text-sm font-medium text-gray-700">
                                Straat *
                            </label>
                            <input type="text" 
                                   name="straat" 
                                   id="straat" 
                                   value="{{ old('straat') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Huisnummer en Postcode -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="huisnummer" class="block text-sm font-medium text-gray-700">
                                    Huisnummer *
                                </label>
                                <input type="text" 
                                       name="huisnummer" 
                                       id="huisnummer" 
                                       value="{{ old('huisnummer') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="postcode" class="block text-sm font-medium text-gray-700">
                                    Postcode *
                                </label>
                                <input type="text" 
                                       name="postcode" 
                                       id="postcode" 
                                       value="{{ old('postcode') }}"
                                       placeholder="1234 AB"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Plaats -->
                        <div>
                            <label for="plaats" class="block text-sm font-medium text-gray-700">
                                Plaats *
                            </label>
                            <input type="text" 
                                   name="plaats" 
                                   id="plaats" 
                                   value="{{ old('plaats') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- E-mail -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                E-mailadres (optioneel)
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Telefoonnummer -->
                        <div>
                            <label for="telefoonnummer" class="block text-sm font-medium text-gray-700">
                                Telefoonnummer *
                            </label>
                            <input type="tel" 
                                   name="telefoonnummer" 
                                   id="telefoonnummer" 
                                   value="{{ old('telefoonnummer') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Gezinssamenstelling -->
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="aantal_volwassenen" class="block text-sm font-medium text-gray-700">
                                    Aantal Volwassenen *
                                </label>
                                <input type="number" 
                                       name="aantal_volwassenen" 
                                       id="aantal_volwassenen" 
                                       min="1"
                                       value="{{ old('aantal_volwassenen', 1) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="aantal_kinderen" class="block text-sm font-medium text-gray-700">
                                    Aantal Kinderen *
                                </label>
                                <input type="number" 
                                       name="aantal_kinderen" 
                                       id="aantal_kinderen" 
                                       min="0"
                                       value="{{ old('aantal_kinderen', 0) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="aantal_babies" class="block text-sm font-medium text-gray-700">
                                    Aantal Babies *
                                </label>
                                <input type="number" 
                                       name="aantal_babies" 
                                       id="aantal_babies" 
                                       min="0"
                                       value="{{ old('aantal_babies', 0) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Actief checkbox -->
                        <div>
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="actief" 
                                       id="actief" 
                                       value="1"
                                       {{ old('actief', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="actief" class="ml-2 block text-sm text-gray-900">
                                    Klant is actief
                                </label>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-between pt-4">
                            <a href="{{ route('klant.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Annuleren
                            </a>
                            <button type="submit" 
                                    id="submitBtn"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                ✅ Klant Toevoegen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');
            
            form.addEventListener('submit', function(e) {
                submitBtn.innerHTML = '⏳ Toevoegen...';
                submitBtn.disabled = true;
                submitBtn.classList.remove('hover:bg-green-700');
                submitBtn.classList.add('bg-green-400');
            });
        });
    </script>
</x-app-layout>
