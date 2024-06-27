<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSweepOutItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zzz_sweep_out_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id')->unsigned()->index();
            $table->integer('entry_id');
            // 发货单号
            $table->string('dispatch_no')->index()->unique();
            // 库位号
            $table->string('location_no')->index();
            // 发货单状态    0 打包   1 装车,装车多次,就累加
            $table->integer('status')->default(0);
            // 发货单状态    0 打包   1 装车
            // 装车次数 有可能多次装包（1个大单）
            $table->integer('car_count')->default(0);
            // 当 parent_id 对应的 zzz_sweep_outs 表数据被删除时，删除明细
            $table->foreign('parent_id')->references('id')->on('zzz_sweep_outs')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zzz_sweep_out_items');
    }
}
