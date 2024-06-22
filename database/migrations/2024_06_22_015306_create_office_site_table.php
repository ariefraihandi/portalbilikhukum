<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeSiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_site', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('office_id');
            $table->string('office_name');
            $table->string('logo_image')->nullable();
            $table->string('owner_image')->nullable();
            $table->string('owner_sec_image')->nullable();
            $table->string('icon_image')->nullable();
            $table->string('tagline')->nullable();
            $table->string('aboutMe_title')->nullable();
            $table->text('aboutMe_description')->nullable();
            $table->json('aboutMe_legalcategory')->nullable();
            $table->timestamps();
            
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('office_site');
    }
}
