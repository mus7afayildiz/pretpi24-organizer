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
        Schema::create('t_note', function (Blueprint $table) {
            $table->id('note_id');
            $table->string('title');
            $table->text('content_markdown');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->foreignIdFor(\App\Models\User::class,'id')->constrained('users')->onDelete('cascade');
            $table->index('title');
            $table->fullText('content_markdown');
        });

        // Table pivot Note <-> Tag
        Schema::create('add', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Note::class, 'note_id')->constrained('t_note')->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Tag::class, 'tag_id')->constrained('t_tag')->onDelete('cascade');
            // Clé primaire composite
            $table->primary(['note_id', 'tag_id']);
        });
    }
        

    public function down(): void
    {
        Schema::dropIfExists('t_note');
        Schema::dropIfExists('add');
    }
};
