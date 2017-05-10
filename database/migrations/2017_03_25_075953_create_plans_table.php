<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function(Blueprint $table) {
            $table->increments('id');
            $table->string('plan_name');
            $table->integer('disk_space');
            $table->string('disk_unit');
            $table->boolean('disk_unlimited');
            $table->integer('bandwidth');
            $table->string('bandwidth_unit');
            $table->boolean('bandwidth_unlimited');
            $table->integer('addon_domains');
            $table->boolean('addon_domains_unlimited');
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('plans');
    }
}
