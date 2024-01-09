<template>
  <div class="text-dark row mb-2 justify-content-md-center">
    <div class="col-md-10 col-lg-8 p-5">
      <div class="row" v-if="!checkUser()">
        <div class="col-md-12">
          <h1 class="pink-color text-center font-batman-bold" >¡Creá tu cuenta!</h1>
        </div>
        <div class="col-md-12">
          <form-creativo-cuenta-rapida/>
        </div>
      </div>

      <div class="row" v-else>
        <div class="col-md-12">
          <h1 class="pink-color text-center" >Edición de perfil</h1>
          <p class="text-center">Los campos marcados con <span class="text-danger">*</span> son obligatorios</p>
        </div>
        <div class="col-md-12">
          <div class="form-row" v-if="!user_verified">
              <div class="alert alert-warning w-100" role="alert">
                <div class="row">
                    <div class="col-12 col-md-10">
                      <p>Aún no validaste tu cuenta de correo electrónico. Hasta entonces, no vas a poder participar de ninguna convocatoria.</p>
                    </div>
                    <div class="col-12 col-md-2">
                      <a class="float-right btn-sm btn btn-cantera2" @click="resend_mail">Reenviar confirmación</a>
                    </div>
                </div>
              </div>
            </div>
        </div>
        <div class="col-md-12">
            <form-complete-profile />
        </div>
      </div>
    </div>
  </div>
</template>


<script>
    import FormCreativoCuentaRapida from '../components/FormCreativoCuentaRapida'
    import FormCompleteProfile from '../components/FormCompleteProfile'

    export default {
      components: {
        FormCreativoCuentaRapida,
          FormCompleteProfile
      },
      data: () => ({
          user_verified: true,
      }),
      methods: {
        checkUser() {
            var that = this
            return that.$route.params.token !== undefined || that.$auth.check()
        },
        resend_mail () {
          axios.post('/api/email/resend', {})
          .then((response) => {
            this.$toasted.show('Correo de validación enviado con éxito')
          })
        }
      },
    }
</script>


<style lang="css" scoped>
  /*
   * Globals
   */

  /* Custom default button */
  .btn-secondary,
  .btn-secondary:hover,
  .btn-secondary:focus {
    color: #333;
    text-shadow: none; /* Prevent inheritance from `body` */
    background-color: #fff;
    border: .05rem solid #fff;
  }






</style>
