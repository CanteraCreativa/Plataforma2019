<template>
  <div class="row mb-2 justify-content-md-center">
    <div class="col-12 col-md-9">
      <div class="row">
        <div class="col-12">
          <h1 class="pink-color text-center font-batman-bold"> Presentá tus ideas creativas </h1>
            <h5 class="text-secondary text-center">Desarrollá tu creatividad en nuestras convocatorias</h5>
        </div>
        <div v-if="false">
            <div class="col-4">
                <multiselect
                  id="selecthabilidades"
                  v-model="filters.habilidad"
                  label="name"
                  track-by="id"
                  open-direction="bottom"
                  :options="habilidades"
                  :searchable="true"
                  :show-labels="false"
                  placeholder="Seleccione"
                  @input="filtrarContests"
                  :limit="4">
                  <span slot="noResult">Uy! No se encontraron habilidades.</span>
                  <span slot="placeholder" class="text-secondary font-weight-light">Habilidades</span>
                </multiselect>
             </div>
             <div class="col-4">
                 <multiselect
                   id="selectintereses"
                   v-model="filters.interes"
                   label="name"
                   track-by="id"
                   open-direction="bottom"
                   :options="intereses"
                   placeholder="Seleccione"
                   :searchable="true"
                   :show-labels="false"
                   @input="filtrarContests"
                   :limit="4">
                   <span slot="noResult">Uy! No se encontraron intereses.</span>
                   <span slot="placeholder" class="text-secondary font-weight-light">Intereses</span>
                 </multiselect>
              </div>
              <div class="col-4">
              <multiselect
                id="selectconsignas"
                v-model="filters.consigna"
                label="name"
                placeholder="Seleccione"
                track-by="id"
                open-direction="bottom"
                :options="consignas"
                :searchable="true"
                :show-labels="false"
                @input="filtrarContests"
                :limit="4">
                <span slot="noResult">Uy! No se encontraron consignas.</span>
                <span slot="placeholder" class="text-center text-secondary font-weight-light">Consignas</span>
              </multiselect>
           </div>
           <div class="col-12">
             <div class="input-group">
               <div class="input-group-prepend">
                 <span class="input-group-text"><span class="fa fa-search"></span></span>
               </div>
               <input type="text" v-model="filters.title" class="form-control" placeholder="Buscador por palabra" @change="filtrarContests">
             </div>
           </div>
        </div>
      </div>
         <div class="row m-0">
             <div class="col-contest col-md-4 col-sm-6" :key="contest.id" v-for="contest in paginatedContests">
                 <image-price :contest="contest" />
             </div>
         </div>
        <div class="row paginator text-dark">
            <div class="col text-center">
                <a href="#" @click="page -= previousPage !== null ? 1 : 0"><</a>
                <a href="#" class="mx-2" :class="{'pink-color': page == p}" v-for="p in pages" @click="page = p">{{ p }}</a>
                <a href="#" @click="page += nextPage !== null ? 1 : 0">></a>
            </div>
        </div>
     </div>
  </div>

</template>


<script>
import ImagePrice from '../components/ImagePrice'
import axios from 'axios'

    export default{
      components: {
          ImagePrice,
      },
      data: () => ({
        filters: {
          interes: null,
          consigna: null,
          habilidad: null,
          user_id: null,
          title: ''
        },
        page: 1,
        numberOfElements: 9,
        contests: [
        ],
        intereses: [
        ],
        consignas: [
        ],
        habilidades: [
        ],
      }),
      computed: {
          paginatedContests() {
              var start = (this.page - 1) * this.numberOfElements
              var end = start + this.numberOfElements;
              return this.contests.slice(start, end)
          },
          previousPage() {
              if(this.page == 1) return null
              return this.page - 1
          },
          nextPage() {
              if((this.intervalStart + this.numberOfElements) > this.contests.length) return null
              return this.page + 1
          },
          intervalStart() {
              return (this.page - 1) * this.numberOfElements
          },
          intervalEnd() {
              return (this.intervalStart + this.numberOfElements) > this.contests.length ? this.contests.length : this.intervalStart + this.numberOfElements;
          },
          pages() {
              return Math.ceil(this.contests.length / this.numberOfElements)
          }
      },
      created () {
        if (this.$route.query.user_id) {
          this.filters.user_id = this.$route.query.user_id
        }
        this.fetchSkills()
        this.fetchInterests()
        this.fetchConsignas()
        this.filtrarContests({orderby: 'end_date'})
      },
      mounted () {
      },
      methods: {
        fetchSkills() {
          axios.get('/api/skills').then((response) => {
            this.habilidades = response.data
          })
        },
        fetchInterests() {
          axios.get('/api/interests').then((response) => {
            this.intereses = response.data
          })
        },
        fetchConsignas() {
          axios.get('/api/guidelines').then((response) => {
            this.consignas = response.data
          })
        },
        fetchContests(filters) {
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
              this.contests = ultimoDia.concat(ultimosDias).concat(abierta).concat(proximamente).concat(cerrada);
          })
        },
        filtrarContests() {
          let filtros = {
            params: {
            }
          }
          if (this.filters.title)
            filtros.params.search = this.filters.title

          if (this.filters.user_id)
            filtros.params.creative = this.filters.user_id

          if (this.filters.consigna)
            filtros.params.guideline = this.filters.consigna.id

          if (this.filters.interes)
            filtros.params.interest = this.filters.interes.id

          if (this.filters.habilidad)
            filtros.params.skill = this.filters.habilidad.id

          this.fetchContests(filtros)
        }
      }
    }
</script>


<style lang="scss" scoped>
    a,
    a:link {
        text-decoration: none;
        color: inherit
    }


    a.pink-color {
        color: #f95568!important
    }

  .grayscale {
      filter: grayscale(100%)
  }

  .font_size08 {
      font-size: 0.8rem
  }

  .col-contest {
      padding-left: 35px;
      padding-right: 35px;
      padding-bottom: 70px
  }

    @media all and (max-width: 1400px) {
        .col-contest {
            padding-left: 15px;
            padding-right: 15px;
            padding-bottom: 50px
        }
    }

</style>
