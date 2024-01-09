<template>
  <div class="row m-0 text-dark justify-content-md-center" id="contestView">
    <div class="col-md-10  col-lg-8 p-0" v-if="contest">

      <div class="row">
          <div class="row m-0 col-12 col-md-4 d-flex align-items-center">
              <img class="mw-100" :class="{'grayscale': contest.state == 'finalizada'}" :src="contest.image_thumbnail" />
          </div>
          <div class="row m-0 col-12 col-md-8">
              <div class="col-12 px-5 py-0 contest-head-title">
                <p><small>{{contest.company}}</small></p>
                <h1 :inner-html.prop="contest.title | parseRoguhNotation"></h1>
              </div>
              <div class="col-12 px-5 contest-head-description">
                  <p :inner-html.prop="contest.short_description | parseRoguhNotation">
                  </p>
              </div>
          </div>
      </div>

      <div class="row">
          <div class="row d-block m-0 col-12 col-md-4">
              <div class="row mx-0 mb-3 py-0 col-12">
                  <div class="row m-0 pl-0 col-12 d-block contest-view-state text-white" :class="contest.state">
                      <div class="card-box"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
                        <span v-if="contest.state == 'proximamente'">PRÓXIMAMENTE</span>
                        <span v-else-if="contest.state == 'cierra-hoy'">ÚLTIMO DÍA</span>
                        <span v-else-if="contest.state == 'abierta'">ABIERTA</span>
                        <span v-else>CERRADA</span>
                  </div>
                  <div class="row m-0 pl-0 col-12 small custom-card-body end-date">
                      <div class="card-box"></div>
                      <span>&nbspCierre {{ contest.end_date | show_date }}</span>
                  </div>
              </div>

              <div class="row mx-0 mb-3 py-0 col-12">
                  <div class="row m-0 pl-0 col-12 py-2 d-block total-price-head">
                      <div class="card-box"><img src="/images/icono-premios.png" /></div>
                      <span>Total en premios</span>
                  </div>
                  <div class="col-12 pl-0 custom-card-body total-price-body">
                      <div class="card-box d-inline-block"></div>
                      <h5 class="m-0 gotham-bold d-inline-block">{{contest.total_prize | show_prize}}</h5>
                  </div>
              </div>

              <div class="row mx-0 mb-3 py-0 col-12" v-if="contest.brief_file !== null && contest.brief_file !== '' && contest.brief_file !== undefined">
                  <div class="col-12 pl-0 border">
                      <div class="card-box">
                        <img src="/images/icono-brief.png" />
                      </div>
                      <span>Descargá el <strong><a class="text-dark" :href="contest.brief_file" target="_blank">Brief</a></strong></span>
                  </div>
              </div>

              <div class="row mx-0 mb-3 py-0 col-12">
                  <div class="row mx-0 mb-3 pl-0 col-12 border">
                      <div class="card-box">
                          <img src="/images/icono-compartir.png" />
                      </div>
                      <div class="d-flex align-items-center justify-content-between compartir-convocatoria">
                          <span>Compartí la convocatoria</span>
                          <a :href="getMailTo()" target="_blank">
                            <img src="/images/icono-sobre.png" />
                          </a>
                          <a href="#" @click="copyUrl($event)">
                            <img src="/images/icono-copiar-link.png" />
                          </a>
                      </div>
                  </div>
              </div>

              <div class="row mx-0 mb-3 py-0 col-12 d-none d-md-block">
                  <div class="col-12 p-0">
                      <div class="col-12 p-0" v-if="!$auth.check()">
                          <p>Debes
                              <router-link to="/login">
                                  <a>iniciar sesión</a>
                              </router-link>
                              para poder participar de esta convocatoria</p>
                      </div>
                      <div class="col-12 p-0" v-else-if="$auth.user().email_verified_at == null">
                          <p>Debes
                              <router-link :to="'/profile/'+$auth.user().account.creative_data.id">
                                  <a>confirmar tu correo</a>
                              </router-link> para poder participar de este concurso</p>
                      </div>
                      <div class="col-12 p-0" v-else-if="!has_complete_profile()">
                          <p>Debes
                              <router-link :to="'/profile/'+$auth.user().account.creative_data.id">
                                  <a>completar tu perfil</a>
                              </router-link> para poder participar de este concurso</p>
                      </div>
                      <div class="col-12 p-0" v-else-if="contest.state == 'proximamente'">
                          <p>La convocatoria no ha sido abierta</p>
                      </div>
                      <div class="col-12 p-0" v-else-if="contest.state == 'finalizada'">
                          <p>La convocatoria ya terminó</p>
                      </div>
                      <div class="col-12 p-0" v-else>
                          <div v-if="!unido" class="container-fluid p-0">
                              <div class="form-row py-2 px-0">
                                  <button :disabled="!de_acuerdo" class="btn btn-block btn-cantera2 font-batman-bold" @click="inscribirse()" type="submit">Participar</button>
                              </div>
                              <div class="form-row">
                                  <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="gridCheck" v-model="de_acuerdo">
                                      <label class="form-check-label" for="gridCheck">
                                          Leí y acepto las <a target="_blank" :href="contest.rules_file">Normas de la Convocatoria</a>
                                      </label>
                                  </div>
                              </div>
                          </div>
                          <div v-else>
                              <div v-if="!subiendo_idea">
                                  <button @click="subiendo_idea = true; current_tab = 'tu-idea'" class="btn btn-block btn-cantera2 font-batman-bold" type="submit">Subir idea</button>
                              </div>
                              <div v-else>
                                  <button @click="submitting = !submitting" class="btn btn-block btn-cantera2 font-batman-bold" type="submit" :disabled="submitting">Subir idea</button>
                                  <button @click="subiendo_idea = false" class="btn btn-block btn-light mt-2" :disabled="submitting">Volver</button>
                              </div>

                              <label class="form-check-label mt-4" for="gridCheck">
                                  Leer <a target="_blank" :href="contest.rules_file">Normas de la Convocatoria</a>
                              </label>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="row d-block my-0 pr-0 col-12 col-md-8">
              <div class="row m-0 col-12 pr-0" v-if="!subiendo_idea">
                  <div class="tabs row m-0 p-0 col-12 text-center">
                      <div class="col-12 col-sm-3 py-0 pl-sm-0">
                          <h3 class="m-0 text-left text-sm-left" :class="{'tab-active': current_tab == 'marca'}"><a href="#" @click="changeTab('marca')">Marca</a></h3>
                      </div>
                      <div class="col-12 col-sm-3 py-0 border-left">
                          <h3 class="m-0 text-left text-sm-center tab-border" :class="{'tab-active': current_tab == 'desafio'}"><a href="#" @click="changeTab('desafio')">Desafío</a></h3>
                      </div>
                      <div class="col-12 col-sm-3 py-0 border-left">
                          <h3 class="m-0 text-left text-sm-center tab-border" :class="{'tab-active': current_tab == 'reglas'}"><a href="#" @click="changeTab('reglas')">Reglas</a></h3>
                      </div>
                      <div class="col-12 col-sm-3 py-0 pr-sm-0 border-left">
                          <h3 class="m-0 text-left text-sm-right tab-border" :class="{'tab-active': current_tab == 'ganadores'}"><a href="#" @click="changeTab('ganadores')">Ganadores</a></h3>
                      </div>
                  </div>
                  <div class="tabs-content px-0 d-block row m-0 col-12">
                      <div v-if="current_tab == 'marca'" class="row m-0 px-0 col-12">
                          <div class="col-12 px-sm-0 mb-3" :inner-html.prop="contest.context | parseRoguhNotation"></div>
                      </div>
                      <div v-if="current_tab == 'desafio'" class="row m-0 px-0 col-12">
                          <div class="col-12 px-sm-0 mb-3" :inner-html.prop="contest.challenge | parseRoguhNotation"></div>
                          <div v-if="$auth.check()" class="col-12 mb-3" :inner-html.prop="contest.alignments | parseRoguhNotation"></div>
                      </div>
                      <div v-if="current_tab == 'reglas'" class="row m-0 px-0 col-12">
                          <div class="col-12 px-sm-0 mb-3" :inner-html.prop="contest.rules_summary | parseRoguhNotation"></div>
                          <div class="col-12 px-sm-0">
                              <a :href="contest.rules_file" target="_blank">Descargar archivo de reglas</a>
                          </div>
                      </div>
                      <div v-if="current_tab == 'ganadores'" class="row m-0 px-sm-0 col-12">
                          <div class="col-12 px-0" :inner-html.prop="contest.winners | parseRoguhNotation"></div>
                      </div>
                  </div>
              </div>
              <div class="row m-2 m-sm-0" v-else>
                  <div class="tabs row m-0 p-0 col-12 text-center">
                      <div class="col-12 col-sm-3 py-0 pl-sm-0">
                          <h3 class="m-0 text-left text-sm-left" :class="{'tab-active': current_tab == 'tu-idea'}"><a href="#" @click="changeTab('tu-idea')">Tu idea</a></h3>
                      </div>
                      <div class="col-12 col-sm-3 py-0 border-left">
                          <h3 class="m-0 text-left text-sm-center tab-border" :class="{'tab-active': current_tab == 'reglas'}"><a href="#" @click="changeTab('reglas')">Reglas</a></h3>
                      </div>
                  </div>
                  <div class="tabs-content px-0 d-block row m-2 m-sm-0 col-12">
                      <div v-if="current_tab == 'tu-idea'" class="row m-0 col-12">
                          <span>Estamos ansiosos por conocer tu idea. Recordá seguir los lineamientos del DO's & DON'Ts al presentar tu idea. Los campos marcados con <span class="text-danger">*</span> son obligatorios.</span>
                          <div class="col-12 px-0">
                            <form-upgrade-proposal @atras="subiendo_idea=false" @error="submitting = false" :submitting="submitting" :contest="contest" />
                          </div>
                      </div>
                      <div v-if="current_tab == 'reglas'" class="row m-0 px-0 col-12">
                          <div class="col-12 px-0 mb-3" :inner-html.prop="contest.rules_summary | parseRoguhNotation"></div>
                          <div class="col-12 px-0">
                              <a :href="contest.rules_file" target="_blank">Descargar archivo de reglas</a>
                          </div>
                      </div>
                  </div>


              </div>

              <div class="row mx-0 mb-3 py-0 px-4 col-12 d-block d-md-none">
                  <div class="col-12 p-0">
                      <div class="col-12 p-0" v-if="!$auth.check()">
                          <p>Debes
                              <router-link to="/login">
                                  <a>iniciar sesión</a>
                              </router-link>
                              para poder participar de esta convocatoria</p>
                      </div>
                      <div class="col-12 p-0" v-else-if="$auth.user().email_verified_at == null">
                          <p>Debes
                              <router-link :to="'/profile/'+$auth.user().account.creative_data.id">
                                  <a>confirmar tu correo</a>
                              </router-link> para poder participar de este concurso</p>
                      </div>
                      <div class="col-12 p-0" v-else-if="!has_complete_profile()">
                          <p>Debes
                              <router-link :to="'/profile/'+$auth.user().account.creative_data.id">
                                  <a>completar tu perfil</a>
                              </router-link> para poder participar de este concurso</p>
                      </div>
                      <div class="col-12 p-0" v-else-if="contest.state == 'proximamente'">
                          <p>La convocatoria no ha sido abierta</p>
                      </div>
                      <div class="col-12 p-0" v-else-if="contest.state == 'finalizada'">
                          <p>La convocatoria ya terminó</p>
                      </div>
                      <div class="col-12 p-0" v-else>
                          <div v-if="!unido" class="container-fluid p-0">
                              <div class="form-row py-2 px-0">
                                  <button :disabled="!de_acuerdo" class="btn btn-block btn-cantera2 font-batman-bold" @click="inscribirse()" type="submit">Participar</button>
                              </div>
                              <div class="form-row">
                                  <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="gridCheck" v-model="de_acuerdo">
                                      <label class="form-check-label" for="gridCheck">
                                          Leí y acepto las <a target="_blank" :href="contest.rules_file">Normas de la Convocatoria</a>
                                      </label>
                                  </div>
                              </div>
                          </div>
                          <div v-else>
                              <div v-if="!subiendo_idea">
                                  <button @click="subiendo_idea = true; current_tab = 'tu-idea'" class="btn btn-block btn-cantera2 font-batman-bold" type="submit">Subir idea</button>
                              </div>
                              <div v-else>
                                  <button @click="submitting = !submitting" class="btn btn-block btn-cantera2 font-batman-bold" type="submit" :disabled="submitting">Subir idea</button>
                                  <button @click="subiendo_idea = false" class="btn btn-block btn-light mt-2" :disabled="submitting">Volver</button>
                              </div>

                              <label class="form-check-label mt-4" for="gridCheck">
                                  Leer <a target="_blank" :href="contest.rules_file">Normas de la Convocatoria</a>
                              </label>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

    </div>
  </div>
</template>

<script>
    import { annotate } from 'rough-notation';
    import moment from 'moment'

    import FormUpgradeProposal from '../components/FormUpgradeProposal'
    import AnnouncementWinners from '../components/AnnouncementWinners'

    let shortcode = require('shortcode-parser')

    export default {
      components: {
        AnnouncementWinners,
        FormUpgradeProposal,
      },
      data: () => ({
        uniendose_al_concurso: false,
        de_acuerdo: false,
        subiendo_idea: false,
        ver_ganadores: false,
        unido: false,
        contest_id: null,
        contest: null,
        current_tab: 'marca',
        current_rough: 1,
        submitting: false
      }),
      created () {
        this.contest_id = this.$route.params.id
        this.fetchContest()

        if (this.$auth.user().account) {
          axios.get('/api/creatives/' + this.$auth.user().account.creative_data.id).then((response) => {
            let subscripciones = response.data.data.subscriptions
            for (let index in subscripciones) {
              if (subscripciones[index].id == this.contest_id) {
                this.unido = true
                break
              }
            }
          })
        }
      },
      methods: {
          getMailTo() {
              var that = this;
              var mailTo = 'mailto:?subject=Cantera Creativa || '
              mailTo += this.contest.company.replace('&', '') + ' "' + this.contest.title + '"'
              mailTo += '&body=Hola%0D%0A%0D%0AMirate esta convocatoria de Cantera Creativa. Creo que te puede interesar mucho.%0D%0A%0D%0A'
              mailTo += 'Es para presentarle ideas a marcas reales; ideal para sumarle experiencia a tu carpeta creativa.%0D%0A%0D%0A'
              mailTo += that.contest.company.replace('&', '') + ' "' + that.contest.title + '". Tenés hasta el ' + that.contest.end_date + ' para presentar tus ideas.'
              mailTo += '%0D%0A%0D%0A'+window.location.href+''
              return mailTo
          },
          getFullUrl() {
              return window.location.href;
          },
          copyUrl(event) {
              event.preventDefault();
              const el = document.createElement('textarea');
              el.value = window.location.href;
              el.setAttribute('readonly', '');
              el.style.position = 'absolute';
              el.style.left = '-9999px';
              document.body.appendChild(el);
              const selected =  document.getSelection().rangeCount > 0  ? document.getSelection().getRangeAt(0) : false;
              el.select();
              document.execCommand('copy');
              document.body.removeChild(el);
              if (selected) {
                  document.getSelection().removeAllRanges();
                  document.getSelection().addRange(selected);
              }
              this.$toasted.show('Enlace copiado con éxito')

          },
          fetchContest() {
            axios.get('/api/announcements/' + this.contest_id).then((response) => {
              this.contest = response.data.data
            })
          },
          is_verified() {
              let that = this;
              axios.get('/api/is_verified')
                  .then((response) => {
                      return response.data;
                  })
                  .catch((failure) => {
                      return false
                  });
          },
          can_participate() {
              return (this.days_remaining(this.contest.start_date) < 0 || this.contest.start_date == new Date().toISOString().slice(0,10))  && this.days_remaining(this.contest.end_date) >= 0;
          },
          has_complete_profile() {
              return this.$auth.user().account.creative_data.is_profile_complete
          },
          check_date(start, end) {
              const date = new Date();

              var today = date.getFullYear() + '-' + date.getMonth() + '-';

              if(moment(today).isBefore(start)) {
                  return 'proximamente';
              }

              if(moment(today).isBefore(end)) {
                  return 'abierta';
              }

              if(moment(today).isSame(end)) {
                  return 'cierra-hoy';
              }

              return 'cerrada';
          },
          days_remaining (date, start = false) {
              if(this.isToday(date)) {
                  return 0.5;
              }
              if(start) {
                  if(moment().isBefore(date)) {
                      return 2
                  }
              }

              var seconds = this.$moment(date, 'YYYY-MM-DD').diff(this.$moment(), 'seconds')
              return seconds / 60 / 60 / 24;
          },
          isToday(date) {
              const today = new Date()
              const someDate = this.$moment(date, 'YYYY-MM-DD');
              console.log("-------------");

              console.log("Is Same: ");
              console.log(date);
              console.log(moment().isSame(date));
              console.log("-------------");

              return moment().isSame(date);

              return someDate.date() == today.getDate() &&
                  someDate.month() == today.getMonth() &&
                  someDate.year() == today.getFullYear()
          },
          format_date(value){
            if (value) {
                return moment(String(value)).format('DD.MM.YY')
            }
          },
          changeTab(tab) {
            var that = this
            this.current_tab = tab
            that.showNotations()
          },
          showNotations(timeout = 1000) {
              setTimeout(function() {
                  var annotations = []
                  $(".rough").each(function() {
                      var selector = $(this).attr('id')
                      var type = $(this).data('type')
                      var color = $(this).data('color')
                      if(type == 'brakets') {
                          var annotation = annotate(document.querySelector('#'+selector), { type: type, color: color, brackets: 'left' })
                          annotation.show()
                      }
                      var annotation = annotate(document.querySelector('#'+selector), { type: type, color: color, brackets: ['left', 'right'] })
                      annotation.show()
                  })
              }, timeout)
          },
        inscribirse () {
          if (!!this.$auth.user().email_verified_at) {
            axios.post('/api/announcements/' + this.contest_id + '/subscribe')
            .then((response) => {
              this.uniendose_al_concurso = false
              this.de_acuerdo = false
              this.subiendo_idea = false
              this.unido = true
              this.subiendo_idea = true
              this.current_tab = 'tu-idea'
              this.$toasted.show('Inscripción a la convocatoria exitosa')
            })
            .catch((err) => {
              this.$emitirToastError(err)
            })
          }
          else {
            this.$emitirToastError('Debés verificar tu mail antes de participar ('+ this.$auth.user().email + ')')
          }
        },
        desinscribirse () {
          axios.post('/api/announcements/' + this.contest_id + '/subscribe/')
          .then((response) => {
            this.uniendose_al_concurso = false
            this.de_acuerdo = false
            this.subiendo_idea = false
            this.unido = false
            this.$toasted.show('Desuscripción a la convocatoria exitosa')
          })
          .catch((err) => {
            this.$emitirToastError(err)
          })
        },
        formSubmited() {
          console.log("Submitted");
        }
      },
      beforeMount() {
        var that = this
        shortcode.add('rough', function(buf, opts){
            var type = 'underline'
            if (opts.type !== undefined) {
                type = opts.type
            }
            var color = 'red'
            if (opts.color !== undefined) {
                color = opts.color
            }
            var id = that.current_rough
            that.current_rough += 1
            return '<span id="rough-'+id+'" class="rough" data-type="'+type+'" data-color="'+color+'">'+buf+'</span>'
        })
      },
      mounted() {
          var that = this
          that.showNotations(3000)
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

<style lang="sass" scoped>

  .contest-head-title
    background: #ececec

  .contest-head-title
    h1
     color: #606060
     font-weight: 800
     font-size: 40px
     line-height: 1
     font-family: "GothamBold"

  .contest-head-description
      background: #fbfbfb

  .contest-head-description
    p
      color: #575756
      font-size: 25px
      line-height: 1

  .contest-view-state.proximamente
    background: #54A6DF

  .contest-view-state.cierra-hoy
    background: #E99313

  .contest-view-state.abierta
    background: #43AC64

  .contest-view-state.finalizada
    background: #606060

  .custom-card-body
    background: #fbfbfb

  .min-height-300
    min-height: 300px

  .max-height-400
    max-height: 400px

  .total-price-head
    background: #f5f5f5

  .contest-prize
    color: white
    font-size: 40px
    font-size: 4rem
    line-height: 1
    font-size: 2.6rem
    padding: 10px

  .contest-prize
    .small
      font-size: 16px

  .contest-info
      font-size: 2rem
      line-height: 28px
      line-height: 2.8rem
      padding: 0.5em 0
      min-height: 0

  .contest-info
    .small
      font-size: 16px

  .text-size-2vh
    font-size: 2vh

  .end-date, .total-price-body
    padding-left: 31px

  .total-price-body
    h4
      font-weight: 800

  .tabs
    h3
      font-family: "GothamBold"
      font-size: 30px

  .tabs
    h3.tab-active
      a
        color: #575756

  .tabs
    h3
      a
        color: #9c9b9b
        font-weight: 800

  .card-box
    width: 36px
    display: inline-block
    text-align: center

  .compartir-convocatoria
    width: calc(100% - 36px)
</style>


<style lang="scss">
#contestView ul,
#contestView ol {
    margin-left: 15px
}

@media all and (max-width: 480px) {
    .tab-border {
        border-top: 1px solid #ced4da;
    }

    .tab-active a {
        position: relative;
        z-index: 9;
        color: #f95568!important;
        border-bottom: 1px solid #f95568!important;
        padding-bottom: 1px;
    }
}

</style>
