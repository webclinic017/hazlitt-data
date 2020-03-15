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
            $table->string('slug');
            $table->json('snippets')
                ->nullable();
            $table->float('spot')
                ->nullable();
            $table->json('change')
                ->nullable();
            $table->json('prices')
                ->nullable();
            $table->json('supply_demand')
                ->nullable();
            $table->json('applications')
                ->nullable();
            $table->json('sources')
                ->nullable();
            $table->char('sector', 50)
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
