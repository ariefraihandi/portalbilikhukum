<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVillagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('villages', function (Blueprint $table) {
            $table->id(); // Primary key, auto-increment
            $table->string('district_code');
            $table->string('code')->unique(); // Kode desa/kelurahan
            $table->string('name'); // Nama desa/kelurahan
            $table->timestamps(); // Kolom created_at dan updated_at

            // Menambahkan foreign key secara manual
            $table->foreign('district_code')->references('code')->on('districts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->dropIfExists('villages');
    }
};