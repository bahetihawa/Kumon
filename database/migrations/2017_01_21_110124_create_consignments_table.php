<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("warehouse");
            $table->string("orderNo");
            $table->integer("item");
            $table->integer("category");
            $table->decimal("freight");
            $table->integer("quantity");
            $table->string("ammount_myr");
            $table->string("exchange_rate");
            $table->string("ammount_inr");
            $table->decimal("total");
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
        Schema::dropIfExists('consignments');
    }
}
