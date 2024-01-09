<?php

use Illuminate\Database\Seeder;

class GuidelinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Guideline::create(['name' => 'Activación']);
        \App\Models\Guideline::create(['name' => 'Comunicación']);
        \App\Models\Guideline::create(['name' => 'Contenido']);
        \App\Models\Guideline::create(['name' => 'Diseño de Envases']);
        \App\Models\Guideline::create(['name' => 'Diseño de Experiencias y Servicios']);
        \App\Models\Guideline::create(['name' => 'Identidad de Marca']);
        \App\Models\Guideline::create(['name' => 'Innovación']);
        \App\Models\Guideline::create(['name' => 'Insights']);
        \App\Models\Guideline::create(['name' => 'Naming']);
        \App\Models\Guideline::create(['name' => 'Puntos de Venta']);
        \App\Models\Guideline::create(['name' => 'Investigación de Mercado']);
    }
}
