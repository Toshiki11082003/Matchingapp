<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('circle_type', 255)->after('circle_name'); // サークルの種類を追加
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
           // $table->dropColumn('circle_type'); // ロールバック時にカラムを削除
        });
    }
};
