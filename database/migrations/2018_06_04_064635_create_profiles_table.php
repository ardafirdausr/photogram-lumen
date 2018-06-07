<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            //schema
            $table->increments('id');
            $table->integer('total_post')->default(0);
            $table->integer('total_follower')->default(0);
            $table->integer('total_following')->default(0);
            $table->string('bio')->default('');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            //constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
