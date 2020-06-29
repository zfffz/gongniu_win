<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSweepCheckItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zzz_dispatchlists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cwhname')->index();//仓库名称
            $table->string('cinvcode')->index();//存货编码
            $table->string('cinvname')->index();//存货名称
            $table->string('cinvstd')->index();//规格型号
            $table->string('cUnitID')->index();//单位
            $table->string('cinvDefine13')->index();//装箱规格
            $table->integer('iNum')->index();//发货件数
            $table->integer('yNum')->index();//验货件数
            $table->integer('iQuantity')->index();//发货数量
            $table->integer('yQuantity')->index();//验货数量
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
        Schema::dropIfExists('sweep_check_items');
    }
}
