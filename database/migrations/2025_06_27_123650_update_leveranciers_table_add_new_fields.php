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
        Schema::table('leveranciers', function (Blueprint $table) {
            // Nieuwe velden toevoegen volgens docent eisen
            $table->string('leveranciernummer')->unique()->after('leverancier_id');
            $table->enum('leveranciertype', ['supermarkten', 'groothandelaars', 'boeren'])->after('telefoonnummer');
            $table->text('opmerking')->nullable()->after('leveranciertype');
            
            // Hernoem 'actief' naar 'isactief' voor consistentie met de eisen
            $table->renameColumn('actief', 'isactief');
            
            // Timestamps hernoemen naar Nederlandse namen
            $table->renameColumn('created_at', 'datum_aangemaakt');
            $table->renameColumn('updated_at', 'datum_gewijzigd');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leveranciers', function (Blueprint $table) {
            // Verwijder nieuwe velden
            $table->dropColumn(['leveranciernummer', 'leveranciertype', 'opmerking']);
            
            // Herstel oude kolomnamen
            $table->renameColumn('isactief', 'actief');
            $table->renameColumn('datum_aangemaakt', 'created_at');
            $table->renameColumn('datum_gewijzigd', 'updated_at');
        });
    }
};
