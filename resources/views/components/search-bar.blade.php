<form action="{{ route('notes.index') }}" method="GET">
    <div class="search-container">
        <input type="text" name="q" placeholder="Rechercher dans les notes..." value="{{ request('q') }}">
        <button type="submit">
            <i class="fas fa-search"></i>
        </button>
    </div>
</form>

