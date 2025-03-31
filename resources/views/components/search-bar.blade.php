<!-- Search Bar -->
<div class="mb-4">
    <form method="GET" action="{{ route('notes.index') }}" class="flex items-center space-x-2">
        <input type="text" name="search" placeholder="Search notes..." 
            value="{{ request('search') }}"
            class="border border-gray-300 dark:border-gray-600 rounded-md p-2 w-1/3 focus:ring focus:ring-blue-300">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Search
        </button>
    </form>
</div>


