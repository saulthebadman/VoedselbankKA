<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('klant_wensen', function (Blueprint $table) {
            $table->unsignedInteger('klant_id');
            $table->enum('wens_type', ['geen_varkensvlees', 'allergisch_gluten', 'allergisch_pinda', 'allergisch_schaaldieren', 'allergisch_hazelnoten', 'allergisch_lactose', 'allergisch_overig', 'veganistisch', 'vegetarisch']);
            $table->text('omschrijving')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->primary(['klant_id', 'wens_type']);
            $table->foreign('klant_id')->references('klant_id')->on('klanten')->onDelete('cascade');
        });
    }
    public function down(): void {
        Schema::dropIfExists('klant_wensen');
    }
};
