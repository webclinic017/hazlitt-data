<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommoditiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commodities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')
                ->nullable();
            $table->json('snippets')
                ->nullable();
            $table->integer('spot')
                ->nullable();
            $table->json('historical_prices')
                ->nullable();
            $table->integer('supply')
                ->nullable();
            $table->json('historical_supply')
                ->nullable();
            $table->integer('demand')
                ->nullable();
            $table->json('historical_demand')
                ->nullable();
            $table->string('quandl_code')
                ->nullable();
            $table->tinyInteger('status')
                ->default(0);
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
        Schema::dropIfExists('commodities');
    }
}
