<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notes') }}
        </h2>
    </x-slot>

    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">
                <!-- Search Bar -->
                @include('components.search-bar')
                    <!-- Add New Note Button -->
                    <div class="flex justify-end">
                        <a href="{{ route('notes.create') }}" 
                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            + Add New Note
                        </a>
                    </div> 
                    <!-- Notes Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse border border-gray-300 dark:border-gray-700">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700 text-left text-sm font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    <th class="px-6 py-3 border border-gray-300 dark:border-gray-600">Titre</th>
                                    <th class="px-6 py-3 border border-gray-300 dark:border-gray-600">Text</th>
                                    <th class="px-6 py-3 border border-gray-300 dark:border-gray-600">Tag</th>
                                    <th class="px-6 py-3 border-b border-gray-300 dark:border-gray-600">Attachement</th>
                                    <th class="px-6 py-3 border-b border-gray-300 dark:border-gray-600"></th>
                                </tr>
                            </thead>

                            <!-- Tag Filter -->
                            <div class="mb-4">
                                <form method="GET" action="{{ route('notes.index') }}">
                                    <label for="tag" class="font-semibold text-gray-700 dark:text-gray-300">Filter by Tag:</label>
                                    <select name="tag" id="tag" class="border border-gray-300 dark:border-gray-600 rounded-md p-2 min-w-[150px] max-w-fit">
                                        <option value="">All</option>
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->name }}" {{ request('tag') == $tag->name ? 'selected' : '' }}>
                                                <span class="inline-flex items-center bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 whitespace-nowrap">{{ $tag->name }}</span>
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                        Filter
                                    </button>
                                </form>
                            </div>


                            <tbody>
                                @foreach($notes as $note)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                        <!-- Title -->
                                        <td class="px-6 py-4 border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-900 dark:text-white">{{ $note->title }}</td>
                                        <!-- Content -->
                                        <td class="px-6 py-4 border border-gray-300 dark:border-gray-600 text-sm text-gray-700 dark:text-gray-400">{{ Str::limit($note->content_markdown, 50) }}</td>
                                        <!-- Tags -->
                                        <td class="px-6 py-4 border border-gray-300 dark:border-gray-600 text-sm space-x-2">
                                            @foreach($note->tags as $tag)
                                                <span >{{ $tag->name }}</span>
                                            @endforeach
                                            {{ $tag->name }}
                                        </td>
                                        <!-- Attachments -->
                                        <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-600 text-sm space-y-1 ">
                                            @foreach($note->attachments as $attachment)
                                                <a href="{{ asset($attachment->path) }}" target="_blank" class="text-blue-600 dark:text-blue-400 underline hover:text-blue-800 transition">{{ $attachment->filename }}</a><br>
                                            @endforeach
                                        </td>
                                        <!-- Actions -->
                                        <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-600 text-sm flex justify-end space-x-2">
                                            <!-- Edit Button -->
                                            <a href="{{ route('notes.edit', $note) }}" class="px-3 py-1 bg-yellow-500 text-white text-xs font-medium rounded-lg shadow-sm hover:bg-yellow-600 transition duration-200 ease-in-out">Edit</a>
                                            <!-- Delete Form -->
                                            <form method="POST" action="{{ route('notes.destroy', $note) }}"> 
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure?')" class="px-3 py-1 bg-red-600 text-white text-xs font-medium rounded-lg shadow-sm hover:bg-red-700 transition duration-200 ease-in-out">Delete</button>
                                            </form>
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
