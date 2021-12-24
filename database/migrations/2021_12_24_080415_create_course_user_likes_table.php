<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseUserLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_user_likes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('course_id')->unsigned()->comment("課程ID");
            $table->bigInteger('user_id')->unsigned()->comment("使用者ID");
            $table->timestamps();

            $table->foreign("user_id")
                ->references("id")->on('users')
                ->onDelete("cascade");

            $table->foreign("course_id")
                ->references("id")->on('courses')
                ->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_user_likes', function (Blueprint $table) {
            $table->dropForeign('course_user_likes_user_id_foreign');
            $table->dropForeign('course_user_likes_course_id_foreign');
        });
        Schema::dropIfExists('course_user_likes');
    }
}
