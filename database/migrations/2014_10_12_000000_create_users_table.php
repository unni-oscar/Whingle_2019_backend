<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('user_group_id')->default(0);  // 0 = normal user, 1 = managers, 2 = admin
            $table->string('name');
            $table->string('email')->unique();
            $table->string('activation_token',64)->nullable();
            $table->tinyInteger('status')->default(0); // Pending Activation / Active / Deleted / Suspended TODO
            $table->tinyInteger('subscription_id')->default(0); // 0 = Free Subscription , 1 = Bronze, 2 = Silver, 3 = Gold, 4 = Platinum
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
