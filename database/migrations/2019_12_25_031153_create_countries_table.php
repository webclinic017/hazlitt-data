<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name', 100);
            $table->char('code', 50);
            $table->string('slug');
            $table->json('snippets')
                ->nullable();
            $table->json('population')
                ->nullable();
            $table->json('gdp')
                ->nullable();
            $table->json('inflation')
                ->nullable();
            $table->json('corporate_tax')
                ->nullable();
            $table->json('interest_rate')
                ->nullable();
            $table->json('income')
                ->nullable();
            $table->json('personal_savings')
                ->nullable();
            $table->json('unemployment_rate')
                ->nullable();
            $table->json('labor_force')
                ->nullable();
            $table->json('income_tax')
                ->nullable();
            $table->json('gov_debt_to_gdp')
                ->nullable();
            $table->json('bank_reserves')
                ->nullable();
            $table->json('budget')
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
        Schema::dropIfExists('countries');
    }
}
