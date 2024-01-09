<template>
    <div class="text-dark row mb-2 justify-content-md-center">
        <div class="col-md-10 col-lg-8 p-5">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="pink-color text-center">Hola</h1>
                    <p class="pink-color text-center">{{$auth.user().email}}</p>
                </div>
                <div class="col-md-12">
                    <div class="form-row" v-if="!user_verified">
                        <div class="alert alert-secondary w-100" role="alert">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <p class="pink-color">Aún no validaste tu cuenta de correo electrónico. Hasta entonces, no vas a poder participar de ninguna convocatoria.</p>
                                    <p><a class="btn-sm btn btn-cantera2" @click="resend_mail">Reenviar confirmación</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h1 class="pink-color text-center">Información de perfil</h1>
                    <p class="text-center">Los campos marcados con <span class="text-danger">*</span> son obligatorios</p>
                </div>
                <div class="col-md-12">
                    <form-complete-profile />
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import FormCompleteProfile from '../components/FormCompleteProfile'

    export default {
        components: {
            FormCompleteProfile
        },
        data: () => ({
            user_verified: true,
        }),
        methods: {
            resend_mail () {
                axios.post('/api/email/resend', {})
                    .then((response) => {
                        this.$toasted.show('Correo de validación enviado con éxito')
                    })
            }
        },
        beforeMount() {
            let that = this;
            if(!that.$auth.check()) {
                that.$router.push('/login/')
            } else {
                axios.get('/api/is_verified')
                    .then((response) => {
                        that.user_verified = response.data;
                    })
                    .catch((failure) => {
                        this.cargando = false
                        this.$emitirToastError(failure)
                    })
            }
        }
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
