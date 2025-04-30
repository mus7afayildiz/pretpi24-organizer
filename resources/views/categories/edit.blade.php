<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category Edit') }} 
        </h2>
    </x-slot>
 
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="font-semibold dark:text-white leading-tight text-gray-800">
                    <form method="POST" action="{{ route('categories.update', $category) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                value="{{ old('name', $category->name) }}" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white"
                                required
                            >
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('categories.index') }}" 
                            class="mr-4 px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-600 transition">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded hover:bg-indigo-700 transition">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>