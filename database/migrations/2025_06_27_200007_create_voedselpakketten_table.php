<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('voedselpakketten', function (Blueprint $table) {
            $table->increments('pakket_id');
            $table->string('pakket_nummer', 20)->unique();
            $table->unsignedInteger('klant_id');
            $table->date('samensteldatum');
            $table->date('uitgiftedatum')->nullable();
            $table->enum('status', ['samengesteld', 'klaar_voor_uitgifte', 'uitgegeven'])->default('samengesteld');
            $table->text('opmerkingen')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->foreign('klant_id')->references('klant_id')->on('klanten')->restrictOnDelete();
            $table->index('klant_id', 'idx_pakketten_klant');
            $table->index('samensteldatum', 'idx_pakketten_datum');
            $table->index('status', 'idx_pakketten_status');
        });
    }
    public function down(): void {
        Schema::dropIfExists('voedselpakketten');
    }
};
