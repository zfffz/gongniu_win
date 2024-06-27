<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zzz_customer_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_no')->index()->unique();
            $table->integer('location_id')->index();
            $table->string('note')->nullable();
            $table->string('create_id');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('zzz_customer_locations');
    }
}
