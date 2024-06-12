<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyForeignKeysOnOfficeMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('office_members', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['id_user']);
            $table->dropForeign(['id_office']);

            // Recreate foreign key constraints with cascade on delete
            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('id_office')
                ->references('id')
                ->on('offices')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('office_members', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['id_user']);
            $table->dropForeign(['id_office']);

            // Recreate original foreign key constraints
            $table->foreign('id_user')
                ->references('id')
                ->on('users');

            $table->foreign('id_office')
                ->references('id')
                ->on('offices');
        });
    }
};