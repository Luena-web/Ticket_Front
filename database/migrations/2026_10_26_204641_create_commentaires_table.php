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
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id();
            //Le ticket auquel est lié le commentaire
            $table->foreignid('ticket_id')->constrained('tickets')->onDelete('cascade');

//L'utilisateur auquel est lié le commentaire
            $table->foreignid('utilisateur_id')->constrained('utilisateurs')->onDelete('cascade');
             $table->text('message'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commentaires');
    }
};
