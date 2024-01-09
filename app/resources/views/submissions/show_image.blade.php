<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="icon" type="image/png" href="~/../../images/favicon.png">
    <style>

        html, body, #app {
            height: 100%;
            background-color: #333;
        }

        .main {
            background: #F2F2F2;
        }
    </style>

    <style>

        /*
         * Header
         */

        .masthead-brand {
            margin-bottom: 0;
        }

        .navbar-brand {
            max-width: 50%;
            font-size: 1rem!important;
        }
        .navbar-toggler {
            border: 0!important
        }
        .menu-profile-image {
            width: 25px;
            height: 25px;
        }

        .logo {
            color: black;
            background-color: transparent;
        }
        .border-pink {
            border-bottom: .25rem solid transparent;
            border-bottom-color: #f95568;
            padding: .25rem 0;
        }

        .menu-separator {
            background: #f95568;
        }

        .color-pink {
            color: #f95568;
        }

        .nav-masthead .nav-link {
            padding: .25rem 0;
            color: black;
            border: 1px solid #ffffff;
        }

        .router-link-active {
            color: #f95568;
            cursor: pointer;
            border-radius: .5rem;
        }

        .nav-masthead .nav-link:hover,
        .nav-masthead .nav-link:focus {
            border: 1px solid #f95568;
            border-radius: .5rem;
        }

        .nav-masthead .nav-link + .nav-link {
            margin-left: 1rem;
        }


        @media (min-width: 48em) {
            .masthead-brand {
                float: left;
            }
            .nav-masthead {
                float: right;
            }
        }
        @media (max-width: 480px) {
            #navbarNav {
                padding-left: 15px;
            }
            .nav-link {
                margin-top: 10px;
            }
        }
        .logo-header {
            max-height: 20px;
            max-width: 20px;
            padding-bottom: 5px;
        }

    </style>


    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NJZD8CL');</script>
    <!-- End Google Tag Manager -->
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NJZD8CL"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div id="app">
    <div class="body">
        <div class="d-flex w-100 flex-column main">

            <header class="p-3 bg-white">
                <div class="inner">
                    <a href="#">
                        <img src="{{ asset('images/cantera-logo-colors.png') }}" alt="Cantera creativa" />
                    </a>
                </div>
            </header>

            <div class="container-fluid row mt-1">
                <div class="submission-container col-12 col-md-4 m-auto">
                    <p class="text-dark m-0"><strong>Marca</strong></p>
                    <p class="color-pink"><strong>{{ $submission->announcement->company }}</strong></p>

                    <p class="text-dark m-0"><strong>Convocatoria</strong></p>
                    <p class="color-pink"><strong>{{ $submission->announcement->title }}</strong></p>

                    <p class="text-dark m-0"><strong>ID de la Idea</strong></p>
                    <p class="color-pink"><strong>{{ $submission->id }}</strong></p>

                    <p class="text-dark m-0"><strong>Título de la Idea</strong></p>
                    <p class="text-dark">{{ $submission->name }}</p>

                    <p class="text-dark m-0"><strong>Imagen de la Idea</strong></p>
                    <img src="{{ asset($submission->image_file) }}" class="w-100 mb-3" />

                    <p class="text-dark m-0"><strong>Descripción de la Idea</strong></p>
                    <p class="text-dark">{!! nl2br($submission->description) !!}</p>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
