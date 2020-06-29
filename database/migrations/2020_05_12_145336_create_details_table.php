<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cwhname')->index();// 仓库名称
            $table->string('cinvcode')->index();// 存货编码
            $table->string('cinvname')->index();// 存货名称
            $table->string('cinvstd')->index();// 规格型号
            $table->string('unit')->index();// 单位
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
        Schema::dropIfExists('details');
    }
}
