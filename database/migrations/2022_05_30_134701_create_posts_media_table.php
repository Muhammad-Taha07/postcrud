<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->references('id')->on('posts');
            // $table->foreignId('post_id')->constrained('posts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('media_url', 80);
            $table->string('media_thumb_url',80);
            $table->integer('status')->length(1);
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
        Schema::dropIfExists('posts_media');
    }
}
