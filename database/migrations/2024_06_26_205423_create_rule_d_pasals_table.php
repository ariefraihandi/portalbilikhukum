<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuleDPasalsTable extends Migration
{
    public function up()
    {
        Schema::create('rule_d_pasals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rule_c_bab_id'); // Menggunakan unsignedBigInteger untuk ID
            $table->string('rule_ca_bagian_id')->nullable(); // Menggunakan unsignedBigInteger untuk ID
            $table->string('pasal_content');
            $table->string('pasal_ke');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rule_d_pasals');
    }
}
