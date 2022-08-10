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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->date('day')->comment('日時');
            $table->string('title')->nullable()->comment('タイトル');
            $table->text('body')->nullable()->comment('本文');
            $table->boolean('is_enabled')->default(false)->comment('有効無効');
            $table->string('dir')->nullable()->comment('添付ファイル用ディレクトリ');
            $table->integer('category')->nullable()->comment('カテゴリー');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE blogs COMMENT 'ブログ';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
};
