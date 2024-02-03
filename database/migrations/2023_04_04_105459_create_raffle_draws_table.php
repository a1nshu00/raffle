<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaffleDrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raffle_draws', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id');
            $table->string('type');
            $table->integer('total_balls');
            $table->decimal('buying_amount',50,2);
            $table->string('draw_time');
            $table->string('status')->default('Active');
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
        Schema::dropIfExists('raffle_draws');
    }
}
