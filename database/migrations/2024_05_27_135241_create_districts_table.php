<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('districts', function (Blueprint $table) {
            $table->id(); // Primary key, auto-increment
            $table->string('regency_code');
            $table->string('code')->unique(); // Kode kecamatan
            $table->string('name'); // Nama kecamatan
            $table->timestamps(); // Kolom created_at dan updated_at

            // Menambahkan foreign key secara manual
            $table->foreign('regency_code')->references('code')->on('regencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->dropIfExists('districts');
    }
}
