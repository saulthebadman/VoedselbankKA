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
            // Voeg nieuwe velden toe volgens docent eisen
            $table->string('leveranciernummer')->unique()->after('leverancier_id');
            $table->enum('leveranciertype', ['supermarkten', 'groothandelaars', 'boeren'])->after('bedrijfsnaam');
            $table->text('opmerking')->nullable()->after('actief');
            
            // Hernoem actief naar isactief
            $table->renameColumn('actief', 'isactief');
            
            // Voeg datum_aangemaakt en datum_gewijzigd toe
            $table->timestamp('datum_aangemaakt')->after('opmerking')->useCurrent();
            $table->timestamp('datum_gewijzigd')->after('datum_aangemaakt')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leveranciers', function (Blueprint $table) {
            $table->dropColumn(['leveranciernummer', 'leveranciertype', 'opmerking', 'datum_aangemaakt', 'datum_gewijzigd']);
            $table->renameColumn('isactief', 'actief');
        });
    }
};
