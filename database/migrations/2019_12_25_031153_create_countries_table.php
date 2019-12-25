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
            $table->string('name');
            $table->string('slug');
            $table->json('snippets')                
                ->nullable();
            $table->string('inflation')
                ->nullable();
            $table->string('corporate_tax')
                ->nullable();
            $table->string('interest_rate')
                ->nullable();
            $table->string('unemployment_rate')
                ->nullable();
            $table->string('labor_force')
                ->nullable();
            $table->string('income_tax')
                ->nullable();
            $table->string('gdp')
                ->nullable();
            $table->string('gov_debt_to_gdp')
                ->nullable();
            $table->string('central_bank_balance_sheet')
                ->nullable();
            $table->string('budget')
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
