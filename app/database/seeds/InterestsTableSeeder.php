<?php

use Illuminate\Database\Seeder;

class InterestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Interest::create(['name' => 'Arte']);
        \App\Models\Interest::create(['name' => 'Moda']);
        \App\Models\Interest::create(['name' => 'Diseño']);
        \App\Models\Interest::create(['name' => 'Deportes']);
        \App\Models\Interest::create(['name' => 'Viajes']);
        \App\Models\Interest::create(['name' => 'Música']);
        \App\Models\Interest::create(['name' => 'Nightlife']);
        \App\Models\Interest::create(['name' => 'Bebidas con alcohol']);
        \App\Models\Interest::create(['name' => 'Gastronomía']);
        \App\Models\Interest::create(['name' => 'Salud / Fitness']);
        \App\Models\Interest::create(['name' => 'Tecnología']);
        \App\Models\Interest::create(['name' => 'Apps']);
        \App\Models\Interest::create(['name' => 'ONG\'s / Causas Sociales']);
    }
}
