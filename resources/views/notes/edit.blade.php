<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Note Edit') }} 
        </h2>
    </x-slot>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('notes.update', $note) }}"> 
                        @csrf
                        @method('PUT')
                        <div class="flex items-center gap-4">
                            <div> 
                                <input type="hidden" name="id" id="id" value="{{Auth::user()->id}}">
                                <div>
                                    <label for="title">Titre:</label>
                                </div>
                                <input type="text" name="title" id="title" value="{{ $note->title }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            </div>
                            <div> 
                                <div>
                                    <label for="content_markdown">Text:</label>
                                </div>
                                <input type="text" name="content_markdown" id="content_markdown" value="{{ $note->content_markdown }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Save
                            </button>
                        </div>                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>