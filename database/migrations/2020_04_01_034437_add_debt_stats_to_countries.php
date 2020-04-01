<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDebtStatsToCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->json('debt_statistics')
            ->nullable()
            ->after('gov_debt_to_gdp');
            $table->json('fx_denominated_debt')
            ->nullable()
            ->after('debt_statistics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('debt_statistics');
            $table->dropColumn('fx_denominated_debt');
        });
    }
}
