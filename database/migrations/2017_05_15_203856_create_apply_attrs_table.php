<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplyAttrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apply_attrs', function(Blueprint $table) {
            $table->increments('id');
            $table->string('attr_name')->nullable();
            $table->string('attr_slug')->nullable();
            $table->string('attr_type')->nullable();
            $table->string('attr_icon')->nullable()->default('file-text');
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
        Schema::drop('apply_attrs');
    }
}
