<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrolled', function (Blueprint $table) {
            $table->id('enrolled_id')->auto_increment();
            $table->timestamps();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->bigInteger('project_id')->unsigned()->index();
            $table->foreign('project_id')->references('project_id')->on('projects');
            $table->tinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrolled');
    }
};
