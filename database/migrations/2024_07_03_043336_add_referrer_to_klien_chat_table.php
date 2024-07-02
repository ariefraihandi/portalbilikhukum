<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferrerToKlienChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('klien_chat', function (Blueprint $table) {
            $table->string('referrer')->nullable()->after('id_office'); // Tambahkan kolom referrer setelah kolom is_followed_up
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('klien_chat', function (Blueprint $table) {
            $table->dropColumn('referrer'); // Hapus kolom referrer jika migration dibatalkan
        });
    }
}
