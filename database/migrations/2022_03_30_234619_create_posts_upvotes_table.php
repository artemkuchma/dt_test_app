<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsUpvotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_upvotes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('count');
            $table->unsignedInteger('post_id')->nullable();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts_upvotes');
    }
}
