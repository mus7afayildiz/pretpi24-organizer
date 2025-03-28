<div class="note-level-{{ $level }}">
    <div class="note-header">
        <h3>{{ $note->titre }}</h3>
        <div class="note-actions">
            <a href="{{ route('notes.edit', $note->id) }}" class="btn-edit">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('notes.destroy', $note->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-delete">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
</div>
