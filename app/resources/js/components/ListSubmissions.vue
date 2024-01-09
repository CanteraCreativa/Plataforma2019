<template>
      <div class="container-fluid p-0">
          <div class="container-fluid p-0 table-responsive" v-if="selected_submission == null">
              <table class="table">
                  <thead>
                      <tr>
                          <th class="pink-color text-center border-top-0">Marca</th>
                          <th class="pink-color text-center border-top-0">Convocatorias</th>
                          <th class="pink-color text-center border-top-0">Idea</th>
                          <th class="pink-color text-center border-top-0">Estado</th>
                      </tr>
                  </thead>
                  <tbody v-if="paginatedSubmissions.length == 0">
                      <td colspan="4" class="text-center">
                          ¡Ya podés empezar a subir tus ideas!
                      </td>
                  </tbody>
                  <tbody v-else>
                      <tr v-for="submission in paginatedSubmissions">
                          <td class="text-center">{{ submission.announcement.company | string_limit(25) }}</td>
                          <td class="text-center">{{ submission.announcement.title | string_limit(25) }}</td>
                          <td class="text-center">{{ submission.name | string_limit(25) }}</td>
                          <td class="text-center">
                              <span v-if="submission.is_winner" class="badge-info badge badge-pill tags p-2">Ganadora</span>
                              <span v-else-if="submission.state === 0" class="badge-warning badge badge-pill tags p-2">Pendiente</span>
                              <span v-else-if="submission.state === 1" class="badge-success badge badge-pill tags p-2">Aceptada</span>
                              <span v-else-if="submission.state === 2" class="badge-danger badge badge-pill tags p-2">Rechazada</span>

                              <a href="#" @click="selected_submission = submission"><i class="fa fa-eye" aria-hidden="true"></i></a>
                          </td>
                      </tr>
                  </tbody>
              </table>
              <div class="paginator text-dark container-fluid text-right">
                  <a href="#" @click="page -= previousPage !== null ? 1 : 0"><</a>
                  {{ intervalStart + 1 }} - {{ intervalEnd }}
                  <a href="#" @click="page += nextPage !== null ? 1 : 0">></a>
              </div>
              <div class="container-fluid text-center">
                  <router-link to="/contests">
                      <a class="btn btn-cantera2">Participar en convocatorias</a>
                  </router-link>
              </div>
          </div>
          <div class="selected-submission container-fluid" v-else>
              <div class="selected-submission-header row py-3">
                  <div class="col border-right">
                      <p class="text-dark"><span class="pink-color mr-4">Marca</span> {{ selected_submission.announcement.company }}</p>
                  </div>
                  <div class="col">
                      <p class="text-dark"><span class="pink-color mr-4">Convocatoria</span> {{ selected_submission.announcement.title }}</p>
                  </div>
              </div>
              <div class="selected-submission-body row">
                  <div class="col-12 mb-4">
                      <p><strong class="text-dark">Título de tu Idea</strong></p>
                      <input type="text" v-model="selected_submission.name"
                          class="form-control p-2" id="inlineFormCustomSelect" disabled>
                  </div>
                  <div class="col-12 mb-4">
                      <p><strong class="text-dark">Descripción de tu idea</strong></p>
                      <textarea v-model="selected_submission.description"
                                class="form-control" id="idPresentacion" rows="3" disabled></textarea>
                  </div>
                  <div class="col-12 mb-4">
                      <p><strong class="text-dark">Imagen de referencia</strong></p>
                      <img :src="selected_submission.image_file" class="d-block w-50" />
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-6 text-right">
                      <a class="btn float-right text-dark" @click="selected_submission = null">Volver</a>
                  </div>
                  <div class="col-md-6 text-left">
                      <a class="btn btn-cantera2" @click="$router.push('/contests/'+selected_submission.announcement.id)">Subir otra idea</a>
                  </div>
              </div>
          </div>
      </div>
</template>


<script>
import CardSubmission from '../components/CardSubmission'

    export default {
      components: {
        CardSubmission,
      },
      props: {
        creative: {
          type: Object
        }
      },
      data: () => ({
        submissions: null,
        selected_submission: null,
        numberOfElements: 10,
        page: 1,
      }),
      computed: {
        paginatedSubmissions() {
            if(this.submissions == null) {
                return [];
            }
            var start = (this.page - 1) * this.numberOfElements
            var end = start + this.numberOfElements;
            return this.submissions.slice(start, end)
        },
        previousPage() {
            if(this.page == 1 || this.submissions == null) return 1
            return this.page - 1
        },
        nextPage() {
            if(this.submissions == null) return 1
            if((this.intervalStart + this.numberOfElements) > this.submissions.length) return null
            return this.page + 1
        },
        intervalStart() {
            if(this.submissions == null) return null
            return (this.page - 1) * this.numberOfElements
        },
        intervalEnd() {
            if(this.submissions == null) return null
            return (this.intervalStart + this.numberOfElements) > this.submissions.length ? this.submissions.length : this.intervalStart + this.numberOfElements;
        },
        pages() {
            if(this.submissions == null) return 1
            return Math.ceil(this.submissions.length / this.numberOfElements)
        }
      },
      created () {
        this.fetchSubmissions()
      },
      methods: {
        fetchSubmissions() {
          let that = this;

          setTimeout(function() {
              axios.get('/api/submissions/').then((response) => {
                  that.submissions = response.data.data;
              })
          }, 500);

        },
        sendDelete(submission) {
            if(confirm("Seguro?")) {
                axios.delete('/api/submissions/' + submission.id)
                    .then((response) => {
                        this.$toasted.show('Idea eliminada con éxito')
                        this.$nextTick(() => {
                            this.fetchSubmissions()
                        })
                    })
                    .catch(err => {
                        this.$emitirToastError(err)
                    })
            }
        }
      }
    }
</script>


<style lang="css" scoped>
.clickeable {
  cursor: pointer;
}
.trash:hover {
  color: red;
}
a:link {
  text-decoration: none;
  color: inherit;
}

a:visited {
  text-decoration: none;
  color: inherit;
}

a:hover {
  text-decoration: none;
  color: inherit;
}

a:active {
  text-decoration: none;
  color: inherit;
}
</style>
