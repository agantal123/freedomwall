<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MobileNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_notification', function (Blueprint $table) {
            $table->id('notification_id');
            $table->string('notification_type');
            $table->foreignId('post_id');
            $table->string('notification_from_user');
            $table->boolean('seen_notification');
            $table->foreignId('comment_id');
            $table->string('user_post');
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
        Schema::dropIfExists('mobile_notification');
    }
}
