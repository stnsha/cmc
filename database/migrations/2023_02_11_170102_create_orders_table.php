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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email');
            $table->integer('customer_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('order_details_id')->nullable();
            $table->double('subtotal');
            $table->double('service_charge')->nullable();
            $table->double('total');
            $table->integer('venue_id');
            $table->dateTime('date_chosen');
            $table->string('fpx_id')->nullable();
            $table->string('status')->default('Pending');
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
        Schema::dropIfExists('orders');
    }
};