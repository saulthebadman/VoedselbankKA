<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Leveranciers Overzicht') }}
            </h2>
            <a href="{{ route('leveranciers.create') }}" 
               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                ✓ Leverancier Toevoegen
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success_create'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            ✓ {{ session('success_create') }}
                        </div>
                    @endif

                    @if(session('success_edit'))
                        <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                            📝 {{ session('success_edit') }}
                        </div>
                    @endif

                    @if(session('success_delete'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            🗑️ {{ session('success_delete') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            ⚠️ {{ session('error') }}
                        </div>
                    @endif

                    @if($leveranciers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Leveranciernummer
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Bedrijfsnaam
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Contactpersoon
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Telefoon
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Volgende Levering
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acties
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($leveranciers as $leverancier)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $leverancier->leveranciernummer }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $leverancier->bedrijfsnaam }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    @if($leverancier->leveranciertype == 'supermarkten') bg-blue-100 text-blue-800
                                                    @elseif($leverancier->leveranciertype == 'groothandelaars') bg-purple-100 text-purple-800
                                                    @else bg-green-100 text-green-800 @endif">
                                                    {{ \App\Models\Leverancier::LEVERANCIERTYPE_OPTIONS[$leverancier->leveranciertype] ?? $leverancier->leveranciertype }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $leverancier->contactpersoon_naam }}<br>
                                                <a href="mailto:{{ $leverancier->email }}" 
                                                   class="text-blue-600 hover:text-blue-900">
                                                    {{ $leverancier->email }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $leverancier->telefoonnummer }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($leverancier->eerstvolgende_levering)
                                                    {{ $leverancier->eerstvolgende_levering->format('d-m-Y H:i') }}
                                                @else
                                                    Niet gepland
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($leverancier->isactief)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Actief
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Inactief
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('leveranciers.show', $leverancier) }}" 
                                                       class="text-indigo-600 hover:text-indigo-900">👁️ Bekijken</a>
                                                    <a href="{{ route('leveranciers.edit', $leverancier) }}" 
                                                       class="text-blue-600 hover:text-blue-900">📝 Bewerken</a>
                                                    
                                                    @if($leverancier->isactief)
                                                        <span class="text-gray-400 cursor-not-allowed" 
                                                              title="Actieve leveranciers kunnen niet worden verwijderd">
                                                            🔒 Verwijderen
                                                        </span>
                                                    @else
                                                        <form action="{{ route('leveranciers.destroy', $leverancier) }}" 
                                                              method="POST" 
                                                              class="inline-block delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" 
                                                                    class="text-red-600 hover:text-red-900 delete-btn"
                                                                    data-leverancier="{{ $leverancier->bedrijfsnaam }}">
                                                                🗑️ Verwijderen
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-500 text-lg">
                                Er zijn momenteel geen leveranciers geregistreerd.
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('leveranciers.create') }}" 
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Voeg je eerste leverancier toe
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-2">Leverancier Verwijderen</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Weet je zeker dat je leverancier <strong id="leverancierName"></strong> wilt verwijderen? 
                        Deze actie kan niet ongedaan worden gemaakt.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirmDelete" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Verwijderen
                    </button>
                    <button id="cancelDelete" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Annuleren
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = document.getElementById('deleteModal');
            const leverancierNameSpan = document.getElementById('leverancierName');
            const confirmDeleteBtn = document.getElementById('confirmDelete');
            const cancelDeleteBtn = document.getElementById('cancelDelete');
            let currentForm = null;

            // Delete button click handlers
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const leverancierName = this.getAttribute('data-leverancier');
                    const form = this.closest('.delete-form');
                    
                    leverancierNameSpan.textContent = leverancierName;
                    currentForm = form;
                    deleteModal.classList.remove('hidden');
                });
            });

            // Confirm delete
            confirmDeleteBtn.addEventListener('click', function() {
                if (currentForm) {
                    currentForm.submit();
                }
            });

            // Cancel delete
            cancelDeleteBtn.addEventListener('click', function() {
                deleteModal.classList.add('hidden');
                currentForm = null;
            });

            // Close modal when clicking outside
            deleteModal.addEventListener('click', function(e) {
                if (e.target === deleteModal) {
                    deleteModal.classList.add('hidden');
                    currentForm = null;
                }
            });
        });
    </script>
</x-app-layout>
