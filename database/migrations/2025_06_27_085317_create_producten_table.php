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
        Schema::create('producten', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('naam');
            $table->string('streepjescode')->unique();
            $table->integer('aantal_in_voorraad')->default(0);
            $table->date('houdbaar_tot')->nullable();
            $table->foreignId('categorie_id')->constrained('productcategorieen', 'categorie_id');
            $table->foreignId('leverancier_id')->constrained('leveranciers', 'leverancier_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producten');
    }
};
