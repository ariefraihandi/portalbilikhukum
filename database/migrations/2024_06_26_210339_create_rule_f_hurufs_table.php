<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuleFHurufsTable extends Migration
{
    public function up()
    {
        Schema::create('rule_f_hurufs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rule_e_ayat_id'); // Menggunakan unsignedBigInteger untuk ID
            $table->text('huruf_content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rule_f_hurufs');
    }
};