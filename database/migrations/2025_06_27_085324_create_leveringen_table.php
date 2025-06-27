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
        Schema::create('leveringen', function (Blueprint $table) {
            $table->id('levering_id');
            $table->foreignId('leverancier_id')->constrained('leveranciers', 'leverancier_id');
            $table->date('leveringsdatum');
            $table->enum('status', ['gepland', 'onderweg', 'geleverd', 'geannuleerd'])->default('gepland');
            $table->text('opmerkingen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leveringen');
    }
};
