<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuleBUndangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rule_b_undang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained('rule_a_types'); // Menambahkan foreign key
            $table->string('name');
            $table->string('nomor');
            $table->year('tahun');
            $table->string('tentang');
            $table->text('menimbang');
            $table->text('mengingat');
            $table->text('mencabut');
            $table->text('menetapkan');
            $table->string('persetujuan');
            $table->boolean('bab');
            $table->date('tanggal_penetapan');
            $table->date('tanggal_pengundangan');
            $table->date('tanggal_berlaku');
            $table->string('sumber');
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
        Schema::dropIfExists('rule_b_undang');
    }
}
