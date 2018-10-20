<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlaceToEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function($table) {
            $table->integer('place_id')->unsigned();
            $table->foreign('place_id')->references('id')->on('places');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function($table) {
            $table->dropForeign(['place_id']);
            $table->dropColumn('place_id');
        });
    }
}
