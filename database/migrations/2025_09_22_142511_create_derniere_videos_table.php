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
        Schema::create('derniere_videos', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
            $table->string('youtube_id'); // Ex: vGF1cdsSxZI
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('derniere_videos');
    }
};
