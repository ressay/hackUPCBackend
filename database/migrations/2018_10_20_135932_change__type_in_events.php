<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeInEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function(Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropColumn('type_id');
            $table->string('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function(Blueprint $table) {
            $table->dropColumn('type');
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('types');
        });
    }
}
