<template>
  <div class="p-4 text-left text-dark">
      <div class="form-row">
          <div class="col-md-6">
              <label for="validationServer01"><strong>Nombres<span class="text-danger">*</span></strong></label>
              <input type="text" v-model="form.first_name" :disabled="cargando"
                     @input="$v.form.first_name.$touch()"
                     :class="{'is-invalid': $v.form.first_name.$error}"
                     class="form-control" id="validationServer01" placeholder="" required>
          </div>
          <div class="col-md-6">
              <label for="validationServer02"><strong>Apellidos<span class="text-danger">*</span></strong></label>
              <input type="text" v-model="form.last_name" :disabled="cargando"
                     @input="$v.form.last_name.$touch()"
                     :class="{'is-invalid': $v.form.last_name.$error}"
                     class="form-control" id="validationServer02" placeholder="" required>
          </div>
      </div>

    <div class="form-row">
      <div class="col-md-6">
        <label for="validationServerUsername"><strong>Correo electrónico<span class="text-danger">*</span></strong></label>
        <div class="input-group">
          <input type="text" v-model="form.email" :disabled="cargando"
              @change="$v.form.email.$touch()"
              :class="{'is-invalid': $v.form.email.$error}"
              class="form-control" id="validationServerUsername" placeholder="" aria-describedby="inputGroupPrepend3" required>
        </div>
      </div>
        <div class="col-md-6">
            <label for="validationServer02"><strong>Marca</strong></label>
            <input type="text" v-model="form.brand" :disabled="cargando"
                   class="form-control" id="validationServer02" placeholder="" required>
        </div>
    </div>



    <div class="form-row">
      <div class="col-md-12">
        <textarea class="form-control" :disabled="cargando"
        placeholder="¿En qué podemos ayudarte?"
         v-model="form.message" id="exampleFormControlTextarea1" rows="3"></textarea>
      </div>
    </div>

      <div class="form-row">
          <div class="col-12">
              <div id="id_grecaptcha" class="g-recaptcha" data-callback="callbackRecaptcha" data-sitekey="6LfvhMYUAAAAAM18SPpyA1TD-LOCrpgUHHMzF8Yg"></div>
          </div>
      </div>

    <div class="form-row">
      <div class="col-md-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck" v-model="form.receive_updates" :disabled="cargando">
            <label class="form-check-label" for="gridCheck">
                Quiero recibir novedades sobre casos de innovación de Cantera Creativa
            </label>
          </div>
      </div>
    </div>

    <div class="form-row">
      <div class="col-12 col-sm-3 m-auto">
        <button v-if="!cargando" @click="submit" :disabled="!captcha || $v.form.$invalid" class="btn btn-cantera2 btn-block">Enviar</button>
        <button disabled v-else class="btn btn-light btn-block">Enviando</button>
      </div>

    </div>
  </div>
</template>


<script>
    import { required, email } from 'vuelidate/lib/validators'

    export default {
      data: () => ({
        captcha: false,
        cargando: false,
        form: {
          email: '',
          first_name: '',
          last_name: '',
            brand: '',
          message: '',
          receive_updates: false,
        }
      }),
      validations: {
        form: {
          email: {
            required,
            email
          },
          first_name: {
            required,
          },
          last_name: {
            required,
          }
        }
      },
      created () {
        let that = this
        window.callbackRecaptcha = function (response) {
            if (response!=null) {
              if (window.location.host === 'localhost') {
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
          this.cargando = true
          axios.post('/api/contact-messages', this.form, {
            headers: {
              'Content-Type': 'application/json'
            }
          })
          .then((response) => {
            this.cargando = false
            this.form.email = ''
            this.form.first_name = ''
            this.form.last_name = ''
            this.form.brand = ''
            this.form.message = ''
            this.form.receive_updates = false
            this.$toasted.show('Mensaje enviado con éxito')
            this.$nextTick(() => { this.$v.$reset()  })
          })
          .catch((failure) => {
            this.cargando = false
            this.$emitirToastError(failure)
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

/*
 * Header
 */
.masthead {
  margin-bottom: 2rem;
}

.masthead-brand {
  margin-bottom: 0;
}

.nav-masthead .nav-link {
  padding: .25rem 0;
  font-weight: 700;
  color: rgba(255, 255, 255, .5);
  background-color: transparent;
  border-bottom: .25rem solid transparent;
}

.nav-masthead .nav-link:hover,
.nav-masthead .nav-link:focus {
  border-bottom-color: rgba(255, 255, 255, .25);
}

.nav-masthead .nav-link + .nav-link {
  margin-left: 1rem;
}

.nav-masthead .active {
  color: #fff;
  border-bottom-color: #fff;
}

@media (min-width: 48em) {
  .masthead-brand {
    float: left;
  }
  .nav-masthead {
    float: right;
  }
}

</style>
