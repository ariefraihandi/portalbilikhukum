<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_kantor');
            $table->string('email_kantor')->nullable();
            $table->string('hp_whatsapp', 20)->nullable();
            $table->date('tanggal_pendirian')->nullable();
            $table->text('alamat');
            $table->string('kode_pos', 10)->nullable();
            $table->string('provinsi', 100);
            $table->string('kabupaten_kota', 100);
            $table->string('kecamatan', 100);
            $table->string('desa', 100);
            $table->string('website')->nullable();
            $table->text('slogan')->nullable();
            $table->string('logo')->nullable();
            $table->string('cover')->nullable();
            $table->string('agreement')->nullable();
            $table->string('referedby')->nullable();
            $table->string('type');
            $table->string('status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offices');
    }
    
};