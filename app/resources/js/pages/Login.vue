<template>
  <div class="text-dark row mb-2 justify-content-md-center">
    <div class="col-md-10 col-lg-8 p-5">
      <div class="row">
        <div class="col-md-12">
          <h1 class="pink-color text-center font-batman-bold">Iniciá sesión</h1>
        </div>
        <div class="col-md-12">
          <form-login/>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import FormLogin from '../components/FormLogin'

    export default {
      components: {
        FormLogin,
      },
      data: () => ({
      }),
      methods: {
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
