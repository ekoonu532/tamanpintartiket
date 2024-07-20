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
        Schema::create('tiket_kuotas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tiket_id');
            $table->date('tanggal');
            $table->integer('kuota');
            $table->timestamps();

            $table->foreign('tiket_id')->references('tiket_id')->on('tikets')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiket_kuotas');
    }
};
