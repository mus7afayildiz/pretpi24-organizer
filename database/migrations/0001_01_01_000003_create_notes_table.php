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
            $table->string('title');
            $table->text('content')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('notes')->onDelete('cascade');
            $table->timestamps();
        });

        // Table des tags
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });

        // Table pivot Note <-> Tag
        Schema::create('note_tag', function (Blueprint $table) {
            $table->foreignId('note_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->primary(['note_id', 'tag_id']);
        });

        // Table des fichiers attachés
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('note_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->timestamps();
        });
    }
        

    public function down(): void
    {
        Schema::dropIfExists('attachments');
        Schema::dropIfExists('note_tag');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('notes');
    }
};
