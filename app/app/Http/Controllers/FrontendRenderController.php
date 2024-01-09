<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class FrontendRenderController extends Controller
{
    public function index($uri = '/')
    {
        $metas = $this->getMetaTags($uri);
        return view('app', compact('metas'));
    }

    private function getMetaTags($uri)
    {
        if($uri == '/')
            return [
                    'og:image' => asset('images/og_image_7.jpg'),
                    'og:url' => url()->current(),
                    'og:title' => 'CANTERA CREATIVA',
                    'title' => 'CANTERA CREATIVA',
                    'og:description' => 'Comunidad creativa que genera ideas para marcas',
                    'description' => 'Somos una comunidad creativa que genera diversidad de ideas y soluciones para marcas a través de la colaboración.',
                    'og:locale' => 'es_ar',
                ];

        $uriArray = explode('/', $uri);
        if(!in_array($uriArray[0], ['creativos', 'marcas', 'contests', 'login', 'profile_edit', 'profile']))
            return [];

        $metas = [
            'marcas' => [
                'og:image' => asset('images/og_image_7.jpg'),
                'og:url' => url()->current(),
                'og:title' => 'CANTERA CREATIVA - Soy Marca',
                'title' => 'CANTERA CREATIVA - Soy Marca',
                'og:description' => 'Comunidad creativa que genera ideas para marcas',
                'description' => 'Somos una comunidad creativa que genera diversidad de ideas y soluciones para marcas a través de la colaboración.',
                'og:locale' => 'es_ar',
            ],
            'creativos' => [
                'og:image' => asset('images/og_image_7.jpg'),
                'og:url' => url()->current(),
                'og:title' => 'CANTERA CREATIVA - Soy Creativo',
                'title' => 'CANTERA CREATIVA - Soy Creativo',
                'og:description' => 'Sumate a nuestra comunidad creativa, participá y ganá premios.',
                'description' => 'Somos una comunidad creativa que genera diversidad de ideas y soluciones para marcas a través de la colaboración.',
                'og:locale' => 'es_ar',
            ],
            'contests' => [
                'og:image' => asset('images/og_image_7.jpg'),
                'og:url' => url()->current(),
                'og:title' => 'CANTERA CREATIVA - Convocatorias',
                'title' => 'CANTERA CREATIVA - Convocatorias',
                'og:description' => 'Elegí la convocatoria, leé el brief, participá y ganá premios.',
                'description' => 'Conocé las convocatorias, leé sus briefs y participá con tus ideas para ganar premios y reconocimiento.',
                'og:locale' => 'es_ar',
            ],

            'contest' => [
                'og:image' => asset('images/og_image_7.jpg'),
                'og:url' => url()->current(),
                'og:title' => 'CANTERA CREATIVA - Convocatoria '.optional(Announcement::find($uriArray[1] ?? 0))->company,
                'title' => 'CANTERA CREATIVA - Convocatoria '.optional(Announcement::find($uriArray[1] ?? 0))->company,
                'og:description' => optional(Announcement::find($uriArray[1] ?? 0))->title,
                'description' => optional(Announcement::find($uriArray[1] ?? 0))->short_description,
                'og:locale' => 'es_ar',
            ],

            'login' => [
                'og:image' => asset('images/og_image_7.jpg'),
                'og:url' => url()->current(),
                'og:title' => 'CANTERA CREATIVA - Iniciar sesión',
                'title' => 'CANTERA CREATIVA - Iniciar sesión',
                'og:description' => 'Iniciá sesión, subí tus ideas y ganá premios y reconocimiento.',
                'description' => 'Creá tu cuenta, seleccioná una convocatoria, y subí tus ideas para participar y ganar premios y reconocimiento de marcas.',
                'og:locale' => 'es_ar',
            ],

            'profile_edit' => [
                'og:image' => asset('images/og_image_7.jpg'),
                'og:url' => url()->current(),
                'og:title' => 'CANTERA CREATIVA - Crear cuenta',
                'title' => 'CANTERA CREATIVA - Crear cuenta',
                'og:description' => 'Creá tu cuenta, subí tus ideas y ganá premios y reconocimiento.',
                'description' => 'Creá tu cuenta, seleccioná una convocatoria, y subí tus ideas para participar y ganar premios y reconocimiento de marcas.',
                'og:locale' => 'es_ar',
            ],

            'profile' => [
                'og:image' => asset('images/og_image_7.jpg'),
                'og:url' => url()->current(),
                'og:title' => 'CANTERA CREATIVA',
                'title' => 'CANTERA CREATIVA',
                'og:description' => 'Comunidad creativa que genera ideas para marcas',
                'description' => 'Somos una comunidad creativa que genera diversidad de ideas y soluciones para marcas a través de la colaboración.',
                'og:locale' => 'es_ar',
            ]
        ];

        if($uriArray[0] == 'contests' && is_numeric($uriArray[1] ?? ''))
            return $metas['contest'];

        return $metas[$uriArray[0]];

    }
}
