<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuleCaBagianTable extends Migration
{
    public function up()
    {
        Schema::create('rule_ca_bagian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rule_b_undang_id')->nullable();
            $table->unsignedBigInteger('id_bab')->nullable(); 
            $table->string('bagian_name');
            $table->string('bagian_ke');
            $table->timestamps();

            // Tidak ada foreign key constraint di sini
        });
    }

    public function down()
    {
        Schema::dropIfExists('rule_ca_bagian');
    }
}

