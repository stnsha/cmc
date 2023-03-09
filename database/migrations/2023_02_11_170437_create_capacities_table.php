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
        Schema::create('capacities', function (Blueprint $table) {
            $table->id();
            $table->integer('venue_id');
            $table->integer('max_capacity');
            $table->integer('current_capacity');
            $table->datetime('venue_date');
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();
        });

        function getDatesFromRange($start, $end, $format = 'Y-m-d')
        {
            // Declare an empty array
            $array = [];

            // Variable that store the date interval
            // of period 1 day
            $interval = new DateInterval('P1D');

            $realEnd = new DateTime($end);
            $realEnd->add($interval);

            $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

            // Use loop to store date into array
            foreach ($period as $date) {
                $array[] = $date->format($format);
            }

            // Return the array elements
            return $array;
        }

        $date_range = getDatesFromRange(
            '2023-03-24 18:30:00',
            '2023-04-18 18:30:00'
        );

        foreach ($date_range as $item) {
            DB::table('capacities')->insert([
                'venue_id' => 1,
                'max_capacity' => 600,
                'current_capacity' => 600,
                'venue_date' => $item,
                'status' => 'Available',
            ]);
        }

        $date_range1 = getDatesFromRange(
            '2023-03-27 18:30:00',
            '2023-04-19 18:30:00'
        );

        foreach ($date_range1 as $item) {
            DB::table('capacities')->insert([
                'venue_id' => 2,
                'max_capacity' => 600,
                'current_capacity' => 600,
                'venue_date' => $item,
                'status' => 'Available',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('capacities');
    }
};