<?php

use Illuminate\Database\Seeder;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Skill::create(['name' => 'Diseño Gráfico']);
        \App\Models\Skill::create(['name' => 'Fotografía']);
        \App\Models\Skill::create(['name' => 'Community Management']);
        \App\Models\Skill::create(['name' => 'Edición de Imagen y Sonido']);
        \App\Models\Skill::create(['name' => 'Producción Musical']);
        \App\Models\Skill::create(['name' => 'Estrategia e Investigación']);
        \App\Models\Skill::create(['name' => 'Redacción Publicitaria']);
        \App\Models\Skill::create(['name' => 'Redacción Periodística']);
        \App\Models\Skill::create(['name' => 'Actuación / Modelaje']);
    }
}
