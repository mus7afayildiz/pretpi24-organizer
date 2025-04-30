<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-100">Tag List</h3>
                    <a href="{{ route('categories.create') }}"
                       class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        + Add New Category
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Tag Id
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Created Date
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Updated Date
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 ">
                            @forelse($categories as $category)
                                <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 ">
                                        {{ $category->tag_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $category->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $category->created_at }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $category->updated_at }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-wrap text-sm text-right flex gap-2 justify-end">
                                        <a href="{{ route('categories.edit', $category) }}"
                                           class="mr-2 px-3 py-1 bg-yellow-500 text-white text-xs font-medium rounded-lg shadow-sm hover:bg-yellow-600 transition duration-200 ease-in-out">Edit</a>
                                        <form method="POST" action="{{ route('tag.destroy', $category->tag_id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1 bg-red-600 text-white text-xs font-medium rounded-lg shadow-sm hover:bg-red-700 transition duration-200 ease-in-out"
                                                    onclick="return confirm('Are you sure?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No categories found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
