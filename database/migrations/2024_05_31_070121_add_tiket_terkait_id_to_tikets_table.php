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
            $table->uuid('tiket_terkait_id')->nullable()->after('tiket_id');
            $table->foreign('tiket_terkait_id')->references('tiket_id')->on('tikets')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('tikets', function (Blueprint $table) {
            $table->dropForeign(['tiket_terkait_id']);
            $table->dropColumn('tiket_terkait_id');
        });
    }
};
