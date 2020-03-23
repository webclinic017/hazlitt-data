<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('country_id')
                ->nullable()
                ->index();
            $table->char('country_name', 100)
                ->nullable();
            $table->string('name');
            $table->json('historical_prices')
                ->nullable();
            $table->json('indicators')
                ->nullable();
            $table->string('source')
                ->comment('This is the csv file that lists the stocks in the index')
                ->nullable();  
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
        Schema::dropIfExists('indices');
    }
}
