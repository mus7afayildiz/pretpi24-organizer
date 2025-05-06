@php use Milon\Barcode\DNS1D; @endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notes') }}
        </h2>
    </x-slot>    

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">
                <!-- Barre de recherche -->
                @include('components.search-bar')
                    <!-- Bouton Ajouter une nouvelle note -->
                    <div class="flex justify-end">
                        <a href="{{ route('notes.create') }}" 
                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            + Add New Note
                        </a>
                    </div> 
                    <!-- Tableau des notes -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse border border-gray-300 dark:border-gray-700">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700 text-left text-sm font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    <th class="px-6 py-3 border border-gray-300 dark:border-gray-600">Titre</th>
                                    <th class="px-6 py-3 border border-gray-300 dark:border-gray-600">Text</th>
                                    <th class="px-6 py-3 border border-gray-300 dark:border-gray-600">Barcode</th>
                                    <th class="px-6 py-3 border border-gray-300 dark:border-gray-600">Tag</th>
                                    <th class="px-6 py-3 border border-gray-300 dark:border-gray-600">Add Tag</th>
                                    <th class="px-6 py-3 border border-gray-300 dark:border-gray-600">Attachment</th>
                                    <th class="px-6 py-3 border border-gray-300 dark:border-gray-600">Add Attachment</th>
                                    <th class="px-6 py-3 border-b border-gray-300 dark:border-gray-600"></th>
                                </tr>
                            </thead>

                            <!--Filtre déroulant avec cases à cocher-->
                            <div x-data="{ open: false }" class="relative inline-block text-left mb-4">
                                <form method="GET" action="{{ route('notes.index') }}">
                                    <div>
                                        <button type="button"
                                            @click="open = !open"
                                            class="inline-flex justify-between w-60 rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                                            Filter by Tags
                                            <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Dérouler -->
                                    <div x-show="open" @click.away="open = false"
                                        class="origin-top-left absolute mt-2 w-60 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                        <div class="p-4 space-y-2 max-h-60 overflow-y-auto">
                                            @foreach ($tags as $tag)
                                                <label class="flex items-center space-x-2">
                                                    <input type="checkbox" name="tags[]" value="{{ $tag->name }}"
                                                        class="form-checkbox text-blue-600 rounded"
                                                        {{ in_array($tag->name, $selectedTags ?? []) ? 'checked' : '' }}>
                                                    <span class="text-sm text-gray-800">{{ $tag->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                        <div class="px-4 py-2 border-t text-right">
                                            <button type="submit"
                                                class="px-4 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                                                Apply
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <tbody>
                                @foreach($notes as $note)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                        <!-- Title -->
                                        <td class="px-6 py-4 border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-900 dark:text-white">{{ $note->title }}</td>
                                        <!-- Content -->
                                        <td class="px-6 py-4 border border-gray-300 dark:border-gray-600 text-sm text-gray-700 dark:text-gray-400">{{ Str::limit($note->content_markdown, 50) }}</td>
                                        <!-- Barcode -->
                                        <td class="px-6 py-4 border-b border-r border-gray-300 dark:border-gray-600 text-sm space-y-3">
                                        @php
                                            $barcode = new \Milon\Barcode\DNS1D();
                                        @endphp
                                        {!! $barcode->getBarcodeHTML((string)$note->note_id, 'C128', 2.5, 50) !!}
                                        <p class="text-xs mt-1 text-center">{{ $note->note_id }}</p>
                                        </td>                                      
                                        <!-- Tags -->
                                        <td class="px-6 py-4 border border-gray-300 dark:border-gray-600 text-sm space-y-3">
                                            @foreach($note->tags->unique('name') as $tag)
                                                <div class="flex items-center justify-between">{{$tag->name}}
                                                <form action="{{ route('notes.removeTag', [$note->note_id, $tag->tag_id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white px-4 text-xs ml-2 font-medium rounded-md hover:bg-red-700 transition">x</button>
                                                </form>
                                                </div>
                                            @endforeach  
                                        </td>
                                        <td class="px-6 py-4 border border-gray-300 dark:border-gray-600 text-sm space-y-3">
                                            <div class="flex items-center justify-between">
                                                <form method="POST" action="{{ route('notes.addTag', $note->note_id) }}" class="flex items-center justify-between">
                                                    @csrf
                                                    <select name="tag_id" id="tag" class="border border-gray-300 dark:border-gray-600 rounded-md p-2 min-w-[150px] max-w-fit">
                                                            <option value="">All</option>
                                                            @foreach($tags as $tag)
                                                                <option value="{{ $tag->tag_id }}">{{ $tag->name }}</option>
                                                            @endforeach
                                                    </select>
                                                    <!-- Submit Button -->
                                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white px-4 text-xs ml-2 rounded-md hover:bg-green-700 transition">
                                                        +
                                                    </button>
                                                </form>
                                            </div>    
                                        </td>
                                        <!-- Attachments -->
                                        <td class="px-6 py-4 border-b border-r border-gray-300 dark:border-gray-600 text-sm space-y-3">
                                            @foreach($note->attachments as $attachment)
                                                <div class="flex items-center justify-between">
                                                    <a href="{{ asset('storage/' . $attachment->path) }}" target="_blank" class="text-blue-600 dark:text-blue-400 underline hover:text-blue-800 transition">{{ $attachment->filename }}</a><br>
                                                    <form action="{{ route('attachments.destroy', $attachment->attachment_id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white px-4 text-xs ml-2 rounded-md hover:bg-red-700 transition" onclick="return confirm('Are you sure you want to delete this attachment?')">x</button>
                                                    </form>
                                                </div>    
                                            @endforeach
                                        </td>
                                        
                                        <td class="px-6 py-4 border-b border-r border-gray-300 dark:border-gray-600 text-sm space-y-1">
                                            <form action="{{ route('attachments.store', $note) }}" method="POST" enctype="multipart/form-data">
                                                @csrf    
                                                <div class="form-group flex items-center justify-between">   
                                                    <input type="file" name="attachment" id="attachment" class="form-control mt-2 block w-full text-sm text-gray-700 dark:text-gray-300" required>
                                                    <!-- Submit Button -->
                                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white text-xs ml-2 rounded-md hover:bg-green-700 transition">
                                                        +
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                        <!-- Actions -->
                                        <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-600 text-sm  space-x-2 space-y-1">
                                            <div class="flex justify-end">
                                                <!-- Edit Button -->
                                            <a href="{{ route('notes.edit', $note) }}" class="mr-2 px-3 py-1 bg-yellow-500 text-white text-xs font-medium rounded-lg shadow-sm hover:bg-yellow-600 transition duration-200 ease-in-out">Edit</a>
                                            <!-- Delete Form -->
                                            <form method="POST" action="{{ route('notes.destroy', $note) }}"> 
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure?')" class="px-3 py-1 bg-red-600 text-white text-xs font-medium rounded-lg shadow-sm hover:bg-red-700 transition duration-200 ease-in-out">Delete</button>
                                            </form>
                                            </div>
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> 
                    </div>    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
