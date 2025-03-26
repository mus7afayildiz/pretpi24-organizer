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
        // Table des tags
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->index('nom');
        }); 
    }
        

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
