<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->int('order_id');
            $table->int('pricing_id');
            $table->double('price');
            $table->int('quantity');
            $table->double('subtotal');
            $table->int('status'); //success/failed/etc
            $table->int('venue_id');
            $table->dateTime('date_chosen');
            $table->string('fpx_id');
            $table->softDeletes();
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
        Schema::dropIfExists('order_details');
    }
};