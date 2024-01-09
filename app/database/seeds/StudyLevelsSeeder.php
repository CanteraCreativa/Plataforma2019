<?php

use App\Models\StudyLevel;
use Illuminate\Database\Seeder;

class StudyLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = [
            'Secundario en curso',
            'Secundario abandonado',
            'Secundario finalizado',
            'Terciario en curso',
            'Terciario abandonado',
            'Terciario finalizado',
            'Universitario en curso',
            'Universitario abandonado',
            'Universitario finalizado',
            'Postgrado en curso',
            'Postgrado abandonado',
            'Postgrado finalizado'
        ];

        foreach ($levels as $level) {
            StudyLevel::create(['name' => $level]);
        }
    }
}
