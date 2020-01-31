<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //postsテーブル：投稿された映画解説の情報
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');//投稿自体に割り振られるID
            $table->integer('user_id');//投稿者のID
            $table->integer('tmdb_id');//TMDBの映画情報ID
            $table->string('title');//タイトル
            $table->string('content');//内容
            $table->datetime('begin_at');//開始時間
            $table->datetime('end_at');//終了時間
            $table->timestamps();
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
}
