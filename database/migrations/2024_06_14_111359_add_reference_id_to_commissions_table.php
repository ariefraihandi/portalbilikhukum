<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferenceIdToCommissionsTable extends Migration
{
    public function up()
    {
        Schema::table('commissions', function (Blueprint $table) {
            // Menambahkan kolom reference_id
            $table->string('reference_id')->after('commission_amount')->nullable();
        });
    }

    public function down()
    {
        Schema::table('commissions', function (Blueprint $table) {
            // Menghapus kolom reference_id
            $table->dropColumn('reference_id');
        });
    }
};