<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDispatchlistmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatchlistm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dispatchlist')->index();//发货单号
            $table->string('dlid')->index();//关联子表id号
            $table->string('ccusname')->index();//客户名称
            $table->string('ddate')->index();//单据日期
            $table->string('position')->index();//库位
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
        Schema::dropIfExists('dispatchlistm');
    }
}
