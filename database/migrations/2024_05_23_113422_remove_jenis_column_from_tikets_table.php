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
        Schema::table('tikets', function (Blueprint $table) {
            // Hapus kolom jenis dari tabel
            $table->dropColumn('jenis');
        });
    }

    public function down()
    {
        Schema::table('tikets', function (Blueprint $table) {
            // Jika Anda ingin melakukan rollback migrasi, Anda bisa menambahkan kembali kolom jenis
            $table->enum('jenis', ['regular', 'event'])->default('regular');
        });
    }

};
