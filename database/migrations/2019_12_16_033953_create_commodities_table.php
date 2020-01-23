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
            $table->integer('spot')
                ->nullable();
            $table->json('prices')
                ->nullable();
            $table->json('supply')
                ->nullable();
            $table->json('demand')
                ->nullable();
            $table->integer('all_time_high')
                ->nullable();
            $table->date('ath_date')
                ->nullable();
            $table->json('applications')
                ->nullable();
            $table->string('code')
                ->nullable();
            $table->string('source')
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
