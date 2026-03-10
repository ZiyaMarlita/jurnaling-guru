<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurnal', function (Blueprint $table) {
            $table->id();

            $table->foreignId('guru_id')
                ->constrained('guru')
                ->cascadeOnDelete();

            $table->date('tanggal')->index();
            $table->string('jam_pelajaran');
            $table->string('mata_pelajaran')->index();
            $table->string('kelas')->index();
            $table->text('materi');
            $table->text('kendala')->nullable();

            // FIX: kolom 'nilai' dihapus — nilai disimpan di tabel 'evaluasi'
            // FIX: status hanya didefinisikan sekali di sini (hapus migration alter duplikat)
            $table->enum('status', ['pending', 'dinilai', 'revisi'])
                ->default('pending')
                ->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurnal');
    }
};