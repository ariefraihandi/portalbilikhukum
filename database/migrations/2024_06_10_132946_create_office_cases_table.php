<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_cases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('legal_case_id');
            $table->unsignedBigInteger('office_id');
            $table->decimal('min_fee', 11, 2); // Biaya minimum
            $table->decimal('max_fee', 11, 2); // Biaya maksimum
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('legal_case_id')->references('id')->on('legal_cases')->onDelete('cascade');
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
        Schema::dropIfExists('office_cases');
    }
}
