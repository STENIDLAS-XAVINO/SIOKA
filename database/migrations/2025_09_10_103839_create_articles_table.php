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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date');
            $table->string('cat');
            $table->string('author');
            $table->enum('status', ['brouillon', 'publie'])->default('brouillon');
            $table->text('excerpt')->nullable(); //extrait
            $table->longText('content')->nullable(); // contenu complet
            $table->string('url')->nullable();
            $table->string('image')->nullable(); // chemin de l’image
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
