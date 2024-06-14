<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKlienChatTable extends Migration
{
    public function up()
    {
        Schema::table('klien_chat', function (Blueprint $table) {
            // Hapus kolom
            $table->dropColumn('chat_history');
            $table->dropColumn('is_followed_up');

            // Tambah kolom baru setelah status
            $table->decimal('budget', 30, 2)->nullable()->after('status');
            $table->decimal('new_budget', 30, 2)->nullable()->after('budget');
            $table->string('nomor_perkara')->nullable()->after('new_budget');
        });
    }

    public function down()
    {
        Schema::table('klien_chat', function (Blueprint $table) {
            // Tambah kembali kolom yang dihapus
            $table->text('chat_history')->nullable();
            $table->boolean('is_followed_up')->default(false);

            // Hapus kolom baru
            $table->dropColumn('budget');
            $table->dropColumn('new_budget');
            $table->dropColumn('nomor_perkara');
        });
    }
}
