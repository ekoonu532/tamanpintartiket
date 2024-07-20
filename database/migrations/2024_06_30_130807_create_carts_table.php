<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('tiket_id'); // Pastikan tipe data sesuai dengan kolom tiket_id di tabel tikets
            $table->integer('quantity_anak')->default(0);
            $table->integer('quantity_dewasa')->default(0);
            $table->decimal('harga_anak', 10, 2);
            $table->decimal('harga_dewasa', 10, 2);
            $table->timestamps();

            // Adding foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tiket_id')->references('tiket_id')->on('tikets')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
