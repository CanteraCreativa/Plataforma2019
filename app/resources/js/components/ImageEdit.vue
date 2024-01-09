<template>
  <div>
      <div v-if="show_edit">
          <label for="upload">
            <v-hover class="mx-auto border border-white" v-slot:default="{ hover }">
                <v-img :src="url" alt="" class="image--cover mx-auto my-auto rounded-circle img-fluid">
                  <v-scale-transition>
                    <div v-if="hover" class="d-flex v-card--reveal px-2 py-1 w-100">
                      <i class="fa fa-edit"></i>
                    </div>
                  </v-scale-transition>
                  <!-- por alguna razon no anda muy bien el v-expand-transition -->
                </v-img>
            </v-hover>
            <input type="file" @change="updateImage" id="upload" style="display:none">
          </label>
      </div>
      <div v-else>
          <img :src="url" alt="" class="image--cover mx-auto my-auto rounded-circle img-fluid">
      </div>
  </div>
</template>

<script>
export default {

  components: {
  },
  props: {
    img_url: {
      type: String,
      required: true
    },
    show_edit: {
      type: Boolean,
      required: true
    },
  },
  computed: {
    // a computed getter
    url: function () {
      // `this` points to the vm instance
      if (this.img_url)
        return this.img_url
      else
        return "https://upload.wikimedia.org/wikipedia/commons/2/24/Missing_avatar.svg"
    }
  },
  methods: {
    updateImage(imageEvent) {
      var newImage = imageEvent.target.files[0]
      let formData = new FormData()
      if (newImage) {
        formData.append('profile_image', newImage)
        let headers = {
          headers: {
              "Content-Type": "multipart/form-data"
          }
        }
        axios.post('/api/profile-image', formData, headers)
        .then((response) => {
          this.$toasted.show('Imagen de perfil actualizada con éxito')
          this.$nextTick(() => {
            this.$emit('actualizar')
          })
        })
        .catch(err => {
          this.$emitirToastError(err)
        })
      }
    }
  }
}
</script>


<style>
.v-responsive__sizer {
    display: none;
}

.image--cover {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  margin: 10px;
  object-fit: cover;
  object-position: center right;
}

.v-card--reveal {
  align-items: center;
  opacity: .8;
  position: absolute;
  height: 100%;
  color: white;
  background-color: black;
  font-size: 20px;
  justify-content: center;
  cursor: pointer;
  border-radius: 100%;
}

</style>
