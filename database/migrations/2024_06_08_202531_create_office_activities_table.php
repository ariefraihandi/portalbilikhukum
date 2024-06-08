<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_activities', function (Blueprint $table) {
            $table->id(); // id otomatis
            $table->foreignId('office_id')->constrained()->onDelete('cascade'); // Relasi ke tabel offices
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('badge')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('office_activities');
    }
}
