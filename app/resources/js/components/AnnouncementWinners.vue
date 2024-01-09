<template>
    <div class="row">
      <template v-if="showWinners">
        <div class="col-6 col-md-4" v-for="creative_id in creative_ids">
          <card-user-simple :creative_id="creative_id"/>
        </div>
      </template>
      <div v-else class="col-12 text-center">
        Los resultados de la convocatoria serán publicados el {{ results_date | formatDate }}
      </div>
    </div>
</template>


<script>
  import CardUserSimple from '../components/CardUserSimple'

  export default {
    components: {
      CardUserSimple,
    },
    props: {
      creative_ids: {
        type: Array
      },
      results_date: {
        type: String,
        required: true
      }
    },
    data: () => ({ }),
    created () { },
    methods: { },
    computed: {
      showWinners() {
        return this.$days_remaining(this.results_date) <= 0
      }
    }
  }
</script>


<style lang="css" scoped>
</style>
