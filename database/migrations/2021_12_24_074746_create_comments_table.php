<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('rating')->comment("評分");
            $table->text('teaching')->nullable()->comment("教學方式");
            $table->text('grading')->nullable()->comment("評分方式");
            $table->text('assignment')->nullable()->comment("作業");
            $table->text('comment')->nullable()->comment("補充");
            $table->unsignedBigInteger('user_id')->comment('作者');
            $table->unsignedBigInteger('course_id')->comment('課程');
            $table->boolean('isPublish')->default(false);
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

        Schema::dropIfExists('comments');
    }
}
