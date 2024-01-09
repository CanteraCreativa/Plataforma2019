<template>
    <div class="text-left">
        <div class="spinner-border text-danger" role="status" v-if="loading_page">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="container-fluid p-0" v-else>
            <div class="form-row">
                <div class="col-md-6 col-12">
                    <label for="validationServer03">Correo Electrónico</label>
                    <input disabled type="text" :value="$auth.user().name"
                           class="form-control" id="validationServer03" placeholder="">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 col-12">
                    <label for="validationServer01" class="required">Nombres<span class="text-danger">*</span></label>
                    <input :disabled="cargando" type="text" v-model="form.first_name"
                           @input="$v.form.first_name.$touch()"
                           :class="{'is-invalid': $v.form.first_name.$error}"
                           class="form-control" id="validationServer01" placeholder="" required>
                    <small v-if="$v.form.first_name.$error" class="alert-danger">El campo es obligatorio</small>
                </div>
                <div class="col-md-6 col-12">
                    <label for="validationServer02" class="required">Apellidos<span class="text-danger">*</span></label>
                    <input :disabled="cargando" type="text" v-model="form.last_name"
                           @input="$v.form.last_name.$touch()"
                           :class="{'is-invalid': $v.form.last_name.$error}"
                           class="form-control" id="validationServer02" placeholder="" required>
                    <small v-if="$v.form.last_name.$error" class="alert-danger">El campo es obligatorio</small>

                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 col-12">
                    <label for="birthDate" class="required">Fecha de nacimiento<span class="text-danger">*</span></label>
                    <date-picker
                        :disabled="cargando"
                        v-model="form.birth_date"
                        value-type="format"
                        format="DD-MM-YYYY"
                        title-format="DD-MM-YYYY"
                        time-title-format="DD-MM-YYYY"
                        placeholder="dd-mm-aaaa"
                        :disabled-date="disabledDates"
                        @input="$v.form.birth_date.$touch()"
                        :class="{'is-invalid': $v.form.birth_date.$error}"
                        class="w-100 form-control border-0 p-0" id="birthDate" required></date-picker>
                    <small v-if="$v.form.birth_date.$error" class="alert-danger">El campo es obligatorio</small>
                </div>

                <div class="col-md-6 col-12">
                    <label for="selectSexo" class="required">Género<span class="text-danger">*</span></label>
                    <select :disabled="cargando" class="custom-select mr-sm-2" id="selectSexo" v-model="form.gender"
                            @change="$v.form.gender.$touch()"
                            :class="{'is-invalid': $v.form.gender.$error}"
                    >
                        <option selected value="">Seleccione</option>
                        <option value="Male">Masculino</option>
                        <option value="Female">Femenino</option>
                        <option value="Other">Otro</option>
                        <option value="PreferNotToSay">Prefiero no decirlo</option>
                    </select>
                    <small v-if="$v.form.gender.$error" class="alert-danger">El campo es obligatorio</small>
                </div>

            </div>

            <div class="form-row">
                <div class="col-md-6 col-12">
                    <label for="selectPaises" class="required">País de residencia<span class="text-danger">*</span></label>
                    <select :disabled="cargando" class="custom-select mr-sm-2" id="selectPaises" v-model="form.country"
                            @change="$v.form.country.$touch()"
                            :class="{'is-invalid': $v.form.country.$error}"
                    >
                        <option selected value="">Seleccione</option>
                        <option v-for="country in countries" :value="country" :key="country">{{ country }}</option>
                    </select>
                    <small v-if="$v.form.country.$error" class="alert-danger">El campo es obligatorio</small>

                </div>
                <div class="col-md-6 col-12">
                    <label for="selectNacionalidad"><strong>Nacionalidad</strong></label>
                    <select :disabled="cargando" class="custom-select mr-sm-2" id="selectNacionalidad" v-model="form.nationality"
                            @change="$v.form.nationality.$touch()"
                    >
                        <option selected value="">Seleccione</option>
                        <option v-for="country in countries" :value="country" :key="country">{{ country }}</option>
                    </select>
                </div>
            </div>

            <div v-if="$auth.user().account.creative_data.is_profile_complete" class="form-row">
                <div class="col-12">
                    <label for="selectStudyLevel" class="required">Nivel de estudios</label>
                    <select :disabled="cargando" class="custom-select mr-sm-2" id="selectStudyLevel" v-model="form.study_level_id">
                        <option selected value="">Seleccione</option>
                        <option v-for="level in studyLevels" :value="level.id" :key="level.id">{{ level.name }}</option>
                    </select>
                </div>

                <div class="col-md-6 col-12">
                    <label for="selectCareerId" class="required">Campo de estudio primario</label>
                    <select :disabled="cargando" class="custom-select mr-sm-2" id="selectCareerId" v-model="form.career_id">
                        <option selected value="">Seleccione</option>
                        <option v-for="career in careers" :value="career.id" :key="career.id">{{ career.name }}</option>
                    </select>
                </div>

                <div class="col-md-6 col-12">
                    <label for="selectSecondaryCareerId" class="required">Campo de estudio secundario</label>
                    <select :disabled="cargando" class="custom-select mr-sm-2" id="selectSecondaryCareerId" v-model="form.secondary_career_id">
                        <option selected value="">Seleccione</option>
                        <option v-for="career in careers" :value="career.id" :key="career.id">{{ career.name }}</option>
                    </select>
                </div>

            </div>

            <div v-if="$auth.user().account.creative_data.is_profile_complete">
                <div class="form-row">
                    <div class="col-12">
                        <label for="idPresentacion"><strong>Texto de presentación</strong></label>
                        <textarea maxlength="400" :disabled="cargando" class="form-control"
                              @input="$v.form.description.$touch()"
                              placeholder="Contanos un poco de vos, a qué te dedicás y qué tipo de proyectos te interesan"
                              v-model="form.description" id="idPresentacion" rows="3"></textarea>
                        <p class="small text-right text-muted"><strong>{{ form.description.length }}/400 caracteres</strong></p>

                    </div>
                </div>

                <div class="form-row">
                    <div class="col-12">
                        <p for="selectinterests">
                            <strong>Intereses</strong><br>
                            <span>Marcá todos aquellos que te interesen</span>
                        </p>
                        <div class="interests-list">
                            <label class="w-100" v-for="interest in interests" :key="interest.id">
                                <input
                                    type="checkbox"
                                    :value="interest"
                                    v-model="form.interests"
                                > {{ interest.name }}
                            </label><br>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-12">
                    <div id="id_grecaptcha" class="g-recaptcha" data-callback="callbackRecaptcha" data-sitekey="6LfvhMYUAAAAAM18SPpyA1TD-LOCrpgUHHMzF8Yg"></div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 text-right">
                    <a class="btn float-right btn-light" @click="$router.push({ name: 'profile_view', params: { id: $auth.user().account.creative_data.id }})">Volver</a>
                </div>
                <div class="col-md-6 text-left">
                    <button v-if="!cargando" :disabled="!captcha || $v.form.$invalid" @click="submit()" class="btn btn-cantera2" type="submit">Guardar</button>
                    <button v-else disabled class="btn btn-cantera2" type="submit">Guardando</button>
                </div>
                <div class="col-12">
                    <p v-if="$v.form.$invalid" class="text-center">Asegurate de completar los campos obligatorios para poder finalizar el registro</p>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import { required } from 'vuelidate/lib/validators'
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';

    const moment= require('moment')

    export default {
        components: { DatePicker },
        data: () => ({
            loading_page: true,
            interests: [],
            user: null,
            cargando: false,
            countries: [],
            careers: [],
            studyLevels: [],
            captcha: false,
            form: {
                first_name: '',
                last_name: '',
                gender: '',
                birth_date: '',
                nationality: '',
                country: '',
                description: '',
                interests: [],
                career_id: '',
                secondary_career_id: '',
                study_level_id: '',
            },
            momentFormat: {
                // Date to String
                stringify: (date) => {
                    return date ? moment(date).format('DD-MM-YYYY') : ''
                },
                // String to Date
                parse: (value) => {
                    return value ? moment(value).format('DD-MM-YYYY') : null
                }
            },
        }),
        validations: {
            form: {
                first_name: {
                    required,
                },
                last_name: {
                    required,
                },
                birth_date: {
                    required,
                },
                gender: {
                    required,
                },
                country: {
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
            await this.fetchCareers()
            await this.fetchStudyLevels()
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
        },
        methods: {
            disabledDates(date) {
                var compareDate = moment(date);
                var startDate   = moment("31/12/1899", "DD/MM/YYYY");
                var endDate     = moment("01/01/2003", "DD/MM/YYYY");

                return !compareDate.isBetween(startDate, endDate);
            },
            submit() {
                let that = this
                that.cargando = true;
                let formdata = Object.assign({}, this.form)
                let creative_id =  this.$auth.user().account.creative_data.id
                formdata.interests = formdata.interests.map(interest => interest.id)
                axios.put('/api/creatives/' + creative_id, formdata)
                    .then((response) => {
                        this.$toasted.show('Perfil editado con éxito')
                        this.$auth.fetch()
                        this.$router.push({ name: 'profile_view', params: { id: creative_id} })
                    })
                    .catch(err => {
                        this.$emitirToastError(err)
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
            fetchInterests() {
                axios.get('/api/interests').then((response) => {
                    this.interests = response.data
                })
            },
            fetchCareers() {
                axios.get('/api/careers').then((response) => {
                    this.careers = response.data
                })
            },
            fetchStudyLevels() {
                axios.get('/api/study_levels').then((response) => {
                    this.studyLevels = response.data
                })
            },
            loadUserForm() {
                this.$auth.fetch().then(response => {
                    this.user = response.data
                    let creative_data = this.user.account.creative_data
                    if (creative_data.first_name !== null)
                        this.form.first_name = creative_data.first_name

                    if (creative_data.last_name !== null)
                        this.form.last_name = creative_data.last_name

                    if (creative_data.gender !== null)
                        this.form.gender = creative_data.gender
                    if (this.form.gender === 0) {
                        this.form.gender = 'Male'
                    }
                    if (this.form.gender === 1) {
                        this.form.gender = 'Female'
                    }
                    if (this.form.gender === 2) {
                        this.form.gender = 'Other'
                    }
                    if (this.form.gender === 3) {
                        this.form.gender = 'PreferNotToSay'
                    }


                    if (creative_data.birth_date !== null)
                        this.form.birth_date = moment(creative_data.birth_date).format('DD-MM-YYYY')

                    if (creative_data.nationality !== null)
                        this.form.nationality = creative_data.nationality

                    if (creative_data.country !== null)
                        this.form.country = creative_data.country

                    if (creative_data.description !== null)
                        this.form.description = creative_data.description

                    if (creative_data.career_id !== null)
                        this.form.career_id = creative_data.career_id

                    if (creative_data.secondary_career_id !== null)
                        this.form.secondary_career_id = creative_data.secondary_career_id

                    if (creative_data.study_level_id !== null)
                        this.form.study_level_id = creative_data.study_level_id

                    if (creative_data.interests !== null)
                        this.form.interests = creative_data.interests.map(interest => {
                            return {
                                id: interest.id,
                                name: interest.name,
                                created_at: interest.created_at,
                                updated_at: interest.updated_at
                            }
                        })

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

    .mx-input {
        height: 38px;
    }

    @media (min-width: 48em) {
        .masthead-brand {
            float: left;
        }
        .nav-masthead {
            float: right;
        }

        .interests-list {
            columns: 2;
        }
    }

</style>
