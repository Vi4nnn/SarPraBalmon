<?php

namespace Database\Seeders;

use App\Models\ProgramStudy;
use Illuminate\Database\Seeder;

class ProgramStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programStudies = [
            'Sarana Prasarana',
        ];

        foreach ($programStudies as $programStudy) {
            ProgramStudy::create([
                'name' => $programStudy,
            ]);
        }
    }
}
