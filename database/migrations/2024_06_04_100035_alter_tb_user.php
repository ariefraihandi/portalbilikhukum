<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTbUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom baru 'gender' sebelum 'address'
            $table->string('gender')->nullable()->after('password');
            
            // Tambahkan kolom baru 'referedby' setelah 'email_verified_at'
            $table->string('referedby')->nullable()->after('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('referedby');
            $table->dropColumn('gender');
        });
    }
}