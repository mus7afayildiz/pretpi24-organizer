<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Note Create') }} 
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">
                    <form method="POST" action="{{ route('notes.store') }}" enctype="multipart/form-data"> 
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{Auth::user()->id}}">

                        <!-- Title -->
                        <div>   
                            <label for="title" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Title</label>
                            <input type="text" name="title" id="title" class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                        </div>

                        <!-- Content -->
                        <div> 
                            <label for="content_markdown" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Content</label>
                            <textarea name="content_markdown" id="content_markdown" id="content_markdown"  class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200" rows="4"></textarea>
                        </div>

                        <!-- Tags -->
                        <div> 
                            <label for="tag" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tag</label>
                            <input type="text" name="tag" id="tag" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>

                        <!-- Attachments -->
                        <div> 
                            <div>
                                <label for="attachment" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Attachement name:</label>
                            </div>
                            <input type="file" name="attachment" id="attachment" class="mt-2 block w-full text-sm text-gray-700 dark:text-gray-300">
                        </div>
                            
                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition duration-200">
                                Save
                            </button>
                        </div>                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>