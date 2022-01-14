<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details_orders', function (Blueprint $table) {

            $table->bigInteger('order_id')->unsigned()->required();
            $table->bigInteger('product_id')->unsigned()->required();

            $table->smallInteger('quantity')->nullable()->default(12);
            $table->smallInteger('price')->nullable()->default(12);

            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('details_orders');
    }
}
