<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("warehouse")->nullable();
            $table->string("orderNo")->nullable();
            $table->date("orderDate")->nullable();
            $table->decimal("amount")->nullable();
            $table->decimal("freight")->nullable();
            $table->decimal("others")->nullable();
            $table->decimal("cnf")->nullable();
            $table->decimal("custom")->nullable();
            $table->decimal("sum")->nullable();
            $table->string("file")->nullable();
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
        Schema::dropIfExists('orders');
    }
}
