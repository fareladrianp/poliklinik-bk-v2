<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daftar_poli', function (Blueprint $table) {
            $table->integer('status')->default(0)->after('no_antrian'); // Tambahkan kolom status setelah no_antrian
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daftar_poli', function (Blueprint $table) {
            $table->dropColumn('status'); // Hapus kolom status jika migrasi dibatalkan
        });
    }
};
