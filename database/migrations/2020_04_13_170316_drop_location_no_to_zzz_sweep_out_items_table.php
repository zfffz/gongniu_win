<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropLocationNoToZzzSweepOutItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zzz_sweep_out_items', function (Blueprint $table) {
            $table->dropColumn('location_no');
            $table->string('default_location_no')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zzz_sweep_out_items', function (Blueprint $table) {
            $table->string('location_no')->index();
            $table->dropColumn('default_location_no');
        });
    }
}
