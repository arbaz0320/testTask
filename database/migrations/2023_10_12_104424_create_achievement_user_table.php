<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchievementUserTable extends Migration
{
    public function up()
    {
        Schema::create('achievement_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('achievement_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('achievement_id')->references('id')->on('achievements');
        });
    }

    public function down()
    {
        Schema::dropIfExists('achievement_user');
    }
}
