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
    // Table des fichiers attachés
    Schema::create('t_attachment', function (Blueprint $table) {
        $table->id('attachment_id');
        $table->string('filename');
        $table->string('path');
        $table->foreignIdFor(\App\Models\Note::class, 'note_id')->constrained('t_note')->onDelete('cascade');
    });     
    }
        

    public function down(): void
    {
        Schema::dropIfExists('t_attachment');
    }
};
