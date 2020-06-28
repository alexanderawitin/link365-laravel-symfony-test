<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_data', function (Blueprint $table) {
            $table->id();
            $table->string('input_city');
            $table->string('resolved_city');
            $table->string('condition')->nullable();
            $table->double('temp')->unsigned();
            $table
                ->double('temp_max')
                ->unsigned()
                ->nullable();
            $table
                ->double('temp_min')
                ->unsigned()
                ->nullable();
            $table
                ->double('pressure')
                ->unsigned()
                ->nullable();
            $table
                ->double('wind_speed')
                ->unsigned()
                ->nullable();
            $table
                ->double('humidity')
                ->unsigned()
                ->nullable();
            $table
                ->double('visibility')
                ->unsigned()
                ->nullable();
            $table->string('source')->nullable();
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
        Schema::dropIfExists('weather_data');
    }
}
