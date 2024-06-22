<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeGalleriesTable extends Migration
{
    public function up()
    {
        Schema::create('office_galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('office_id');
            $table->string('short_title');
            $table->string('title');
            $table->text('description');
            $table->string('image_file');
            $table->timestamps();

            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('office_galleries');
    }
};