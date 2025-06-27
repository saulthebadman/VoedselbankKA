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
        Schema::create('leveranciers', function (Blueprint $table) {
            $table->id('leverancier_id');
            $table->string('bedrijfsnaam');
            $table->string('adres');
            $table->string('contactpersoon_naam');
            $table->string('email');
            $table->string('telefoonnummer');
            $table->timestamp('eerstvolgende_levering')->nullable();
            $table->boolean('actief')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leveranciers');
    }
};
