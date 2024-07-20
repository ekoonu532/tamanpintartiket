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
        Schema::create('tikets', function (Blueprint $table) {
            $table->uuid('tiket_id')->primary();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('slug')->unique();
            $table->unsignedBigInteger('kategori_tiket_id');
            // $table->enum('jenis', ['event', 'wahana', 'program_kreativitas']);
            $table->dateTime('tanggal_mulai')->nullable();
            $table->dateTime('tanggal_selesai')->nullable();
            $table->string('gambar')->nullable();
            $table->decimal('harga_anak', 10, 2)->nullable(); // Harga tiket untuk anak
            $table->decimal('harga_dewasa', 10, 2)->nullable(); // Harga tiket untuk dewasa
            $table->integer('kuota')->default(0);
            $table->integer('usia_minimal')->nullable();
            // $table->unsignedBigInteger('tiket_terkait_id')->nullable();
            $table->timestamps();

            $table->foreign('kategori_tiket_id')->references('kategori_tiket_id')->on('kategori_tikets');
            // $table->foreign('tiket_terkait_id')->references('tiket_id')->on('tikets')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
