<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('city', function (Blueprint $table) {
            $table->increments('city_id')->unsigned();
            $table->unsignedInteger('province_id');
            $table->string('city_type', 10);
            $table->string('city_name', 50);
            $table->timestamps();
            $table->softDeletes();

            // Menambahkan foreign key constraint
            $table->foreign('province_id')->references('province_id')->on('province')->onUpdate('cascade')->onDelete('cascade');
        });

        DB::table('city')->insert([
            ['province_id' => 1, 'city_type' => 'Kota', 'city_name' => 'Mataram', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 1, 'city_type' => 'Kota', 'city_name' => 'Mataram', 'created_at' => now(), 'updated_at' => now()],
            ['province_id' => 2, 'city_type' => 'Kabupaten', 'city_name' => 'Kupang', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city');
    }
};
