<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\CommentMessage;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //關閉外部件約束
        Schema::disableForeignKeyConstraints();

        //清空資料表
        User::truncate();
        Course::truncate();
        Comment::truncate();
        CommentMessage::truncate();

        User::factory(5)->create();
        Course::factory(20)->create();
        Comment::factory(100)->create();
        CommentMessage::factory(200)->create();

        //開啟外部件約束
        Schema::enableForeignKeyConstraints();

    }
}
