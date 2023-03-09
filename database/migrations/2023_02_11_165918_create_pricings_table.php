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
            $table->string('description');
            $table->integer('type');
            $table->double('price');
            $table->softDeletes();
            $table->timestamps();
        });

        $data = [
            [
                'description' => 'Dewasa',
                'type' => 1,
                'price' => 65,
            ],
            [
                'description' => 'Warga emas & kanak-kanak',
                'type' => 2,
                'price' => 39,
            ],
            [
                'description' => 'Kanak-kanak bawah 5 tahun - tanpa kerusi',
                'type' => 3,
                'price' => 0,
            ],
            [
                'description' =>
                    'Kanak-kanak bawah 5 tahun - kerusi diperlukan',
                'type' => 4,
                'price' => 10,
            ],
            [
                'description' => 'Group',
                'type' => 5,
                'price' => 59,
            ],
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