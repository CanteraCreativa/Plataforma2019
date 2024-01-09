<template>
  <div class="card custom-shadow h-100" >
    <img :src="submission.image_file" class="card-img-top" alt="...">
    <div class="card-body h-100">
      <h5 class="card-title pink-color">{{submission.name}}</h5>
      <p class="card-text text-dark">{{submission.description}}</p>
    </div>
    <div class="card-footer text-size-10 text-dark">
      <router-link :to="{name: 'contest_view', params: {id: submission.announcement.id}}" class="h-100">
        <span class="fa fa-external-link"/>
        {{submission.announcement.title}}
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  components: {
  },
  props: {
    submission: {
      type: Object,
      required: true
    },
  },
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
.custom-shadow {
    box-shadow: 0px 5px 5px 0px rgba(0, 0, 0, 0.3)
}

</style>
