<template>
  <div class="h-100 backg" v-bind:style="backgroundStyle">
    <div class="container h-100" v-if="creative">
      <!-- <label for="uploadimage" class="position-absolute harcoded">
        <div v-if="$auth.user().account && creative.id === $auth.user().account.creative_data.id" class=" btn btn-light btn-circle btn-xl">
          <i class="fa fa-edit"></i>
        </div>
        <input type="file" @change="updateImage" id="uploadimage" style="display:none">
      </label> -->
      <div class="row h-100"  v-if="creative">

          <div class="col-12 col-sm-12 col-md-12 col-lg-5">
              <div class="w-100 pb-3 mb-1 section-header">
                  <h3 class="pink-color text-center">Información de perfil</h3>
              </div>
              <card-user @actualizar="fetchUser($route.params.id)" :creative="creative" :ver_entregas.sync="ver_entregas"/>
          </div>

          <div class="col-12 col-sm-12 col-md-12 col-lg-7">
              <div class="row" v-if="!user_verified">
                  <div class="alert alert-secondary w-100" role="alert">
                      <div class="row">
                          <div class="col-12 text-center">
                              <p class="pink-color">Aún no validaste tu cuenta de correo electrónico.<br>Hasta entonces, no vas a poder participar de ninguna convocatoria.</p>
                              <p><a class="btn-sm btn btn-cantera2" @click="resend_mail">Reenviar confirmación</a></p>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-12 p-0" v-else-if="$auth.user().account && creative.id === $auth.user().account.creative_data.id">
                  <div class="w-100 pb-3 mb-1 section-header">
                      <h3 class="pink-color text-center">Ideas presentadas</h3>
                  </div>
                  <v-scale-transition>
                      <list-submissions v-show="ver_entregas" :creative="creative"/>
                  </v-scale-transition>

              </div>
          </div>
      </div>
    </div>
  </div>

</template>


<script>
import CardUser from '../components/CardUser'
import ListSubmissions from '../components/ListSubmissions'

    export default{
      components: {
        ListSubmissions,
        CardUser,
      },
      data: () => ({
        creative: null,
        ver_entregas: false,
        user_verified: false,
        selected_submission: null,
      }),
      created () {
          var that = this
          if(that.$route.params.token !== undefined) {
              window.localStorage.setItem('cantera_creativa_session', that.$route.params.token)
              this.fetchUser(this.$route.params.id)
          }

          this.fetchUser(this.$route.params.id)
      },
      mounted () {
          let that = this;
          axios.get('/api/is_verified')
              .then((response) => {
                  console.log(response.data);
                  that.user_verified = response.data;
              })
              .catch((failure) => {
                  this.cargando = false
                  this.$emitirToastError(failure)
              });

          this.$auth.fetch().then(response => {
              console.log(response.data.account)
              if(!response.data.account.creative_data.is_profile_complete) {
                  that.$router.push({name: 'profile_edit'})
              }
          })
      },
      beforeRouteUpdate (to, from, next) {
        this.fetchUser(to.params.id)
        next()
      },
      computed: {
        // a computed getter
        backgroundStyle: function () {
          // `this` points to the vm instance
          if (this.creative && this.creative.background_image)
            return { backgroundImage: 'url(' + this.creative.background_image + ')' }
          else
            return {}
        }
      },
      methods: {
        fetchUser(id) {
            let that = this
            axios.get('/api/creatives/' + id).then((response) => {
                that.creative = response.data.data
                that.$auth.fetch().then(function(res) {
                    let account = that.$auth.user().account
                    that.ver_entregas = account && account.creative_data.id === that.creative.id
                })

            })
            this.$auth.fetch();
        },
        updateImage(imageEvent) {
          let newImage = imageEvent.target.files[0]
          let formData = new FormData()
          if (newImage) {
            formData.append('background_image', newImage)
            let headers = {
              headers: {
                "Content-Type": "multipart/form-data"
              }
            }
            axios.post('/api/creatives/background-image/', formData, headers)
            .then((response) => {
              this.$toasted.show('Imagen de fondo actualizada con éxito')
              this.$nextTick(() => {
                this.fetchUser(this.$route.params.id)
              })
            })
            .catch(err => {
              this.$emitirToastError(err)
            })
          }
        },
        resend_mail () {
          axios.post('/api/email/resend', {})
          .then((response) => {
            this.$toasted.show('Correo de validación enviado con éxito')
          })
        },
      }
    }
</script>


<style lang="css" scoped>
  .section-header {
      border-bottom: 2px solid #f95568;
  }
  .harcoded {
    right: 20px;
    z-index: 99;
  }
  .backg {
    background-position: center;
    background-size: cover;
  }
  .btn-circle.btn-xl {
      width: 70px;
      height: 70px;
      border-radius: 35px;
      font-size: 24px;
      line-height: 1.33;
      display: flex;
      align-items: center;
      justify-content: center;
  }

  .btn-circle {
      width: 30px;
      height: 30px;
      padding: 6px 0px;
      border-radius: 15px;
      text-align: center;
      font-size: 12px;
      line-height: 1.42857;
  }

</style>
