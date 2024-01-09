<template>
    <div class="text-dark row mb-2 justify-content-md-center">
        <div class="col-md-10 col-lg-8 p-5">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="pink-color text-center font-batman-bold">Cambiar contraseña</h1>
                </div>
                <div class="col-md-12">

                    <div v-if="token_confirmed">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="validationServerUsername">Correo electrónico</label>
                                <div class="input-group">
                                    <input type="text" v-model="form.email" :disabled="cargando"
                                        class="form-control" placeholder="" aria-describedby="inputGroupPrepend3" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <label >Nueva contraseña</label>
                                <input type="password" v-model="form.password"class="form-control" placeholder="" required>
                            </div>
                            <div class="col-md-6">
                                <label >Repetí tu nueva contraseña</label>
                                <input type="password" v-model="form.password_confirmation" class="form-control" placeholder="" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-12 col-sm-3 m-auto">
                                <label >&nbsp</label>
                                <button @click="sendForm" v-if="!cargando" :disabled="$v.form.$invalid " class="btn btn-cantera2 btn-block" type="submit">Cambiar contraseña</button>
                                <button disabled v-else class="btn btn-light btn-block">Cargando</button>
                            </div>
                        </div>

                        <div class="text-red italic my-2 text-sm" v-html="errorMsg"></div>
                    </div>
                    <div v-else>
                        Hubo un problema con tu código de restauración ya que ha caducado; solicitá nuevamente un correo electrónico para cambiar tu contraseña.
                    </div>
                </div>
            </div>
        </div>
  </div>
</template>

<script>
    import { required, email } from 'vuelidate/lib/validators'

    export default {
        name: 'ResetPassword',
        data () {
            return {
                form: {
                  email: '',
                  password: '',
                  password_confirmation: ''
              },
              errorMsg: null,
              token_confirmed: undefined,
              token: null,
              cargando: false
            }
        },
        validations: {
            form: {
                email: {
                    required,
                    email
                },
                password: {
                    required,
                },
                password_confirmation: {
                    required,
                }
            }
        },
        mounted () {
            this.token = this.$route.query.token
            axios.get('/api/password/find/' + this.token).then((response)=>{
              this.token_confirmed = true
            }).catch((error) => {
              this.token_confirmed = false
            })
        },
        methods: {
            sendForm() {
                this.cargando = true;
                if (this.form.email && this.form.password && this.form.password_confirmation) {
                  this.form['token'] = this.token
                  axios.post('/api/password/reset', this.form).then((response)=>{
                      this.$toasted.show('Cambio de contraseña exitoso')
                      this.$router.push({name: "login"})
                      this.cargando = false
                  }).catch(error => {
                    this.$emitirToastError('Parece que hubo un error, verifique el email o que las contraseñas coincidan')
                      this.cargando = false
                  })
                } else {
                  this.$emitirToastError('Oops! Parece que hay campos sin completar.')
                    this.cargando = false;
                }
            }
        }
      }
</script>

<style lang="sass" scoped>
</style>
