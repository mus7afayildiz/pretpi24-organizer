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
        // Table des tag
        Schema::create('t_tag', function (Blueprint $table) {
            $table->id('tag_id');
            $table->string('name')->unique();
            $table->index('name');
            $table->timestamps();
        }); 
    }
        

    public function down(): void
    {
        Schema::dropIfExists('t_tag');
    }
};
