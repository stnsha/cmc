<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('venue_name');
            $table->string('venue_location');
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->softDeletes();
            $table->timestamps();
        });

        $data = [
            [
                'venue_name' => 'Dewan Arena CMC',
                'venue_location' => 'Ujong Pasir',
                'date_start' => '2023-03-24 18:30:00',
                'date_end' => '2023-04-18 18:30:00',
            ],
            [
                'venue_name' => 'Dewan Chermin',
                'venue_location' => 'Nilai',
                'date_start' => '2023-03-27 18:30:00',
                'date_end' => '2023-04-19 18:30:00',
            ],
        ];

        DB::table('venues')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venues');
    }
};