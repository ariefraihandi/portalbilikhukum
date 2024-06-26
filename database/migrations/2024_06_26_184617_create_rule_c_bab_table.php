<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuleCBabTable extends Migration
{
    public function up()
    {
        Schema::create('rule_c_bab', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rule_b_undang_id')->constrained('rule_b_undang');
            $table->integer('bab_ke');
            $table->string('bab_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rule_c_bab');
    }
}
