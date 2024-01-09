<template>
    <div class="text-dark">
        <div class="w-100 d-block">

            <div class="carousel-container position-relative">
                <div class="owl-carousel w-100">

                    <div class="w-100">
                        <div class="row m-0 justify-content-md-center">
                            <div class="col-12 col-md-7 p-0 background-slider-1">
                                <img class="d-block d-sm-none" src="/images/creativos-1.jpg" />
                            </div>
                            <div class="col-12 col-md-5 d-flex align-items-center">
                                <div class="carousel-text">
                                    <h1 class="font-batman-bold pink-color">
                                        Desarrollá<br>
                                        tu creatividad
                                    </h1>
                                    <p class="lead">
                                        Participá en diversos desafíos de creatividad, colaborando con marcas de tu interés.
                                    </p>
                                    <p class="font-batman-bold">
                                        <a class="btn btn-lg btn-cantera2" href="#comenza-ahora" v-if="!$auth.check()">Registrate</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-100">
                        <div class="row m-0 justify-content-md-center">
                            <div class="col-12 col-md-7 p-0 background-slider-2">
                                <img class="d-block d-sm-none" src="/images/creativos-2.jpg" />
                            </div>
                            <div class="col-12 col-md-5 d-flex align-items-center">
                                <div class="carousel-text">
                                    <h1 class="font-batman-bold pink-color">
                                        Exponé<br>
                                        tu talento
                                    </h1>
                                    <p class="lead text-dark">
                                        Presentá tus ideas y obtené reconocimiento en premios, capacitaciones y otros beneficios.
                                    </p>
                                    <p class="font-batman-bold">
                                        <a class="btn btn-lg btn-cantera2" href="#comenza-ahora" v-if="!$auth.check()">Registrate</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-100">
                        <div class="row m-0 justify-content-md-center">
                            <div class="col-12 col-md-7 p-0 background-slider-3">
                                <img class="d-block d-sm-none" src="/images/creativos-3.jpg" />
                            </div>
                            <div class="col-12 col-md-5 d-flex align-items-center">
                                <div class="carousel-text">
                                    <h1 class="font-batman-bold pink-color">
                                        Sé parte de<br>
                                        una comunidad
                                    </h1>
                                    <p class="lead text-dark">
                                        Participá de una comunidad que valora y se divierte con la creatividad tanto como vos.
                                    </p>
                                    <p class="font-batman-bold">
                                        <a class="btn btn-lg btn-cantera2" href="#comenza-ahora" v-if="!$auth.check()">Registrate</a>
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

        <div v-if="false" class="row justify-content-md-center background-humo-colores">
            <div class="col-md-4 col-sm-12 p-5">
                <div class="container d-flex h-100">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="title pink-color font-batman-bold" >¡Desafiá tus habilidades, poné a prueba tu talento creativo!</h1>
                        </div>
                        <div class="col-md-12 text-white">
                            <p class="lead">Los miembros de Cantera Creativa compiten para resolver desafíos creativos y participan de convocatorias realizadas por marcas reales</p>
                        </div>
                        <div class="col-md-12">
                            <router-link v-if="!$auth.check()" class="btn btn-cantera font-batman-bold" :to="{name: 'profile_edit'}">INSCRIBITE YA!</router-link>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 p-5">
            </div>
        </div>

        <div class="row mb-2 justify-content-md-center px-5 py-2">
            <div class="row mb-2">
                <div class="col-md-12">
                    <br>
                    <h1 class="text-center pink-color font-batman-bold" >¿Cómo funciona Cantera Creativa?</h1>
                </div>
            </div>
            <div class="row justify-content-md-center">
                <div class="col-md-10 col-lg-8 col-sm-12">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-3 col-md-6">
                            <div class="card custom-shadow h-100">
                                <div class="card-header pink-bg py-4">
                                    <div class="text-center">
                                        <img src="~/../../images/iconos/CC-Icons-05.svg" class="img-fluid force-height-75px" >
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3 class="lead pink-color font-batman-bold text-center card-title">
                                        01.<br>Creá<br>tu cuenta
                                    </h3>
                                    <p class="text-dark text-center">
                                        Creá tu perfil y contanos un poco acerca de vos.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card custom-shadow h-100">
                                <div class="card-header pink-bg py-4">
                                    <div class="text-center">
                                        <img src="~/../../images/iconos/CC-Icons-02.svg" class="img-fluid force-height-75px">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3 class="lead pink-color font-batman-bold text-center card-title">
                                        02.<br>Elegí<br>una convocatoria
                                    </h3>
                                    <p class="text-dark text-center">
                                        Nosotros diseñamos las convocatorias junto a las marcas; vos participá en aquellas que te interesen.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card custom-shadow h-100">
                                <div class="card-header pink-bg py-4">
                                    <div class="text-center">
                                        <img src="~/../../images/iconos/CC-Icons-06.svg" class="img-fluid force-height-75px" >
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3 class="lead pink-color font-batman-bold text-center card-title">
                                        03.<br>Presentá<br>tus ideas
                                    </h3>
                                    <p class="text-dark text-center">
                                        Escribí tu idea y compartí una imagen que ayude a ilustrarla.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card custom-shadow h-100">
                                <div class="card-header pink-bg py-4">
                                    <div class="text-center">
                                        <img src="~/../../images/iconos/CC-Icons-07.svg" class="img-fluid force-height-75px" >
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3 class="lead pink-color font-batman-bold text-center card-title">
                                        04.<br>Ganá<br>reconocimiento
                                    </h3>
                                    <p class="text-dark text-center">
                                        Las marcas premian a quienes presentaron las ideas que mejor se adapten a sus estrategias.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-md-center">
            <div class="col-md-12 col-sm-12 p-3">
                <br>
                <h1 class="font-batman-bold text-center pink-color mb-0">Presentá tus ideas creativas</h1>
                <h4 class=" text-center">Desarrollá tu creatividad en nuestras convocatorias</h4>
            </div>

            <div class="col-md-12 col-sm-12">
                <div class="row justify-content-md-center">
                    <div class="col-md-8">
                        <div class="row justify-content-md-center">
                            <div class="col-10 offset-1 offset-md-0 col-md-4 p-3" v-for="convocatoria in convocatorias">
                                <image-price :contest="convocatoria" />
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <div class="col-md-12  text-center">
                                <router-link :to="{name: 'contests'}" class="btn btn-cantera3 btn-sm">Ver todas las convocatorias</router-link>
                            </div>
                        </div>
                        <div class="row justify-content-md-center text-center" v-if="false">
                            <div class="col-md-4 p-3">
                                <span class="numero_acumulado">{{statistics.awarded_prizes | show_prize}}</span>
                                <p>Premios otorgados</p>
                            </div>
                            <div class="col-md-4 p-3">
                                <span class="numero_acumulado">{{statistics.submitted_ideas}}</span>
                                <p>Ideas recibidas</p>
                            </div>
                            <div class="col-md-4 p-3">
                                <span class="numero_acumulado">{{statistics.registered_creatives}}</span>
                                <p>Creativos registrados</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row text-center justify-content-center pb-0 background_grey" >
            <div class="col-12 pb-0">
                <div class="my-auto container d-flex h-100">
                    <div class="justify-content-center align-self-center mx-auto ">
                        <br>
                        <br>
                        <h1 class="font-batman-bold pink-color">Sumate</h1>
                        <br>
                        <p>Seguínos en nuestras redes para inspirarte y enterarte de todas las novedades que tenemos para vos</p>
                    </div>
                </div>
            </div>
            <div class="col-12 pt-0">

                <div class="row justify-content-center pt-0">
                    <div class="col-lg-10 justify-content-center pt-0">
                        <div class="row m-0 justify-content-center ">

                            <div class="col-6 col-sm-3">
                                <a target="_blank" href="https://www.instagram.com/canteracreativa/">
                                    <img src="/images/inst1.jpg" class="w-100 d-block" />
                                </a>
                            </div>
                            <div class="col-6 col-sm-3 ">
                                <a target="_blank" href="https://www.instagram.com/canteracreativa/">
                                    <img src="/images/inst2.jpg" class="w-100 d-block" />
                                </a>
                            </div>
                            <div class="col-6 col-sm-3 ">
                                <a target="_blank" href="https://www.instagram.com/canteracreativa/">
                                    <img src="/images/inst3.jpg" class="w-100 d-block" />
                                </a>

                            </div>
                            <div class="col-6 col-sm-3 ">
                                <a target="_blank" href="https://www.instagram.com/canteracreativa/">
                                    <img src="/images/inst4.jpg" class="w-100 d-block" />
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="comenza-ahora" class="row mb-2 justify-content-md-center" v-if="!$auth.check()">
            <div class="col-md-8 p-5">
                <div class="row">


                    <div class="col-md-12">
                        <h1 class="font-batman-bold text-center pink-color" >¡Creá tu cuenta!</h1>
                    </div>
                    <div class="col-md-12">
                        <form-creativo-cuenta-rapida/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import FormLogin from '../components/FormLogin'
    import ImagePrice from '../components/ImagePrice'
    import FormCreativoCuentaRapida from '../components/FormCreativoCuentaRapida'

    export default{
        components: {
            ImagePrice,
            FormCreativoCuentaRapida
        },
        data: () => ({
            currentSlide: 0,
            slides: 3,
            convocatorias: [],
            statistics: null
        }),
        created () {
            this.fetchContests()
            this.fetchStatistics()
        },
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
            days_remaining (date) {
                var seconds = this.$moment(date, 'YYYY-MM-DD').diff(this.$moment(), 'seconds')
                return seconds / 60 / 60 / 24 ;
            },
            fetchContests() {
                axios.get('/api/announcements?orderby=end_date', {orderby: 'end_date'}).then((response) => {
                    var convocatorias = response.data.data;
                    var proximamente = [];
                    var ultimoDia = [];
                    var ultimosDias = [];
                    var abierta = [];
                    var cerrada = [];

                    for(var x = 0; x < convocatorias.length; x++) {
                        if(convocatorias[x].state == 'proximamente') {
                            proximamente.push(convocatorias[x]);
                        } else if(convocatorias[x].state == 'cierra-hoy') {
                            ultimoDia.push(convocatorias[x]);
                        } else if(convocatorias[x].state == 'ultimos-dias') {
                            ultimosDias.push(convocatorias[x]);
                        } else if(convocatorias[x].state == 'abierta') {
                            abierta.push(convocatorias[x]);
                        } else {
                            cerrada.push(convocatorias[x]);
                        }
                    }
                    this.convocatorias = ultimosDias.concat(ultimoDia).concat(abierta).concat(proximamente).concat(cerrada).slice(0, 3);
                })
            },
            fetchStatistics() {
                axios.get('/api/statistics').then((response) => {
                    this.statistics = response.data
                })
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
        font-size: 3rem !important;
    }

    .altura-harcoded {
        height: 700px !important;
    }

    .background-slider-1 {
        background-image: url('/images/creativos-1-bg.jpg');
        background-size: cover;
        background-position: center right;
        height: 600px;
    }

    .background-slider-2 {
        background-image: url('/images/creativos-2-bg.jpg');
        background-size: cover;
        background-position: center right;
        height: 600px;
    }

    .background-slider-3 {
        background-image: url('/images/creativos-3-bg.jpg');
        background-size: cover;
        background-position: center center;
        height: 600px;
    }

    .background-humo-colores {
        background-image: url('/images/unsplash.jpg');
        min-height: 700px;
        background-size: cover;
        background-position: center;
    }

    .magic_image {
        height: 100%;
        position: absolute;
        max-width: inherit;
        bottom: 0;
        left: 60%;
    }

    .background_grey {
        background-color: #f3f3f3
    }

    .background_orange {
        background-color: #f26c4f;
        position: relative;
    }

    .numero_acumulado {
        font-size: 35px
    }

    .grayscale {
        filter: grayscale(100%)
    }

    .force-height-75px {
        height: 75px
    }

    .presentation-steps {
        position: relative
    }

    .presentation-steps .step {
        position: relative;
        margin-left: 80px;
        margin-bottom: 40px;
        margin-bottom: 4rem;
    }

    .presentation-steps .step.step4:before {
        content: '4'
    }

    .presentation-steps .step.step3:before {
        content: '3'
    }
    .presentation-steps .step.step2:before {
        content: '2'
    }
    .presentation-steps .step.step1:before {
        content: '1'
    }

    .presentation-steps .step:before {
        display: block;
        position: absolute;
        font-size: 45px;
        width: 65px;
        text-align: center;
        height: 65px;
        line-height: 65px;
        border-radius: 50%;
        margin: 10px auto;
        box-sizing: border-box;
        background-color: #f95568;
        color: #ffffff;
        left: -80px;
        top: -25px;
    }

    .custom-shadow {
        box-shadow: 0px 5px 5px 0px rgba(0, 0, 0, 0.3);
    }

    .btn-cantera3:hover {
        color: #f95568!important;
        background-color: #ffffff;
    }

    @media (max-width: 480px) {
        .big-font {
            font-size: 1.7rem !important
        }

        .background-slider-1,
        .background-slider-2,
        .background-slider-3 {
            height: auto!important;
            background: none!important
        }

    }


</style>
