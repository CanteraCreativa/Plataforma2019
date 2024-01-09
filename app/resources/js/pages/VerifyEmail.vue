<template>
  <div class="text-dark row mb-2 justify-content-md-center">
    <div class="col-md-10 col-lg-8 p-5">
      <div class="row">
        <div class="col-md-12">
          <h1 class="pink-color text-center" >Bienvenido!</h1>
        </div>
        <div class="col-md-12">
            <div>
                <p>Dirección de correo verificada correctamente</p>
                <router-link to="/login">
                    <a class="form-control btn float-right btn-cantera2">Ingresar</a>
                </router-link>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  components: { },
  data: () => ({
    verificationStatus: null,
  }),
  methods: { },
  created() {
    /*this.$nextTick(() => {
      if (this.$route.query.verificationURL) {
        axios.post(this.$route.query.verificationURL, null, { params: { signature: this.$route.query.signature }}).then((response) => {
            this.verificationStatus = 'success'
          //location.href = window.baseUrl+'/login';
            //this.$route.push({name: 'landing'})
        }).catch((error) => {
          this.verificationStatus = 'error'
        })
      }
    })*/
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
