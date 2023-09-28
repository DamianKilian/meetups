<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $now = now();
        DB::table('regions')->insert([
            ['name' => 'woj. dolnośląskie', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'woj. kujawsko-pomorskie', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'woj. lubelskie', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'woj. lubuskie', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'woj. łódzkie', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'woj. małopolskie', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'woj. mazowieckie', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'woj. opolskie', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'woj. podkarpackie', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'woj. podlaskie', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'woj. pomorskie', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'woj. śląskie', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'woj. świętokrzyskie', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'woj. warmińsko-mazurskie', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'woj. wielkopolskie', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'woj. zachodniopomorskie', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
