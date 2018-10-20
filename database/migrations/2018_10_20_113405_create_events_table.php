<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date_time');
            $table->integer('max_allowed');
            $table->integer('duration'); // in seconds
            $table->text('description');
            $table->integer('host_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->foreign('host_id')->references('id')->on('users');
            $table->foreign('type_id')->references('id')->on('types');
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
        Schema::dropIfExists('events');
    }
}
