<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuleGAngkasTable extends Migration
{
    public function up()
    {
        Schema::create('rule_g_angkas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rule_f_huruf_id'); // Menggunakan unsignedBigInteger untuk ID
            $table->text('angka_content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rule_g_angkas');
    }
};