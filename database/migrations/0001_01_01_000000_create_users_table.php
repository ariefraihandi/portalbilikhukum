<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('whatsapp')->nullable();
            $table->string('password');
            $table->string('gender')->nullable();
            $table->text('address')->nullable();
            $table->string('image')->nullable();
            $table->string('role');
            $table->date('dob')->nullable();
            $table->boolean('verified')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('referedby')->nullable();
            $table->timestamps(); // created_at dan updated_at
            $table->softDeletes(); // Kolom deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
