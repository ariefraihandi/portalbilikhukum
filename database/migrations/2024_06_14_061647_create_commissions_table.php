<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionsTable extends Migration
{
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->string('referral_id'); // ID referral dari tabel refferalcode
            $table->string('note'); // Catatan yang menjelaskan sumber komisi
            $table->string('type'); // Tipe komisi, misalnya "perkara pengacara"
            $table->decimal('commission_amount', 10, 2); // Jumlah komisi
            $table->timestamps();
           
        });
    }

    public function down()
    {
        Schema::dropIfExists('commissions');
    }
}
