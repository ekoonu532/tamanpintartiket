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
        Schema::table('detail_pembelian', function (Blueprint $table) {
            $table->date('tanggal_kunjungan')->nullable()->after('subtotal');
        });
    }

    public function down()
    {
        Schema::table('detail_pembelian', function (Blueprint $table) {
            $table->dropColumn('tanggal_kunjungan');
        });
    }
};
