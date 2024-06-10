<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('klien_chat_id'); // Menggunakan klien_chat sebagai pengganti client_id
            $table->unsignedBigInteger('office_id');
            $table->unsignedTinyInteger('question_1'); // Pertanyaan 1
            $table->unsignedTinyInteger('question_2')->nullable(); // Pertanyaan 2
            $table->unsignedTinyInteger('question_3')->nullable(); // Pertanyaan 3
            $table->unsignedTinyInteger('question_4')->nullable(); // Pertanyaan 4
            $table->unsignedTinyInteger('question_5')->nullable(); // Pertanyaan 5
            $table->unsignedTinyInteger('question_6')->nullable(); // Pertanyaan 6
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('klien_chat_id')->references('id')->on('klien_chat')->onDelete('cascade');
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
        Schema::dropIfExists('responses');
    }
}
