<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlienChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klien_chat', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('whatsapp');
            $table->string('email')->nullable();
            $table->string('keperluan');
            $table->unsignedBigInteger('id_office');
            $table->string('status');
            $table->text('chat_history')->nullable();
            $table->timestamp('last_contacted_at')->nullable();
            $table->boolean('is_followed_up')->default(false);
            $table->timestamps();

            // Tambahkan foreign key
            $table->foreign('id_office')->references('id')->on('offices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('klien_chat');
    }
};