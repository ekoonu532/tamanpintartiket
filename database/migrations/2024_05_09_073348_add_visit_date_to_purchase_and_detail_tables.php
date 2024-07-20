<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisitDateToPurchaseAndDetailTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::table('detail_pembelian', function (Blueprint $table) {
            $table->date('tanggal_kunjungan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::table('detail_pembelian', function (Blueprint $table) {
            $table->dropColumn('tanggal_kunjungan');
        });
    }
}

