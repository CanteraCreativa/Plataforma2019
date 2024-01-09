<template>
    <div  class="body">
      <div class="d-flex w-100 flex-column">

          <header class="p-3">
            <app-header></app-header>
          </header>

          <transition class="inner mt-auto mb-auto" name="fade" mode="out-in">
              <router-view></router-view>
          </transition>


          <footer class="pink-bg pt-2">
            <div class="inner  mastfoot text-center pt-3">
              <div class="row">
                <div class="col-12">
                  <span class="p-2">
                      <a href="mailto:contacto@canteracreativa.com" target="_blank" style="border:0;text-decoration: none;">
                          <img src="/images/social-sobre.png" />
                      </a>
                  </span>
                  <span class="p-2">
                   <a href="https://www.instagram.com/canteracreativa/" target="_blank" style="border:0;text-decoration: none;">
                        <img src="/images/social-ig.png" />
                    </a>
                  </span>
                  <span class="p-2">
                    <a href="https://www.facebook.com/CanteraCreativa/" target="_blank" style="border:0;text-decoration: none;">
                                    <img src="/images/social-fb.png" />
                                </a>
                  </span>
                  <span class="p-2">
                    <a href="https://www.linkedin.com/company/canteracreativa/" target="_blank" style="border:0;text-decoration: none;">
                                    <img src="/images/social-in.png" />
                                </a>
                  </span>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <p>© Somos Cantera Creativa. Todos los derechos reservados {{ new Date().getFullYear() }}.</p>
                  <p>
                    <small>
                        <a href="/content/terminos-y-condiciones">Términos y condiciones</a> -
                        <a href="/content/politica-de-privacidad">Política de privacidad</a>
                    </small>
                  </p>

                </div>
              </div>
            </div>
          </footer>
      </div>
    </div>
</template>


<script>
    import AppHeader from './components/AppHeader'

    export default {
        name: 'App',
        components: {
            AppHeader
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>
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

<style lang="sass">

.flex-1
  flex: 1

hr.pink
  border-top: 1px solid #f95568

hr.white
  border-top: 1px solid white

.fade-enter-active,
.fade-leave.active
    transition: opacity .2s

.fade-enter,
.fade-leave-to
    opacity: 0

.btn-cantera
  background-color: transparent
  border: .05rem solid red
  color: white


.btn-cantera:hover:enabled,
a.btn-cantera:hover
  background-color: #f95568
  color: white !important

.btn-cantera2
  background-color: #f95568
  color: white !important

.multiselect__tag
  background-color: #f95568


.btn-cantera2:hover:enabled,
a.btn-cantera2:hover
  background-color: darken(#f95568, 5%)


.btn-cantera3
  background-color: #f95568
  color: white !important
  border: 1px solid white
  border-radius: .5rem


.btn-cantera3:hover:enabled,
a.btn-cantera3:hover
  background-color: darken(#f95568, 10%)

.pink-color
  color: #f95568!important

.light-pink-color
  color: lightpink

.multiselect__option--highlight
  background-color: #f95568
  outline: none
  color: #fff

.text-decoration-underline
  text-decoration: underline

@font-face
 font-family: "Gotham"
 src: url("~/fonts/Gotham-Book_0.otf")

@font-face
 font-family: "GothamBold"
 src: url("~/fonts/GOTHAM-BOLD.OTF")

.gotham-bold
    font-family: "GothamBold"

.body
  font-family: "Gotham"
  color: white
  min-height: 100%
  display: -ms-flexbox
  display: -webkit-box
  display: flex
  -ms-flex-pack: center
  -webkit-box-pack: center
  justify-content: center
  background-color: white

.hover-pink-color:hover
  color: #f95568

.hover-pink-bg:hover
  background-color: #f95568

.pink-bg
  background-color: #f95568

.light-pink-bg
  background-color: lightpink

.font-batman-bold
  font-family: "GothamBold"

.text-size-10
  font-size: 11px

.card-box-shadow
  -webkit-box-shadow: 10px 10px 10px 0px rgba(0,0,0,0.30)
  -moz-box-shadow: 10px 10px 10px 0px rgba(0,0,0,0.30)
  box-shadow: 10px 10px 10px 0px rgba(0,0,0,0.30)

.card-title
  line-height: 22px

</style>
