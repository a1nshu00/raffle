<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaffleResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raffle_results', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('prize_id')->nullable();
            $table->integer('raffle_id')->nullable();
            $table->integer('order_id')->nullable(); 
            $table->integer('winning_ball')->nullable();
            $table->string('user_choice')->nullable();
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
        Schema::dropIfExists('raffle_results');
    }
}
