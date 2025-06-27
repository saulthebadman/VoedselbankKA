<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('pakket_producten', function (Blueprint $table) {
            $table->unsignedInteger('pakket_id');
            $table->unsignedInteger('product_id');
            $table->integer('aantal');
            $table->timestamp('created_at')->useCurrent();
            $table->primary(['pakket_id', 'product_id']);
            $table->foreign('pakket_id')->references('pakket_id')->on('voedselpakketten')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('producten')->restrictOnDelete();
        });
    }
    public function down(): void {
        Schema::dropIfExists('pakket_producten');
    }
};
