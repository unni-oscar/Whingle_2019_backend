<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interests', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::dropIfExists('interests');
        Schema::create('interests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('interest_from')->unsigned();
            $table->integer('interest_to')->unsigned();
            $table->tinyInteger('status')->default(0); // 0-New / 1-Accept / 2 - Reject
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('interests');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
