<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Note') }} 
        </h2>
    </x-slot>
 
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">

                    <form method="POST" action="{{ route('notes.update', $note) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div>
                            <label for="title" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Title</label>
                            <input type="text" name="title" id="title" value="{{ $note->title }}" 
                                   class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                        </div>

                        <!-- Content -->
                        <div>
                            <label for="content_markdown" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Content</label>
                            <textarea name="content_markdown" id="content_markdown"
                                      class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200"
                                      rows="4">{{ $note->content_markdown }}</textarea>
                        </div>

                        <!-- Tags -->
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tags</label>
                            <input type="text" name="tag" id="tag" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <div id="tag-list" class="flex flex-wrap gap-2 mt-1">
                                @foreach($note->tags as $tag)
                                    <span class="inline-flex items-center bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">
                                        {{ $tag->name }}
                                        <button type="button" onclick="removeTag({{ $tag->tag_id }})" class="ml-2 text-red-500">✕</button>
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Attachments -->
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Attachments</label>
                            <ul class="mt-2 space-y-2">
                                @foreach($note->attachments as $attachment)
                                    <li class="flex items-center justify-between p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                        <a href="{{ asset($attachment->path) }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 transition">
                                            {{ $attachment->filename }}
                                        </a>
                                        <button type="button" onclick="removeAttachment({{ $attachment->attachment_id }})" class="ml-2 text-red-500 text-xs">Remove</button>
                                    </li>
                                @endforeach
                            </ul>
                            <input type="file" name="attachments[]" multiple class="mt-2 block w-full text-sm text-gray-700 dark:text-gray-300">
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="submit"
                                    class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition duration-200">
                                Save Changes
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Javascript for Tag & Attachment Removal -->
<script>
    function removeTag(tagId) {
        if (confirm('Are you sure you want to remove this tag?')) {
            fetch(`/tags/${tagId}/detach`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                .then(response => response.json())
                .then(data => location.reload());
        }
    }

    function removeAttachment(attachmentId) {
        if (confirm('Are you sure you want to remove this attachment?')) {
            fetch(`/attachments/${attachmentId}/delete`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                .then(response => response.json())
                .then(data => location.reload());
        }
    }
</script>