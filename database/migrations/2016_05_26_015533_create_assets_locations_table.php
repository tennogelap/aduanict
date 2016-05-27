<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets_locations', function (Blueprint $table) {
            $table->increments('location_id');
            $table->string('branch_id',5)->nullable();
            $table->string('location_description',50)->nullable();
            $table->string('location_initials',25)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('assets_locations');
    }
}
