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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->dateTime('contacted_at')->comment('日時');
            $table->string('name')->nullable()->comment('お名前');
            $table->integer('sex')->nullable()->comment('性別');
            $table->integer('age')->nullable()->comment('年齢');
            $table->string('tel')->nullable()->comment('電話番号');
            $table->string('mail')->nullable()->comment('メール');
            $table->mediumText('body')->nullable()->comment('本文');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE contacts COMMENT '問い合わせ';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
