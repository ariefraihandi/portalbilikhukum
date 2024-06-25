<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuleATypesTable extends Migration
{
    public function up()
    {
        Schema::create('rule_a_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // Ubah dari enum ke string
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rule_a_types');
    }
}
