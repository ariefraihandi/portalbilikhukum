<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterEmailKantorUniqueInOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offices', function (Blueprint $table) {
            // Menambahkan indeks unik ke kolom email_kantor
            $table->string('email_kantor')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offices', function (Blueprint $table) {
            // Menghapus indeks unik dari kolom email_kantor
            $table->dropUnique(['email_kantor']);
            $table->string('email_kantor')->change();
        });
    }
}
