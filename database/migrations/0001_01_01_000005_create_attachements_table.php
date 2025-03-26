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
    Schema::create('attachements', function (Blueprint $table) {
        $table->id();
        $table->string('nom_fichier');
        $table->string('chemin');
        $table->string('type_mime');
        $table->foreignId('note_id')->constrained()->onDelete('cascade');
    });     
    }
        

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
