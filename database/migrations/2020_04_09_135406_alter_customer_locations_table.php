<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCustomerLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zzz_customer_locations', function (Blueprint $table) {
            $table->string('edit_id')->nullable();
            $table->dropUnique('zzz_customer_locations_customer_no_unique');
            $table->string('customer_no',10)->change();
            $table->unique('customer_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zzz_customer_locations', function (Blueprint $table) {
            $table->dropColumn('edit_id');
            //$table->integer('customer_no')->change();
        });
    }
}
