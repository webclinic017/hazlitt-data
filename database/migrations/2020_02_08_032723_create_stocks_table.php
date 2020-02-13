<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('index_id')
                ->nullable()
                ->index();
            $table->string('name');
            $table->char('ticker', 25);
            $table->float('price')
                ->nullable();
            $table->json('advanced_stats')
                ->nullable();
            $table->json('balance_sheet')
                ->nullable();
            $table->json('company')
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
        Schema::dropIfExists('stocks');
    }
}
