<template>
    <div class="">
        <div class="w-100 d-block">
            <div class="carousel-container position-relative">
                <div class="owl-carousel w-100">

                    <div class="w-100">
                        <div class="row m-0 justify-content-md-center">
                            <div class="col-12 col-md-7 p-0 background-slider-1">
                                <img class="d-block d-sm-none" src="/images/marca-1.jpg" />
                            </div>
                            <div class="col-12 col-md-5 d-flex align-items-center">
                                <div class="carousel-text">
                                    <h1 class="font-batman-bold pink-color">Generamos
                                        diversidad
                                        de ideas
                                    </h1>
                                    <p class="lead text-dark">
                                        Contamos con una gran variedad de colaboradores que aportan su visión personal y única en cada una de nuestras convocatorias.
                                    </p>
                                    <p class="font-batman-bold mt-1 mt-sm-0">
                                        <a class="btn btn-lg btn-cantera2" href="#comenza-ahora">Contactanos</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-100">
                        <div class="row m-0 justify-content-md-center">
                            <div class="col-12 col-md-7 p-0 background-slider-2">
                                <img class="d-block d-sm-none" src="/images/marca-2.jpg" />
                            </div>
                            <div class="col-12 col-md-5 d-flex align-items-center">
                                <div class="carousel-text">
                                    <h1 class="font-batman-bold pink-color">Construímos
                                        comunidades
                                        creativas
                                    </h1>
                                    <p class="lead text-dark">
                                        Acercamos a organizaciones y creativos para que juntos generen las ideas que definirán las marcas del futuro.
                                    </p>
                                    <p class="font-batman-bold mt-1 mt-sm-0">
                                        <a class="btn btn-lg btn-cantera2" href="#comenza-ahora">Contactanos</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-100">
                        <div class="row m-0 justify-content-md-center">
                            <div class="col-12 col-md-7 p-0 background-slider-3">
                                <img class="d-block d-sm-none" src="/images/marca-3.jpg" />
                            </div>
                            <div class="col-12 col-md-5 d-flex align-items-center">
                                <div class="carousel-text">
                                    <h1 class="font-batman-bold pink-color">Diseñamos
                                        el ambiente
                                        de creación
                                    </h1>
                                    <p class="lead text-dark">
                                        Ofrecemos variedad de convocatorias que se adaptan a las necesidades de cada marca.
                                    </p>
                                    <p class="font-batman-bold mt-1 mt-sm-0">
                                        <a class="btn btn-lg btn-cantera2" href="#comenza-ahora">Contactanos</a>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="owl-custom-nav row col-12 m-0">
                    <div class="col-12 col-md-7"></div>
                    <div class="col-12 col-md-5 d-flex align-items-center px-sm-5">
                        <div class="prev-btn pink-color px-1">
                            <button @click="prevSlide()"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                        </div>
                        <div class="dots-nav px-1">
                            <button class="dot" :class="{'active': currentSlide == 0}" @click="goToSlide(0)"></button>
                            <button class="dot" :class="{'active': currentSlide == 1}" @click="goToSlide(1)"></button>
                            <button class="dot" :class="{'active': currentSlide == 2}" @click="goToSlide(2)"></button>
                        </div>
                        <div class="next-btn pink-color px-1">
                            <button @click="nextSlide()"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <bar-marcas/>

        <div class="container-fluid text-center mt-4">
            <h1 class="font-batman-bold pink-color text-center">¿Cómo trabajamos en Cantera Creativa?</h1>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-md-10 col-lg-8 col-sm-12 p-5">
                <div class="row justify-content-md-center">
                    <div class="col-lg-3 col-md-6">
                        <div class="card custom-shadow h-100">
                            <div class="card-body h-100">
                                <div class="text-center">
                                    <img src="~/../../images/iconos/CC-Icons-01.svg" class="img-fluid force-height-75px" >
                                </div>
                                <hr>
                                <h3 class="lead pink-color font-batman-bold text-center card-title">
                                    01.<br>Diseño del plan de trabajo
                                </h3>
                                <p class="text-dark text-center">
                                    Diseñamos la convocatoria y generamos un brief que mejor se adapte a las necesidades de tu marca.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card custom-shadow h-100">
                            <div class="card-body h-100">
                                <div class="text-center">
                                    <img src="~/../../images/iconos/CC-Icons-02.svg" class="img-fluid force-height-75px" >
                                </div>
                                <hr>
                                <h3 class="lead pink-color font-batman-bold text-center card-title">
                                    02.<br>Desarrollo de convocatoria
                                </h3>
                                <p class="text-dark text-center">
                                    En pocos días, nuestra comunidad creativa presenta muchas ideas diversas e innovadoras.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card custom-shadow h-100">
                            <div class="card-body h-100">
                                <div class="text-center">
                                    <img src="~/../../images/iconos/CC-Icons-03.svg" class="img-fluid force-height-75px" >
                                </div>
                                <hr>
                                <h3 class="lead pink-color font-batman-bold text-center card-title">
                                    03.<br>Selección de ideas
                                </h3>
                                <p class="text-dark text-center">
                                    Ayudamos a seleccionar las ideas que mejor se adaptan a la estrategia de tu marca.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card custom-shadow h-100">
                            <div class="card-body h-100">
                                <div class="text-center">
                                    <img src="~/../../images/iconos/CC-Icons-04.svg" class="img-fluid force-height-75px" >
                                </div>
                                <hr>
                                <h3 class="lead pink-color font-batman-bold text-center card-title">
                                    04.<br>Gestión de derechos
                                </h3>
                                <p class="text-dark text-center">
                                    Reconocemos a los creadores de las ideas seleccionadas y gestionamos el traspaso de derechos.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-0">
            <p class="big-font font-weight-200 text-center"><i class="fa fa-angle-down pink-color" aria-hidden="true"></i></p>
        </div>

        <div v-if="false" class="row mb-2 justify-content-md-center">
            <div class="col-md-10 col-lg-8 col-sm-12 px-5 text-center">
                <div class="row justify-content-md-center">
                    <div class="col-12">
                        <h1 class="pink-color font-batman-bold">Blog Post</h1>
                        <br>
                        <p class="lead text-dark">
                            Nuestra comunidad de jóvenes creativos generan ideas
                            <br>
                            diversas basadas en sus intereses y gustos personales.
                        </p>
                    </div>

                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-12">
                                <div class="contest-info pink-bg text-white">
                                    <div class="inner text-center d-flex w-100 flex-column p-3 ">
                                        <span class="position-absolute text-dark left-3 fa fa-quote-left fa-2x" />
                                        <p class="text-center align-justify-content mt-auto mb-auto p-4 ">
                                            Ayudamos a las marcas a entender cómo
                                            <br>
                                            piensan sus consumidores más creativos,
                                            <br>
                                            al mismo tiempo que brindamos oportunidades
                                            <br>
                                            de desarrollo profesional a los nuevos
                                            <br>
                                            talentos de la industria publicitaria.
                                        </p>
                                        <span class="text-dark position-absolute right-3 fa fa-quote-right fa-2x" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row ">
                                    <div class="col-3 col-sm-5 col-md-4 col-lg-3  text-left">
                                        <img src="/images/caro.jpg" class="img-fluid rounded ">
                                    </div>
                                    <div class="text-left pink-color col-9  col-sm-7 col-md-8 col-lg-9 text-size-12">
                                        <p class="text-left pink-color font-batman-bold m-0">
                                            @CarolinaMancini
                                        </p>
                                        <p class="text-size-12">
                                            Brand Manager de Lex Timer
                                            <br>
                                            CC desde 2019
                                            <br>
                                            4 Convocatorias
                                            <br>
                                            1 Premio
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <img src="/images/murray-paez-1.jpg" class="img-fluid">
                    </div>
                    <div class="col-12">
                        <a class="text-dark btn btn-lg btn-cantera" target="_blank" href="https://canteracreativa.wordpress.com/">Ver más</a>
                    </div>

                </div>

            </div>
        </div>

        <div class="row mb-2 justify-content-md-center text-center">
            <div class="col-12 pink-color">
                <h1 class="font-batman-bold" id="comenza-ahora"> Comenzá ahora</h1>
            </div>
            <div class="col-12">
                <p class="lead text-dark text-center">
                    Contanos sobre tu proyecto y nos pondremos en contacto.
                </p>
                <small class="lead text-dark text-center small">
                    Los campos marcados con <span class="text-danger">*</span> son obligatorios
                </small>
            </div>

            <form-contacto-marcas/>
        </div>

    </div>
</template>

<script>
    import BarMarcas from '../components/BarMarcas'
    import FormContactoMarcas from '../components/FormContactoMarcas'
    export default{
        components: {
            BarMarcas,
            FormContactoMarcas
        },
        data: () => ({
            currentSlide: 0,
            slides: 3
        }),
        methods: {
            prevSlide(){
                var owl = $('.owl-carousel');
                owl.owlCarousel();
                owl.trigger('prev.owl.carousel');
                if(this.currentSlide == 0) {
                    this.currentSlide = this.slides -1
                } else {
                    this.currentSlide -= 1
                }
            },
            nextSlide(){
                var owl = $('.owl-carousel');
                owl.owlCarousel();
                owl.trigger('next.owl.carousel');
                if(this.currentSlide == this.slides - 1) {
                    this.currentSlide = 0
                } else {
                    this.currentSlide += 1
                }
            },
            goToSlide(slide){
                var owl = $('.owl-carousel');
                owl.owlCarousel();
                owl.trigger('to.owl.carousel', [slide]);
                this.currentSlide = slide
            },
        },
        mounted() {
            var that = this;
            setTimeout(function(){
                $('.owl-carousel').owlCarousel({
                    loop: true,
                    nav: false,
                    dots: false,
                    items: 1,
                    onDragged: function(event) {
                        that.currentSlide = event.item.index - 2;
                    }
                })
            }, 1000);

        }
    }
</script>


<style lang="scss" scoped>

    #carouselExampleInterval h1 {
        font-size: 43px;
    }

    #carouselExampleInterval p {
        font-size: 1rem;
    }

    .carousel-indicators li {
        height: 15px;
        width: 15px;
        border-radius: 50%;
        background: transparent;
        border: 1px solid #f95568;
    }

    .carousel-indicators li.active {
        background: #f95568;

    }

    .big-font {
        font-size: 98px;
        font-weight: 200!important;
    }


    .left-3 {
        top: 3vh;
        left: 4vh;
    }


    .right-3 {
        right: 4vh;
        bottom: 3vh;
    }


    .background-slider-1 {
        background-image: url('~/../../images/marca-1.jpg');
        background-size: cover;
        background-position: center right;
        height: 600px;
    }


    .background-slider-2 {
        background-image: url('~/../../images/marca-2-bg.jpg');
        background-size: cover;
        background-position: center right;
        height: 600px;
    }


    .background-slider-3 {
        background-image: url('~/../../images/marca-3-bg.jpg');
        background-size: cover;
        background-position: center right;
        height: 600px;
    }


    .opacity-40 {
        opacity: 0.40;
    }

    .force-height-75px {
        height: 75px;
    }

    .force-height-150px {
        height: 150px;

    }

    .force-height-90px {
        height: 90px;

    }

    .hr-short {
        width: 100px;
        border-color: white;
        border-top: 3px solid white;
    }


    .text-size-12 {
        font-size: 12px;

    }

    .custom-shadow {
        box-shadow: 0px 5px 5px 0px rgba(0, 0, 0, 0.3);
    }

    @media (max-width: 576px) {
        .carousel-item h1 {
            font-size: 1.6rem;

        }

        .carousel-item p {
            font-size: 1rem;

        }

        .background-slider-1,
        .background-slider-2,
        .background-slider-3 {
            height: auto !important;
            background: none !important;
        }
    }
</style>
