<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSweepCarItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zzz_sweep_car_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id')->index();
            $table->integer('entry_id');
            //发货单号
            $table->string('dispatch_no')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zzz_sweep_car_items');
    }
}
