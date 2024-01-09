<?php

use App\Models\Career;
use Illuminate\Database\Seeder;

class CareersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carrers = [
            'Actuación',
            'Actuariado',
            'Administración de Empresas',
            'Antropología',
            'Arqueología',
            'Arquitectura y Urbanismo',
            'Astronomía',
            'Bacteriología',
            'Bellas Artes',
            'Biofísica',
            'Bioingeniería',
            'Biología',
            'Bioquímica',
            'Ciencias Políticas y Gobierno',
            'Cine',
            'Comercio Exterior',
            'Comunicación Audiovisual',
            'Comunicación Social',
            'Contabilidad',
            'Derecho',
            'Diseño de Imagen y Sonido',
            'Diseño de Indumentaria y Calzado',
            'Diseño de Interiores',
            'Diseño Gráfico',
            'Diseño Industrial',
            'Diseño Multimedia',
            'Diseño Web',
            'Economía',
            'Educación',
            'Educación Física',
            'Enfermería',
            'Escribanía',
            'Farmacia',
            'Filosofía',
            'Finanzas',
            'Física',
            'Fisioterapia',
            'Fonoaudiología',
            'Fotografía',
            'Gastronomía',
            'Geografía',
            'Geología / Geomensura / Topografía',
            'Gestión de Medios y Entretenimientos',
            'Gobierno y Ciencia Política',
            'Higiene y Seguridad',
            'Historia',
            'Hotelería',
            'Ingeniería Aeronáutica',
            'Ingeniería Agronómica',
            'Ingeniería Ambiental',
            'Ingeniería Civil',
            'Ingeniería de Sonido',
            'Ingeniería Eléctrica',
            'Ingeniería Electromecánica',
            'Ingeniería Electrónica',
            'Ingeniería en Alimentos',
            'Ingeniería en Informática / Sistemas',
            'Ingeniería en Petróleo',
            'Ingeniería Forestal',
            'Ingeniería Hidráulica',
            'Ingeniería Industrial',
            'Ingeniería Mecánica',
            'Ingeniería Naval',
            'Ingeniería Nuclear',
            'Ingeniería Química',
            'Kinesiología',
            'Letras',
            'Literatura',
            'Magisterio',
            'Marketing',
            'Matemáticas',
            'Medicina',
            'Microbiología',
            'Música',
            'Nutrición',
            'Odontología',
            'Otra',
            'Periodismo',
            'Profesorado',
            'Psicología',
            'Psicopedagogía',
            'Publicidad',
            'Química',
            'Recursos Humanos',
            'Relaciones Internacionales',
            'Relaciones Públicas',
            'Sistemas de Información',
            'Sociología',
            'Teatro',
            'Trabajo Social',
            'Traductorado',
            'Turismo',
            'Veterinaria',
            'Zoología',
            'Otro'
        ];

        foreach ($carrers as $carrer) {
            Career::create(['name' => $carrer]);
        }
    }
}
