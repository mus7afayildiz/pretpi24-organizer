<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Table des notes
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('contenu_markdown');
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamp('date_modification')->useCurrent()->useCurrentOnUpdate();
            $table->foreignId('parent_id')->nullable()->constrained('notes');
            $table->foreignId('users_id')->constrained('users');
            $table->index('titre');
            $table->fullText('contenu_markdown');
        });

        // Table pivot Note <-> Tag
        Schema::create('note_tag', function (Blueprint $table) {
            $table->foreignId('note_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->primary(['note_id', 'tag_id']);
        });
    }
        

    public function down(): void
    {
        Schema::dropIfExists('notes');
        Schema::dropIfExists('note_tag');
    }
};
