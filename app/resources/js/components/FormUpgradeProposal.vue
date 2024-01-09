<template>
  <div>
    <div class="form-row">
      <div class="col-12">
        <label for="inlineFormCustomSelect">
            <strong>1 - Título de tu Idea <span class="text-danger">*</span></strong>
        </label>
        <input type="text" v-model="form.name" maxlength="50"
          @input="$v.form.name.$touch()"
          :class="{'is-invalid': $v.form.name.$error}"
          class="form-control p-2" id="inlineFormCustomSelect" placeholder="" required>
          <p class="small text-right text-muted"><strong>{{ form.name.length }}/50 caracteres</strong></p>

      </div>
        <div class="col-12">
            <label for="exampleFormControlTextarea1">
                <strong>2 - Descripción de tu idea <span class="text-danger">*</span></strong><br>
                <div v-if="false">
                Desarrollá tu idea en forma clara y concisa. En caso de necesitarlo, podés incluir el link a un video que termine de explicar tu idea (máx 30 segs).
                Recordá no incluir información personal que permita identificarte (como tu nombre o apellido).
                </div>
            </label>
            <textarea class="form-control"
              placeholder="Desarrollá tu idea en forma clara y concisa. En caso de necesitarlo, podés incluir el link a un video que termine de explicar tu idea (máx 30 segs).
Recordá no incluir información personal que permita identificarte (como tu nombre o apellido)."
              :maxlength="descriptionMaxLength"
              @input="$v.form.description.$touch()"
              :class="{'is-invalid': $v.form.description.$error}"
              v-model="form.description" id="exampleFormControlTextarea1" rows="7"></textarea>
            <p class="small text-right text-muted"><strong>{{ form.description.length }}/2000 caracteres</strong></p>
        </div>

        <div class="col-12">
            <label for="archivo">
                <strong>3 - Imagen de referencia <span class="text-danger">*</span></strong>
            </label><br>
            <span>Mejorá la comunicación de tu idea subiendo una imagen que ayude a ilustrarla.</span>
            <input type="file" @change="form.image_file = $event.target.files[0]" accept="image/jpg, image/jpeg, image/png"
                   class="form-control p-0 h-auto" id="archivo" placeholder="" required>
            <p class="small text-right text-muted"><strong>Solo se permite subir archivos JPG o PNG con un peso máximo 10 MB.</strong></p>

        </div>

      <div class="text-center col-md-12" v-if="false">

          <button v-if="!cargando" @click="$emit('atras')" class="btn btn-light">Volver</button>

          <button v-if="!cargando" @click="submit" :disabled="$v.form.$invalid" class="btn btn-cantera2" type="submit">Aceptar</button>
          <button v-else disabled class="btn btn-cantera2" type="submit">Enviando</button>

      </div>



    </div>
  </div>
</template>


<script>
    import { required, email } from 'vuelidate/lib/validators'

    export default {
      data: () => ({
        cargando: false,
        autoriaSelected: null,

        descriptionMaxLength: 2000,

        autoria_options: [
          {
            id: 1,
            label: "Sí y puedo indicarlos abajo"
          },
          {
            id: 2,
            label: "No, y certifico que soy el autor de todos los elementos incorporados en la pieza a presentar"
          },
          {
            id: 3,
            label: "Mi pieza contiene figuras humanas (niños o adultos) y tengo el consentimiento escrito de las personas (o puede obtenerlo en caso de ser necesario)"
          }
        ],
        form: {
          name: '',
          description: '',
          answer_question_1: '',
          answer_question_2: '',
          answer_question_3: '',
          autoria: '',
          autoria_aclaracion: '',
          image_file: null,
          skills: [],
        },
        skills: [

        ],
      }),
      props: {
          submitting: Boolean
      },
      validations: {
        form: {
          name: {
            required,
          },
          description: {
            required,
          },
          image_file: {
            required,
          }
        }
      },
      created () {
        this.fetchSkills()
      },
      mounted () {
          let that = this
          that.$v.$touch();
      },
      watch: {
          submitting: function(val) {
              if(val) {
                  this.submit()
              }
          }
      },
      methods: {
        fetchSkills() {
          axios.get('/api/skills').then((response) => {
            this.skills = response.data
          })
        },
        submit() {
          this.cargando = true
          let formdata = Object.assign({}, this.form)
          let contest_id =  this.$route.params.id
          delete formdata.skills
          let formData = new FormData()
          for (let key in formdata) {
            formData.append(key, formdata[key]);
          }
          for (let key in this.form.skills) {
            formData.append('skills[' + key + ']', this.form.skills[key].id)
          }
          let headers = {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          }
          axios.post('/api/submissions/' + contest_id, formData, headers)
          .then((response) => {
            this.cargando = false
            this.form = {
              name: '',
              description: '',
              answer_question_1: '',
              answer_question_2: '',
              answer_question_3: '',
              autoria: '',
              autoria_aclaracion: '',
              image_file: null,
            }
            this.$toasted.show('Idea subida con éxito')
            this.$nextTick(() => {
              this.$router.push('/profile/'+this.$auth.user().account.creative_data.id)
            })
          })
          .catch(err => {
            this.cargando = false
              this.$emit('error')
            this.$emitirToastError(err)
          })
        }
      }
    }
</script>


<style lang="css" scoped>
.btn {
    width: 150px!important;
}

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
