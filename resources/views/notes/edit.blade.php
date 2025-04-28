    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Note') }} 
            </h2>
        </x-slot>

        <head><meta name="csrf-token" content="{{ csrf_token() }}"></head>

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
                                    @foreach($note->tags->unique('name') as $tag)
                                        <span class="inline-flex items-center bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">
                                            {{ $tag->name }}
                                            <button 
                                                type="button" 
                                                class="ml-2 text-red-500"
                                                onclick="removeTag({{ $tag->tag_id }}, {{ $note->note_id }})"
                                            >
                                                ✕
                                            </button>
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Attachments -->
                            <div>
                                <label for="attachment" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Attachments</label>
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
                                <input type="file" name="attachment" id="attachment" class="mt-2 block w-full text-sm text-gray-700 dark:text-gray-300">
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-4">
                                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition duration-200">
                                    Save Changes
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

    <!-- Javascript pour la suppression des balises et des pièces jointes -->
    <script>
        function removeTag(tagId, noteId) {
            if (confirm('Are you sure you want to delete this tag?')) {
                fetch(`/notes/${noteId}/tags/${tagId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Could not delete tag');
                    return response.json();
                })
                .then(data => {
                    alert(data.message || 'Tag deleted');
                    location.reload();
                })
                .catch(error => {
                    console.error(error);
                    alert('An error occurred');
                });
            }
        }

            // Fonction de suppression de pièce jointe à l'aide de fetch
        function removeAttachment(attachmentId) {
            if (confirm('Are you sure you want to remove this attachment?')) {
                fetch(`/attachments/${attachmentId}/delete`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
            if (!response.ok) throw new Error('Could not remove attachment');
            return response.json();
        })
                .then(data => {
                    // Actualisez la page ou mettez à jour l'interface utilisateur selon vos besoins
                    alert('Attachment removed successfully');
                    location.reload(); // Rafraîchir la page
                })
            }
            location.reload();
        }
    
    </script>