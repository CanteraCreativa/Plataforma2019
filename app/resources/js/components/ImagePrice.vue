<template>
    <router-link class="image-price-link" :to="{name: 'contest_view', params: {id: contest.id}}">
        <div class="card pink-bg custom-shadow border-0 h-100">
            <div class="card-img-top position-relative">
                <v-hover class="mx-auto" v-slot:default="{ hover }">
                    <v-img class="altura-harcoded" :class="{'grayscale': contest.state == 'finalizada'}" :src="contest.image_thumbnail">
                        <v-scale-transition>
                            <div v-if="hover" class="d-flex v-card-reveal px-2 py-1 m-auto">

                              <span class="btn btn-cantera2 text-white font-batman-bold">
                                  <span v-if="contest.state == 'proximamente' || contest.state == 'finalizada'">
                                    Ver
                                  </span>
                                  <span v-else>
                                      Participar
                                  </span>
                              </span>

                            </div>
                        </v-scale-transition>
                        <!-- por alguna razon no anda muy bien el v-expand-transition -->
                    </v-img>
                </v-hover>
                <div class="contest-state w-100 text-center text-white small" :class="contest.state">
                    <div class="py-1">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        <span v-if="contest.state == 'proximamente'">
                                      <strong>PRÓXIMAMENTE</strong>
                                </span>
                      <span v-else-if="contest.state == 'ultimos-dias'">
                        <strong>ÚLTIMOS DÍAS | Cierre {{ contest.end_date | show_date }}</strong>
                      </span>
                      <span v-else-if="contest.state == 'cierra-hoy'">
                        <strong>ÚLTIMO DÍA | Cierre {{ contest.end_date | show_date }}</strong>
                      </span>
                        <span v-else-if="contest.state == 'abierta'">
                          <strong>
                                ABIERTA | Cierre {{ contest.end_date | show_date }}
                          </strong>
                      </span>
                        <span v-else>
                          <strong>CERRADA</strong>
                      </span>
                    </div>
                </div>
            </div>

            <div class="card-body text-center p-0 d-flex flex-column justify-content-between">
                <div class="contest-title d-flex align-items-center flex-column">
                    <div class="w-100 m-0">
                        <h5 class="small text-dark">{{ contest.company }}</h5>
                    </div>
                    <div class="w-100 d-flex align-items-center flex-auto">
                        <h4 class="w-100 text-dark"><strong>{{ contest.title | parseRoguhNotation }}</strong></h4>
                    </div>
                </div>
                <div class="contest-description p-2 pt-3 d-flex flex-column">
                    <p class="text-dark">{{ getDescription(contest.short_description) | parseRoguhNotation }}</p>
                </div>
                <div class="contest-prize p-2 d-flex flex-column">
                    <p class="small text-dark"><i class="fa fa-trophy" aria-hidden="true"></i> Total en Premios <strong>{{contest.total_prize | show_prize}}</strong></p>
                    <a href="#" class="btn btn-default pink-color hover-pink-color w-100 border border-pink">Ver más</a>
                </div>
            </div>
        </div>
    </router-link>
</template>

<script>
    let shortcode = require('shortcode-parser')

    export default {

        components: {
        },
        props: {
            contest: {
                type: Object,
                required: true
            },
        },
        methods: {
            days_remaining (date) {
                var seconds = this.$moment(date, 'YYYY-MM-DD').diff(this.$moment(), 'seconds')
                return seconds / 60 / 60 / 24 ;
            },
            getStateBackground() {
                if(this.days_remaining(this.contest.start_date) > 0) {
                    return 'proximamente';
                }
                if(this.days_remaining(this.contest.end_date) > 0 && this.days_remaining(this.contest.end_date) <= 3) {
                    return 'cierra-hoy';
                }
                if(this.days_remaining(this.contest.end_date) > 3) {
                    return 'abierta';
                }

                return 'finalizada';
            },
            getDescription(description) {
                var more = '';
                var text = description;
                if(description.length > 100) {
                    more = '...';
                    text = description.slice(0, 100);
                }
                return text + more;
            }
        },
        beforeMount() {
            shortcode.add('rough', function(buf, opts){
                return buf;
            })
        },
        filters: {
            show_date(date) {
                var dateArray = date.split('-');
                return dateArray[2] + '.' + dateArray[1] + '.' + dateArray[0].substring(2, 4)
            },
            parseRoguhNotation(text) {
                if(text == null || text == undefined || text == '') {
                    return ''
                }
                return shortcode.parse(text)
            }
        }
    }

</script>


<style>
    .grayscale {
        -webkit-filter: grayscale(100%);
        filter: grayscale(100%)
    }
    .card-contest {
        padding-left: 35px;
        padding-right: 35px;
    }
    .contest-state {
        position: absolute;
        bottom: 0;
    }

.contest-state.proximamente {
    background: #54A6DF;
}
.contest-state.cierra-hoy,
.contest-state.ultimos-dias {
    background: #E99313;
}
.contest-state.abierta {
    background: #43AC64;
}
.contest-state.finalizada {
    background: #606060;
}
.image-price-link .card-body {
    background: #ffffff;
}

.image-price-link,
.image-price-link:hover {
    text-decoration: none;
}
.hover-pink-color:hover {
    color: #fff!important;
    background: #f95568;
}
.altura-harcoded {
    height: 300px;
}
.custom-shadow {
    box-shadow: 0px 5px 5px 0px rgba(0, 0, 0, 0.3)
}

.contest-title {
    padding: 15px 40px 22px;
    background: #ECECEC;
    -webkit-box-flex: 1;
    flex-grow: 1;
    flex: 1 0 auto;
}
.contest-title h5{
    margin-bottom: 15px;
}
.contest-title h4{
    line-height: 1.1;
    font-size: 18px;
}
.contest-prize {
    -webkit-box-flex: 0;
    flex-grow: 0;
    padding: 15px 20px 20px;
}

.contest-description {
    -webkit-box-flex: 2;
    height: 100px !important;
    background: #fbfbfb;
    justify-content: center;
    display: flex;
    padding: 15px 25px 25px;
}

.contest-description p,
.contest-title p{
    line-height: 1.1;
}

    .v-card-reveal {
        align-items: center;
        bottom: 0;
        left: 0;
        position: absolute;
        width: 100%;
        height: 100%;
        color: white;
        background-color: transparent;
        font-size: 20px;
        justify-content: center;
    }

    .flex-auto {
        flex: auto;
    }

    @media all and (max-width: 1400px) {
        .contest-title {
            padding: 15px;
        }
    }

    @media all and (max-width: 1400px) {
        .contest-title {
            padding: 15px;
        }
    }
</style>
