<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricings', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->double('price');
            $table->softDeletes();
            $table->timestamps();
        });

        $data = [
            [
                'type' => 'Adult',
                'price' => 65,
            ],
            [
                'type' => 'Elderly & kids',
                'price' => 39,
            ],
            'type' => 'Group',
            'price' => 59,
        ];

        DB::table('pricings')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pricings');
    }
};