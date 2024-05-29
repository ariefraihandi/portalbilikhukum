<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegenciesTable extends Migration
{
    public function up()
    {
        Schema::connection('mysql')->create('regencies', function (Blueprint $table) {
            $table->id(); // Primary key, auto-increment
            $table->string('province_code');
            $table->string('code')->unique(); // Kode kabupaten/kota
            $table->string('name'); // Nama kabupaten/kota
            $table->timestamps(); // Kolom created_at dan updated_at

            // Menambahkan foreign key secara manual
            $table->foreign('province_code')->references('code')->on('provinces')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::connection('mysql')->dropIfExists('regencies');
    }
};