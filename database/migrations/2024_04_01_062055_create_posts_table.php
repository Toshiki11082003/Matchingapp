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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255); // タイトルの最大文字数を調整
            $table->text('body'); // 本文はtext型に変更し、文字数制限を外す
            $table->string('university_name', 255); // 大学名を追加
            $table->string('circle_name', 255); // サークル名を追加
            //$table->string('circle_type', 255); // サークルの種類を追加
            $table->dateTime('event_date')->nullable(); // イベント開催日時（nullable: 空も可）
            $table->dateTime('deadline')->nullable(); // 締め切り（nullable: 空も可）
            //$table->decimal('cost', 8, 2)->nullable(); // 費用カラムを追加、小数点2桁まで、8桁までの数値を許容
            $table->timestamps();
            $table->softDeletes(); // 論理削除を有効にする
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
