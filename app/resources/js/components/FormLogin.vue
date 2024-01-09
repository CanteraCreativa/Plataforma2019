<template>
    <div class="text-left">
        <div class="login-form-container m-auto">
            <div class="row">
                <div class="col">
                    <label for="validationServerUsername">Correo electrónico</label>
                    <div class="input-group">
                        <input type="text" v-model="form.email" :disabled="cargando"
                               class="form-control" placeholder="" aria-describedby="inputGroupPrepend3" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label >Contraseña</label>
                    <input type="password" v-on:keyup.enter="login" v-model="form.password" :disabled="cargando" class="form-control" placeholder="" required>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p><a class="olvide small" @click="reset_pass" >Olvidé mi contraseña</a></p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button @click="login" v-if="!cargando" :disabled="$v.form.$invalid " class="btn btn-cantera2 btn-block" type="submit">Iniciar sesión</button>
                    <button disabled v-else class="btn btn-light btn-block">Ingresando</button>
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
        <div class="login-form-container m-auto">
            <hr class="pink-bg">
        </div>
        <div class="m-auto">
            <div class="row text-center">
                <div class="col">
                    <h3>¿Todavía no creaste tu cuenta?</h3>
                </div>
            </div>
        </div>
        <div class="login-form-container m-auto">
            <div class="row text-center">
                <div class="col">
                    <router-link to="/profile_edit/">
                        <a class="btn btn-default pink-color btn-cantera  w-100 border border-pink">Registrate ahora</a>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import { required, email } from 'vuelidate/lib/validators'

    export default {
        data: () => ({
            cargando: false,
            form: {
                password: '',
                email: '',
            }
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
            //console.log(this.$auth);
        },
        mounted () {
        },
        methods: {
            login () {
                this.cargando = true
                this.form.email = this.form.email.toLowerCase()
                this.$auth.login({
                    data: this.form,
                    rememberMe: true,
                    success (res) {
                        this.$toasted.show('Sesión iniciada con éxito')
                        this.cargando = false
                        this.$nextTick(() => {
                            if ( !this.$auth.user().account.creative_data.is_profile_complete ) {
                                this.$router.push({name: "complete_profile"})
                            } else {
                                this.$router.push({name: 'profile_view', params: {id: this.$auth.user().account.creative_data.id}})
                            }
                        })
                    },
                    error (err) {
                        this.$emitirToastError(err)
                        window.localStorage.removeItem('cantera_creativa_session')
                        this.cargando = false
                    }
                })
            },
            reset_pass () {
                if (!this.form.email) {
                    this.$emitirToastError("Ingrese su Email")
                }
                else {
                    this.form.email = this.form.email.toLowerCase()
                    axios.post('/api/password/create', this.form)
                        .then((response) => {
                            this.$toasted.show('Correo para recuperar contraseña enviado con éxito')
                            this.cargando = false
                        })
                        .catch((err) => {
                            this.$emitirToastError(err)
                            this.cargando = false
                        })
                }
            }
        }
    }
</script>


<style lang="css" scoped>
    .olvide {
        cursor: pointer;
    }
    .olvide:hover {
        color: #f95568 !important;
    }

    .form-login {
        width: 100%;
        max-width: 500px;
    }

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
