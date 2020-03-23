<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registry', function (Blueprint $table) {
            $table->increments('id');
			$table->bigInteger('entry_id')
				->index()
				->nullable();
			$table->string('entry_type')
				->nullable();
			$table->string('url')
				->index();
			$table->string('destination')
                ->nullable();
            $table->string('request')
                ->nullable();
			$table->string('layout')
				->nullable();
			$table->boolean('redirect')
				->default( 0 );
			$table->integer('code')
				->default( 200 );
            $table->string('view');
            $table->string('meta_title');
            $table->string('meta_image')
                ->nullable();
			$table->string('meta_keywords')
				->nullable();
			$table->string('meta_description')
				->nullable();
			$table->string('meta_robots')
				->default('INDEX, FOLLOW');

            $table->softDeletes();
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
        Schema::dropIfExists('registry');
    }
}
