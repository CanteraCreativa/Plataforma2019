<template>
  <div class="text-left">
      <div class="login-form-container m-auto">
          <div class="row">
              <div class="col-12">
                <label for="validationServerUsername">Correo electrónico</label>
                <div class="input-group">
                  <input type="text" v-model="form.email" :disabled="cargando"
                      @change="$v.form.email.$touch()"
                      :class="{'is-invalid': $v.form.email.$error}"
                      class="form-control" id="validationServerUsername" placeholder="" aria-describedby="inputGroupPrepend3" required>
                </div>
              </div>
          </div>
          <div class="row">
              <div class="col-12">
                <label for="validationServer01">Contraseña</label>
                <input type="password" v-model="form.password" :disabled="cargando"
                  @input="$v.form.password.$touch()"
                  :class="{'is-invalid': $v.form.password.$error}"
                   class="form-control" id="validationServer01" placeholder="" required>
              </div>
          </div>
          <div class="row">
              <div class="col-12">
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="gridCheck" v-model="form.terminos" :disabled="cargando">
                      <p class="form-check-label condiciones small" for="gridCheck">
                          Marcando esta caja, estás aceptando los
                          "<router-link to="/content/terminos-y-condiciones">
                          <a class="text-decoration-underline" target="_blank">Términos y Condiciones</a>
                      </router-link>"
                          y
                          "<router-link to="/content/politica-de-privacidad">
                          <a class="text-decoration-underline" target="_blank">Política de Privacidad</a>
                      </router-link>"
                          de la plataforma Cantera Creativa
                      </p>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-12">
                  <div id="id_grecaptcha" class="g-recaptcha" data-callback="callbackRecaptcha" data-sitekey="6LfvhMYUAAAAAM18SPpyA1TD-LOCrpgUHHMzF8Yg"></div>
              </div>
          </div>
          <div class="row">
              <div class="col-12">
                  <label >&nbsp</label>
                  <button @click="submit" v-if="!cargando" :disabled="!captcha || $v.form.$invalid || ! form.terminos" class="btn btn-cantera2 btn-block" type="submit">Comenzá ahora</button>
                  <button disabled v-else class="btn btn-light btn-block">Creando</button>
              </div>
          </div>
          <div class="row" v-if="false">
              <div class="col d-flex align-items-center">
                  <div style="border-top: 1px solid #343a40;height: 1px;width:46%"></div>
                  <span style="width:8%;background: #fff;text-align:center;">o</span>
                  <div style="border-top: 1px solid #343a40;height: 1px;width:46%"></div>
              </div>
          </div>
          <div class="row" v-if="false">
              <div class="col">
                  <div class="input-group rss-login shadow-sm mb-3 border rounded p-1 d-flex align-items-center">
                      <a href="/auth/google">
                          <div class="input-group-prepend">
                              <span class="input-group-text bg-white border-0 p-0"><img src="/images/logo-google.png" /></span>
                          </div>
                      </a>
                      <a href="/auth/google" class="form-control border-0 text-center">
                          <span>Con tu cuenta de Google</span>
                      </a>
                  </div>
              </div>
          </div>
          <div class="row" v-if="false">
              <div class="col">
                  <div class="input-group rss-login shadow-sm mb-3 border rounded p-1 d-flex align-items-center">
                      <div class="input-group-prepend">
                          <a href="/auth/facebook">
                                <span class="input-group-text bg-white border-0 p-0">
                                    <img src="/images/logo-fb.png" />
                                </span>
                          </a>
                      </div>
                      <a href="/auth/facebook" class="form-control border-0 text-center">
                          <span>Con tu cuenta de Facebook</span>
                      </a>
                  </div>
              </div>
          </div>
    </div>



  </div>
</template>


<script>
    import { required, email } from 'vuelidate/lib/validators'

    export default {
      data: () => ({
        captcha: false,
        form: {
          password: '',
          email: '',
          terminos: false,
        },
        cargando: false
      }),
      validations: {
        form: {
          email: {
            required,
            email
          },
          password: {
            required,
          }
        }
      },
      created () {
        let that = this
        window.callbackRecaptcha = function (response) {
            console.log("Callback recaptcha")
            if (response!=null) {
                console.log("Response Null")
                if(process.env.MIX_APP_ENV == 'dev') {
                    that.captcha = true
                }
              else {
                that.checkRecaptcha(response)
              }
            }
        }
      },
      mounted () {
        let recaptchaScript = document.createElement('script')
        recaptchaScript.setAttribute('src', 'https://www.google.com/recaptcha/api.js')
        document.head.appendChild(recaptchaScript)
          if(process.env.MIX_APP_ENV == 'dev') {
              let that = this
              that.captcha = true
          }
      },
      methods: {
        submit () {
          this.form.name = this.form.email
          this.form.password_confirmation = this.form.password
          this.cargando = true
          axios.post(window.baseUrl+'/api/register', this.form, {
            headers: {
              'Content-Type': 'application/json'
            }
          })
          .then((response) => {
            this.$auth.login({
              data: this.form,
              rememberMe: true,
              redirect: {
              },
              success (res) {
                this.cargando = false
                this.$router.push("complete_profile")
              }
            })
          })
          .catch((failure) => {
              console.log("Acá falló")
            this.cargando = false
            this.$emitirToastError(failure.message)
          })
        },
        checkRecaptcha (token) {
            let that = this
            if(process.env.MIX_APP_ENV == 'dev') {
                that.captcha = true
            } else {
                let data = {
                    response: token,
                    secret: '6LfvhMYUAAAAAGPvg0j-AyYmYqctvzFbRdtpdAZG'
                }
                axios.post('https://www.google.com/recaptcha/api/siteverify', data, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then((response) => {
                    that.captcha = response.success
                }).catch((response) => {
                    that.captcha = true
                })
            }

        }
      }
    }
</script>


<style lang="css" scoped>
    .login-form-container {
        width: 100%;
        max-width: 380px;
    }

    .rss-login .form-control span{
        font-size: 14px;
    }

    .rss-login .form-control a:hover{
        text-transform:none;
        color:inherit;
    }
</style>
