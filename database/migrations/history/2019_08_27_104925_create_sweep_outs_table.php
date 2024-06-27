<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSweepOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zzz_sweep_outs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no')->unique();//单据编号
            $table->string('packager_no')->index();//打包员
            $table->string('user_no')->index();//登录U8用户
            $table->integer('count')->default(0);//配单数
            $table->integer('status')->default(\App\Models\SweepOut::CAR_STATUS_NO);
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
        Schema::dropIfExists('zzz_sweep_outs');
    }
}
