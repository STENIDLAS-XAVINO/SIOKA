<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('flash_infos', function (Blueprint $table) {
            $table->id();
            $table->text('contenu');
            $table->date('date_publication');
            $table->enum('statut', ['publie', 'brouillon'])->default('brouillon');
            $table->string('categorie');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flash_infos');
    }
};
