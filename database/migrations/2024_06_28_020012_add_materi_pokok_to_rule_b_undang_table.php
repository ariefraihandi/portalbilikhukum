<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMateriPokokToRuleBUndangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rule_b_undang', function (Blueprint $table) {
            $table->text('materi_pokok')->after('tentang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rule_b_undang', function (Blueprint $table) {
            $table->dropColumn('materi_pokok');
        });
    }
}
