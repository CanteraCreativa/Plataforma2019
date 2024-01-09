<template>
  <router-link :to="{name: 'profile_view', params: {id: creative_id}}" class="h-100" v-if="creative">
    <div class="card card-box-shadow h-100" >
      <img :src="creative.profile_image" class="card-img-top" alt="...">
      <div class="card-body h-100">
        <h5 class="card-title pink-color">{{creative.first_name}} {{creative.last_name}}</h5>
        <p class="card-text text-dark">{{creative.description}}</p>
      </div>
      <div class="card-footer text-size-10 text-dark">
        {{creative.email}}
      </div>
    </div>
  </router-link>
</template>

<script>
export default {
  props: {
    creative_id: {
      type: Number,
      required: true
    },
  },
  data: () => {
    return {
      creative: null
    }
  },
  created() {
    this.fetchCreative()
  },
  methods: {
    fetchCreative() {
      axios.get('/api/creatives/' + this.creative_id).then((response) => {
        this.creative = response.data.data
      })
    },
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
</style>
