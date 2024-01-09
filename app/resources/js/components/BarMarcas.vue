<template>
      <div class="inner gray-bg ">
        <ul class="nav justify-content-center">
          <li class="nav-item" v-for="(brand, i) in brands" :key="i">
              <a :href="brand.url" target="_blank">
                  <img :src="brand.filepath" :alt="brand.name" :title="brand.name" class="img-fluid force-height" >
              </a>
          </li>
        </ul>
      </div>
</template>


<script>
    export default{
        data: () => ({
            brands: []
        }),
        created() {
            axios.get('/api/logos').then((response) => {
                this.brands = response.data.logos;
            })
        }
    }
</script>


<style lang="css" scoped>
.gray-bg {
  background-color: #f6f6f6
}
.force-height {
  height: 100px;
  opacity: 0.4
}
</style>
