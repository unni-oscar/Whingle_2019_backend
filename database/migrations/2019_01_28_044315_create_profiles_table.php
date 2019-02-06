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
        Schema::dropIfExists('profiles');
        Schema::create('profiles', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('user_id')->unsigned();  // 0 = normal user, 1 = managers, 2 = admin
            $table->string('secret_id', 64)->nullable();
            /*********** Basic Details ***********/     
            $table->tinyInteger('created_by');
            $table->string('name');
            $table->tinyInteger('gender');
            $table->date('dob');
            $table->tinyInteger('marital_status');
            $table->boolean('has_children')->nullable();
            $table->boolean('staying_with')->nullable();
            $table->text('about')->nullable();
            /*********** Religion/Astrol Details ***********/     
            $table->integer('mother_tongue_id')->nullable();
            $table->integer('religion_id')->nullable();
            $table->integer('caste_id')->nullable();
            $table->tinyInteger('star')->nullable();
            $table->tinyInteger('moon_sign')->nullable();
            $table->tinyInteger('manglik')->nullable();
            $table->tinyInteger('horoscope')->nullable();
            /*********** Education/Job Details ***********/     
            $table->integer('education')->nullable();
            $table->integer('education_in')->nullable();
            $table->integer('job')->nullable();
            $table->integer('job_as')->nullable();
            $table->integer('income')->nullable();
            /*********** Appearance Details ***********/     
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->tinyInteger('build')->nullable();
            $table->tinyInteger('complexion')->nullable();
            $table->tinyInteger('blood_group')->nullable();
            $table->boolean('disability')->nullable();
            /*********** Diet/Habits Details ***********/    
            $table->tinyInteger('diet')->nullable();
            $table->tinyInteger('smoke')->nullable();
            $table->tinyInteger('drink')->nullable();
            /*********** Family Details ***********/    
            $table->tinyInteger('father')->nullable();
            $table->tinyInteger('mother')->nullable();
            $table->tinyInteger('brothers')->nullable();
            $table->tinyInteger('brothers_married')->nullable();
            $table->tinyInteger('sisters')->nullable();
            $table->tinyInteger('sisters_married')->nullable();
            $table->tinyInteger('family_type')->nullable();
            $table->tinyInteger('family_status')->nullable();
            $table->tinyInteger('family_values')->nullable();
            /*********** Hobbies/Interests Details ***********/    
            $table->text('hobbies')->nullable();
            $table->text('interests')->nullable();
            /*********** Location/Contact Details ***********/    
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_number', 25)->nullable();

            $table->timestamps();
            $table->foreign('user_id')
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('profiles');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
