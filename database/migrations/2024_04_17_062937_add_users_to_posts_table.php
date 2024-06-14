<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::table('posts', function (Blueprint $table) {
        // Check if the foreign key exists before trying to drop it
        if (Schema::hasColumn('posts', 'user_id')) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        }
    });
}
};