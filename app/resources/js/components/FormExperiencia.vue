<template>
  <div class="text-left">
      <div class="spinner-border text-danger" role="status" v-if="loading_page">
          <span class="sr-only">Loading...</span>
      </div>
      <div class="container-fluid p-0" v-else>
        <div class="form-row">
          <div class="col-md-4 col-12">
            <label for="validationServer03">Usuario</label>
            <input disabled type="text" :value="$auth.user().name"
            class="form-control" id="validationServer03" placeholder="">
          </div>
          <div class="col-md-4 col-6">
            <label for="validationServer01" class="required">Nombre*</label>
            <input :disabled="cargando" type="text" v-model="form.first_name"
              @input="$v.form.first_name.$touch()"
              :class="{'is-invalid': $v.form.first_name.$error}"
               class="form-control" id="validationServer01" placeholder="" required>
            <small v-if="$v.form.first_name.$error" class="alert-danger">El campo es obligatorio</small>
          </div>
          <div class="col-md-4 col-6">
            <label for="validationServer02" class="required">Apellido*</label>
            <input :disabled="cargando" type="text" v-model="form.last_name"
              @input="$v.form.last_name.$touch()"
              :class="{'is-invalid': $v.form.last_name.$error}"
              class="form-control" id="validationServer02" placeholder="" required>
              <small v-if="$v.form.last_name.$error" class="alert-danger">El campo es obligatorio</small>

          </div>
        </div>

        <div class="form-row">
          <div class="col-4">
            <label for="selectEstudios" class="required">Estudios*</label>
            <select :disabled="cargando" class="custom-select mr-sm-2" id="selectEstudios" v-model="form.studies"
            @change="$v.form.studies.$touch()"
            :class="{'is-invalid': $v.form.studies.$error}">
              <option selected value="">Seleccione</option>
              <option value="1">En curso</option>
              <option value="2">Completos</option>
              <option value="3">Incompletos</option>
            </select>
              <small v-if="$v.form.studies.$error" class="alert-danger">El campo es obligatorio</small>

          </div>
          <div class="col-4">
            <label for="selectSexo">Sexo</label>
            <select :disabled="cargando" class="custom-select mr-sm-2" id="selectSexo" v-model="form.gender"
            @change="$v.form.gender.$touch()"
            >
              <option selected value="">Seleccione</option>
              <option value="Male">Masculino</option>
              <option value="Female">Femenino</option>
              <!-- <option value="3">Otre</option> -->
            </select>
          </div>
          <div class="col-4">
            <label for="inputEdad" class="required">Edad*</label>
            <input :disabled="cargando" type="number" v-model="form.age"
              @input="$v.form.age.$touch()" min="1" max="100"
              :class="{'is-invalid': $v.form.age.$error}"
              class="form-control w-100" id="inputEdad" placeholder="" required>
              <small v-if="$v.form.age.$error" class="alert-danger">El campo es obligatorio</small>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-4 col-6">
            <label>Cuenta Youtube</label>
            <input :disabled="cargando" type="text" v-model="form.links[0]"
            class="form-control" placeholder="https://www.youtube.com/user/tuyoutube">
          </div>
          <div class="col-md-4 col-6">
            <label>Cuenta Instagram</label>
            <input :disabled="cargando" type="text" v-model="form.links[1]"
            class="form-control" placeholder="https://www.instragram.com/tuinstagram">
          </div>
          <div class="col-md-4 col-6">
            <label>Cuenta LinkedIn</label>
            <input :disabled="cargando" type="text" v-model="form.links[2]"
            class="form-control" placeholder="https://www.linkedin.com/in/tu-linked-in-22222/">
          </div>
          <div class="col-md-4 col-6">
            <label for="selectPaises">País</label>
            <select :disabled="cargando" class="custom-select mr-sm-2" id="selectPaises" v-model="form.country"
            @change="$v.form.country.$touch()"
            >
              <option selected value="">Seleccione</option>
              <option v-for="country in countries" :value="country" :key="country">{{ country }}</option>
            </select>
          </div>
          <div class="col-md-4 col-6">
            <label for="selectNacionalidad">Nacionalidad</label>
            <select :disabled="cargando" class="custom-select mr-sm-2" id="selectNacionalidad" v-model="form.nationality"
            @change="$v.form.nationality.$touch()"
            >
              <option selected value="">Seleccione</option>
              <option v-for="country in countries" :value="country" :key="country">{{ country }}</option>
            </select>
          </div>
          <div class="col-md-4 col-6">
            <label for="centroDeEstudiantes">Centro de Estudios</label>
            <input :disabled="cargando" type="text" v-model="form.studies_where"
              class="form-control" id="centroDeEstudiantes" placeholder="">
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-12" v-show="false">
            <label for="idMercadopago">Cuenta MercadoPago / CBU Homebanking</label>
            <input :disabled="cargando" type="text" v-model="form.mercadopago_account"
            @input="$v.form.mercadopago_account.$touch()"
            class="form-control" id="idMercadopago" placeholder="">
          </div>
          <div class="col-md-12">
              <label for="selectinterests">Intereses</label>

              <label class="w-100" v-for="interest in interests" :key="interest.id">
                  <input
                      type="checkbox"
                      :value="interest"
                      v-model="form.interests"
                  > {{ interest.name }}
              </label><br>

          </div>
        </div>

        <div class="form-row">
          <div class="col-12">
            <label for="idPresentacion">Texto de Presentación Personal</label>
            <textarea maxlength="500" :disabled="cargando" class="form-control"
            @input="$v.form.description.$touch()"
             placeholder="Presentate contando un poco de vos, que proyectos te interesan y porque"
             v-model="form.description" id="idPresentacion" rows="3"></textarea>
          </div>
        </div>
        <hr>
        <div class="form-row">
          <div class="col-md-12">
            <h4 class="pink-color required">Autoevaluación* </h4>
            <p>Definir Nivel - 0 a 10 de cada Habilidad</p>
          </div>
          <div class="col-12 d-flex flex-column justify-content-between" v-for="skill in form.skills">
            <label for="evalDisenio">{{skill.name}}</label>
              <div class="row d-none d-sm-block">
                  <div class="row col-12">
                      <div class="col"></div>
                      <div class="col" v-for="calificacion in calificaciones">{{calificacion}}</div>
                      <div class="col"></div>
                  </div>
                  <div class="row col-12">
                      <div class="col">Nula</div>
                      <div class="col" v-for="calificacion in calificaciones">
                          <input type="radio" v-model="skill.level" :value="calificacion" />
                      </div>
                      <div class="col">Experto</div>
                  </div>
                  <hr>
              </div>
              <div class="d-block d-sm-none">
                <select :disabled="cargando" class="custom-select mr-sm-2" id="evalDisenio" v-model="skill.level">
                    <option :value="calificacion" v-for="calificacion in calificaciones">{{calificacion}}</option>
                </select>
              </div>
          </div>

        </div>

        <div class="form-row">
          <div class="col-md-6">
            <div id="id_grecaptcha" class="g-recaptcha" data-callback="callbackRecaptcha" data-sitekey="6LfvhMYUAAAAAM18SPpyA1TD-LOCrpgUHHMzF8Yg"></div>
          </div>
          <div class="col-md-6">
            <button v-if="!cargando" :disabled="!captcha || $v.form.$invalid" @click="submit()" class="btn float-right btn-cantera2" type="submit">Guardar</button>
            <button v-else disabled class="btn float-right btn-cantera2" type="submit">Guardando</button>

            <span v-if="$v.form.$invalid">Asegurate de completar todos los datos antes de continuar</span>
          </div>

        </div>
      </div>
  </div>
</template>


<script>
    import { required, minValue, maxValue } from 'vuelidate/lib/validators'

    export default {
      data: () => ({
          loading_page: true,

          user: null,
        calificaciones: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
        cargando: false,
        countries: [],
        interests: [],
        captcha: false,
        form: {
          first_name: '',
          last_name: '',
          gender: '',
          age: '',
          studies_where: '',
          studies: '',
          description: '',
          nationality: '',
          country: '',
          mercadopago_account: '',
          links: [
            '',
            '',
            ''
          ],
          interests: [],
          skills: []
        }
      }),
      validations: {
        form: {
          studies: {
            required,
          },
          first_name: {
            required,
          },
          last_name: {
            required,
          },
          age: {
            required,
            minValue: minValue(1),
            maxValue: maxValue(100)
          },
          skills: {
            required,
          },
        }
      },
      async created () {
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
        await this.loadUserForm()
        await this.fetchCountries()
        await this.fetchInterests()
          that.loading_page = false;
      },
      async mounted () {
          let that = this

          let recaptchaScript = document.createElement('script')
            recaptchaScript.setAttribute('src', 'https://www.google.com/recaptcha/api.js')
            document.head.appendChild(recaptchaScript)
            if(process.env.MIX_APP_ENV == 'dev') {
              that.captcha = true
          }
          that.$v.$touch();
          /*for(let field in that.$v.$touch()) {
              field.$touch();
          }*/
      },
      methods: {
        submit() {
          let that = this
          that.cargando = true;
          let formdata = Object.assign({}, this.form)
          let creative_id =  this.$auth.user().account.creative_data.id
          formdata.interests = formdata.interests.map(interest => interest.id)
          formdata.links = formdata.links.filter(link => !!link)
          axios.put('/api/creatives/' + creative_id, formdata)
          .then((response) => {
            this.$toasted.show('Perfil editado correctamente')
            this.$router.push({ name: 'profile_view', params: { id: creative_id} })
          })
          .catch(err => {
            this.$emitirToastError(err)
          })
        },
        fetchSkills() {
          let userSkills = this.form.skills.map(skill => skill.id)
          axios.get('/api/skills').then((response) => {
            response.data.forEach((skill) => {
              if (!userSkills.includes(skill.id)) {
                this.form.skills.push({
                  id: skill.id,
                  name: skill.name,
                  level: 0
                })
              }
            })
          })
        },
        fetchInterests() {
          axios.get('/api/interests').then((response) => {
            this.interests = response.data
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
        },
        fetchCountries() {
          axios.get('/api/countries').then((response) => {
            this.countries = response.data
          })
        },
        loadUserForm() {
          this.$auth.fetch().then(response => {
            this.user = response.data
            let creative_data = this.user.account.creative_data
            if (creative_data.links !== null)
              this.form.first_name = creative_data.first_name

            if (creative_data.links !== null)
              this.form.last_name = creative_data.last_name

            if (creative_data.gender !== null)
              this.form.gender = creative_data.gender
              if (this.form.gender === 0) {
                this.form.gender = 'Male'
              } else {
                this.form.gender = 'Female'
              }

            if (creative_data.age !== null)
              this.form.age = creative_data.age

            if (creative_data.studies_where !== null)
              this.form.studies_where = creative_data.studies_where

            if (creative_data.studies !== null)
              this.form.studies = creative_data.studies

            if (creative_data.description !== null)
              this.form.description = creative_data.description

            if (creative_data.nationality !== null)
              this.form.nationality = creative_data.nationality

            if (creative_data.country !== null)
              this.form.country = creative_data.country

            if (creative_data.mercadopago_account !== null)
              this.form.mercadopago_account = creative_data.mercadopago_account

            if (creative_data.links !== null)
              this.form.links = creative_data.links

              if (creative_data.interests !== null)
                  this.form.interests = creative_data.interests.map(interest => {
                      return {
                          id: interest.id,
                          name: interest.name,
                          created_at: interest.created_at,
                          updated_at: interest.updated_at
                      }
                  })

            if (creative_data.skills !== null)
              this.form.skills = creative_data.skills.map(skill => {
                return {
                  id: skill.id,
                  level: skill.pivot.level,
                  name: skill.name
                }
              })

            this.fetchSkills()
          })
        },
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
