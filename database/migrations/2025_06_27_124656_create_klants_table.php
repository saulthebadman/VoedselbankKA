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
        Schema::create('klanten', function (Blueprint $table) {
            $table->increments('klant_id');
            $table->string('gezinsnaam');
            $table->string('voornaam');
            $table->string('achternaam');
            $table->string('straat');
            $table->string('huisnummer', 10);
            $table->string('postcode', 10);
            $table->string('plaats');
            $table->string('telefoonnummer', 50);
            $table->string('email')->nullable();
            $table->integer('aantal_volwassenen')->default(1);
            $table->integer('aantal_kinderen')->default(0);
            $table->integer('aantal_babies')->default(0);
            $table->boolean('actief')->default(true);
            $table->date('aanmelddatum')->nullable(); // default CURRENT_DATE niet toegestaan in MySQL
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->index('postcode', 'idx_klanten_postcode');
            $table->index('actief', 'idx_klanten_actief');
            $table->index('gezinsnaam', 'idx_klanten_gezinsnaam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klanten');
    }
};
