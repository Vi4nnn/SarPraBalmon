<?php

namespace Database\Seeders;

use App\Models\Commodity;
use Illuminate\Database\Seeder;

class CommoditySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            Commodity::create([
                'name' => 'Proyektor '.$i,
            ]);
        }

        for ($i = 1; $i <= 4; $i++) {
            Commodity::create([
                'name' => 'Terminal '.$i,
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            Commodity::create([
                'name' => 'ATK (Alat Tulis Kantor) '.$i,
            ]);
        }

        for ($i = 1; $i <= 6; $i++) {
            Commodity::create([
                'name' => 'Kabel VGA to HDMI '.$i,
            ]);
        }
    }
}
