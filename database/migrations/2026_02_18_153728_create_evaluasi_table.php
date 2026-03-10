<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jurnal_id')
                ->constrained('jurnal')
                ->cascadeOnDelete();

            $table->foreignId('kepsek_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->integer('nilai');
            $table->text('catatan')->nullable();

            $table->timestamps();

            // Satu jurnal hanya bisa dievaluasi satu kali
            $table->unique('jurnal_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluasi');
    }
};