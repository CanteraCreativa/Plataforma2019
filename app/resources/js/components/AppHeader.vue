<template>
      <!-- <div class="inner">
        <span class="nav-link">Cantera creativa</span>
        <nav class="nav nav-masthead justify-content-center">
          <router-link class="nav-link" exact-active-class="active" :to="{name: 'landing'}">Home</router-link>
          <router-link class="nav-link" exact-active-class="active" :to="{name: 'brands'}">Marcas</router-link>
          <router-link class="nav-link" exact-active-class="active" :to="{name: 'creators'}">Creadores</router-link>
          <router-link class="nav-link" exact-active-class="active" :to="{name: 'contests'}">Concursos</router-link>
          <router-link class="nav-link is-primary" exact-active-class="active" :to="{name: 'profile_edit'}">Nueva Cuenta</router-link>
        </nav>
      </div> -->
      <div class="inner">
        <nav class="navbar navbar-toggleable-md navbar-expand-lg navbar-light" id="commRollover">
            <router-link class="navbar-brand d-md-inline" :to="{name: 'landing'}">
              <!-- <img src="img/logo.png" alt="Logo"  > -->
              <img src="~/../../images/CC-Icons-00.svg" class="logo-header"><span class="logo font-batman-bold">Cantera <span class="border-pink">creativa</span></span>
            </router-link>
           <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
           </button>
            <div class="collapse nav-masthead navbar-collapse justify-content-end" id="navbarNav">
              <router-link class="nav-link px-2 ml-0" exact-active-class="active" :to="{name: 'brands'}" data-toggle="collapse" data-target="#navbarNav">Soy marca</router-link>
              <router-link class="nav-link px-2 ml-0" exact-active-class="active" :to="{name: 'creators'}" data-toggle="collapse" data-target="#navbarNav">Soy creativo</router-link>
              <router-link class="nav-link px-2 ml-0" exact-active-class="active" :to="{name: 'contests'}" data-toggle="collapse" data-target="#navbarNav">Convocatorias</router-link>

                <!-- Desktop -->
              <router-link v-if="!$auth.check()" class="nav-link px-2 ml-0 d-none d-md-block" exact-active-class="active" :to="{name: 'login'}" data-toggle="collapse" data-target="#navbarNav">Iniciar sesión</router-link>
              <router-link v-else class="nav-link px-2 ml-0 bg-grey d-none d-md-block" exact-active-class="active" :replace="true" :to="{name: 'profile_view', params: {id: $auth.user().account.creative_data.id}}" data-toggle="collapse" data-target="#navbarNav">
                  <a>
                      <img class="image--cover mx-auto my-auto rounded-circle img-fluid menu-profile-image" :src="$auth.user().account.creative_data.profile_image" v-if="$auth.user().account.creative_data.profile_image !== null && $auth.user().account.creative_data.profile_image !== undefined" />
                      <img class="image--cover mx-auto my-auto rounded-circle img-fluid menu-profile-image" src="https://upload.wikimedia.org/wikipedia/commons/2/24/Missing_avatar.svg" v-else />
                      <span v-if="$auth.user().account.creative_data.first_name !== null && $auth.user().account.creative_data.first_name !== undefined">{{ $auth.user().account.creative_data.first_name.split(' ')[0] }}</span>
                      <span v-else>Mi perfil</span>
                  </a>
              </router-link>

                <!-- Mobile -->
                <hr class="d-xs-block d-md-none menu-separator my-4">
                <router-link v-if="!$auth.check()" class="nav-link px-2 ml-0 d-xs-block d-md-none " exact-active-class="active" :to="{name: 'login'}" data-toggle="collapse" data-target="#navbarNav">Iniciar sesión</router-link>
                <router-link v-else class="nav-link px-2 ml-0 bg-grey d-xs-block d-md-none " exact-active-class="active" :replace="true" :to="{name: 'profile_view', params: {id: $auth.user().account.creative_data.id}}" data-toggle="collapse" data-target="#navbarNav">
                    <a>
                        <div v-if="$auth.check()">
                            <img class="image--cover mx-auto my-auto rounded-circle img-fluid menu-profile-image" :src="$auth.user().account.creative_data.profile_image" v-if="$auth.user().account.creative_data.profile_image !== null && $auth.user().account.creative_data.profile_image !== undefined" />
                            <img class="image--cover mx-auto my-auto rounded-circle img-fluid menu-profile-image" src="https://upload.wikimedia.org/wikipedia/commons/2/24/Missing_avatar.svg" v-else />
                        </div>
                        <img class="image--cover mx-auto my-auto rounded-circle img-fluid menu-profile-image" src="https://upload.wikimedia.org/wikipedia/commons/2/24/Missing_avatar.svg" v-else />
                        <div v-if="$auth.check()">
                            <span v-if="$auth.user().account.creative_data.first_name !== null && $auth.user().account.creative_data.first_name !== undefined">{{ $auth.user().account.creative_data.first_name }}</span>
                            <span v-else>Mi perfil</span>
                        </div>
                        <span v-else>Mi perfil</span>
                    </a>
                </router-link>
                <router-link v-if="$auth.check()" class="nav-link px-2 ml-0 d-xs-block d-md-none " exact-active-class="active" :to="{name: 'profile_edit'}" data-toggle="collapse" data-target="#navbarNav">Editar perfil</router-link>

              <router-link v-if="!$auth.check()" class="nav-link px-2 ml-0 btn btn-cantera2" exact-active-class="active" :to="{name: 'profile_edit'}" data-toggle="collapse" data-target="#navbarNav">Creá tu cuenta</router-link>
              <a href="#" v-else class="nav-link px-2 ml-0" @click="$auth.logout()" data-toggle="collapse" data-target="#navbarNav">Cerrar sesión</a>
            </div>
        </nav>
      </div>
</template>


<script>
export default {
    methods: {
        displayName() {
            var that = this

            that.$auth.fetch()

            return (that.$auth.user().account.creative_data.first_name != undefined &
                that.$auth.user().account.creative_data.first_name != null &
                that.$auth.user().account.creative_data.first_name != '' &
                that.$auth.user().account.creative_data.last_name != undefined &
                that.$auth.user().account.creative_data.last_name != null &
                that.$auth.user().account.creative_data.last_name != '')
        }
    }
}
</script>


<style lang="css" scoped>

/*
 * Header
 */

.masthead-brand {
  margin-bottom: 0;
}

.navbar-brand {
    max-width: 50%;
    font-size: 1rem!important;
}
.navbar-toggler {
    border: 0!important
}
.menu-profile-image {
    width: 25px;
    height: 25px;
}

.logo {
  color: black;
  background-color: transparent;
}
.border-pink {
  border-bottom: .25rem solid transparent;
  border-bottom-color: #f95568;
  padding: .25rem 0;
}

.menu-separator {
    background: #f95568;
}

.color-pink {
  color: #f95568;
}

.nav-masthead .nav-link {
  padding: .25rem 0;
  color: black;
  border: 1px solid #ffffff;
}

.router-link-active {
  color: #f95568;
  cursor: pointer;
  border-radius: .5rem;
}

.nav-masthead .nav-link:hover,
.nav-masthead .nav-link:focus {
    border: 1px solid #f95568;
    border-radius: .5rem;
}

.nav-masthead .nav-link + .nav-link {
  margin-left: 1rem;
}


@media (min-width: 48em) {
  .masthead-brand {
    float: left;
  }
  .nav-masthead {
    float: right;
  }
}
@media (max-width: 480px) {
    #navbarNav {
        padding-left: 15px;
    }
    .nav-link {
        margin-top: 10px;
    }
}
.logo-header {
  max-height: 20px;
  max-width: 20px;
  padding-bottom: 5px;
}

</style>
