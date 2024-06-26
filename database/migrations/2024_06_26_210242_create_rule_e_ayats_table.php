<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuleEAyatsTable extends Migration
{
    public function up()
    {
        Schema::create('rule_e_ayats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rule_d_pasal_id'); // Menggunakan unsignedBigInteger untuk ID
            $table->text('ayat_content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rule_e_ayats');
    }
}
