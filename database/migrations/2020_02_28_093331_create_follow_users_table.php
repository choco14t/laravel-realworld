<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_users', function (Blueprint $table) {
            $table->unsignedBigInteger('following_user_id');
            $table->unsignedBigInteger('followed_user_id');
            $table->timestamps();

            $table->foreign('following_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('followed_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follows');
    }
}
