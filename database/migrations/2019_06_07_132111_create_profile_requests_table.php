<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('profile_requests');
        Schema::create('profile_requests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('from')->unsigned();
            $table->integer('to')->unsigned();
            $table->char('type', 1);
            $table->tinyInteger('status')->default(1); // 1-Active / 0-Inactive 
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
        Schema::dropIfExists('profile_requests');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
