<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailingListsKlienTable extends Migration
{
    public function up()
    {
        Schema::create('mailing_lists_klien', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('klien_id');
            $table->string('email');
            $table->string('status')->default('active');
            $table->timestamps();

            // Tambahkan foreign key
            $table->foreign('klien_id')->references('id')->on('klien_chat')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mailing_lists_klien');
    }
}
