<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveKlienIdFromMailingListsKlien extends Migration
{
    public function up()
    {
        Schema::table('mailing_lists_klien', function (Blueprint $table) {
            // Pastikan foreign key sudah ada sebelum mencoba drop
            if (Schema::hasColumn('mailing_lists_klien', 'klien_id')) {
                $table->dropForeign(['klien_id']); // Drop foreign key constraint if exists
                $table->dropColumn('klien_id'); // Drop the column
            }
        });
    }

    public function down()
    {
        Schema::table('mailing_lists_klien', function (Blueprint $table) {
            if (!Schema::hasColumn('mailing_lists_klien', 'klien_id')) {
                $table->unsignedBigInteger('klien_id')->nullable();
                $table->foreign('klien_id')->references('id')->on('klien_chat')->onDelete('cascade');
            }
        });
    }
}
