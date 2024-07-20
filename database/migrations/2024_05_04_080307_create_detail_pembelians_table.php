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

        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pembelian_id');
            $table->uuid('tiket_id');
            $table->integer('jumlah');
            $table->string('keterangan');
            $table->date('tanggal_kunjungan');
            $table->decimal('harga_satuan', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();

            $table->foreign('pembelian_id')->references('id')->on('pembelian_tikets')->onDelete('cascade');
            $table->foreign('tiket_id')->references('tiket_id')->on('tikets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelians');
    }
};
