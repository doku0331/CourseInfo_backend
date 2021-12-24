<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_messages', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->unsignedBigInteger('user_id')->comment('作者');
            $table->unsignedBigInteger('comment_id')->comment('評鑑');
            $table->timestamps();

            $table->foreign("user_id")
                ->references("id")->on('users')
                ->onDelete("cascade");
            $table->foreign("comment_id")
                ->references("id")->on('comments')
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
            $table->dropForeign('course_user_likes_comment_id_foreign');
        });

        Schema::dropIfExists('comment_messages');
    }
}
