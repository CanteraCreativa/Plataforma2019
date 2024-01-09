<template>
    <div class="container-fluid p-0">
        <div class="px-4 pt-3">
            <div class="row">
                <div class="col-12">
                    <div class="w-100 text-center">
                        <image-edit @actualizar="$emit('actualizar')" :show_edit="(!!($auth.user().account) && ($auth.user().account.creative_data.id === creative.id))" :img_url="creative.profile_image"/>
                        <h3 class="pink-color mb-0 text-truncated font-batman">{{creative.first_name}} {{creative.last_name}}</h3>
                        <p class="text-dark lead m-1">{{$auth.user().email}}</p>
                    </div>
                    <p class="text-dark text-center mx-2 my-4">
                      {{creative.description}}
                    </p>
                </div>

                <div class="col-12 text-center">
                    <a class="btn pink-color" @click="$router.push({ name: 'profile_edit'})">
                        <strong class="pink-color">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar perfil
                        </strong>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ImageEdit from '../components/ImageEdit'

export default {
  components: {
    ImageEdit
  },
  props: {
    creative: {
      type: Object
    },
    ver_entregas: {
      type: Boolean
    }
  },
  data: () => ({
  }),
  methods: {
  }
}
</script>


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

.ratings {
  margin-left: 10px
}



</style>
