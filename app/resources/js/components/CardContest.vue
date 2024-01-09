<template>
  <router-link :to="{name: 'contest_view', params: {id: contest.id}}" class="h-100">
    <div class="card pink-bg custom-shadow border-0 h-100">
       <div class="card-img-top relative">
           <v-hover class="mx-auto" v-slot:default="{ hover }">
               <v-img class="altura-harcoded" :class="{'grayscale': $days_remaining(contest.end_date) < 0}" :src="contest.image_thumbnail">
                 <v-scale-transition>
                   <div v-if="hover" class="d-flex v-card-reveal px-2 py-1">

                       <span class="btn btn-cantera2 text-white font-batman-bold"> Participá</span>

                   </div>
                 </v-scale-transition>
                 <!-- por alguna razon no anda muy bien el v-expand-transition -->
               </v-img>
           </v-hover>
       </div>



       <div class="card-body text-center p-2 d-flex flex-column justify-content-between">
         <div class="flex-1">
             <p class="font-batman-bold">
               {{contest.title}}
             </p>
              <p class="card-text text-white text-size-10">{{contest.short_description | string_limit(255)}}</p>
              <!-- <span class="badge m-1 badge-info badge-pill tags" v-for="tag in contest.tags">{{tag.name}}</span> -->
          </div>
          <div>
            <hr class="white mb-1">
            <span class="font-batman-bold"> Total en Premios</span><br>
              <span class="text-uppercase big-font">{{contest.total_prize | show_prize}} </span>
          </div>
       </div>
       <!-- <div class="card-footer azure-bg text-left font_size08">
           <p class="mb-0" v-if="contest.days_remaining">
             Tienes {{contest.days_remaining}} Días para presentar tu creación
           </p>
           <p class="mb-0" v-else>
             Concurso terminado el {{contest.deadline}}
           </p>
       </div> -->
    </div>
  </router-link>
</template>

<script>
export default {
  components: {
  },
  props: {
    contest: {
      type: Object,
      required: true
    },
  },
  methods: {
  }
}
</script>


<style scoped>

.relative {
  position: relative;
}
.floating-title {
  font-size: 20px;
  margin-bottom: 0;
}
.grayscale {
  filter: grayscale(100%);
}
.font_size08 {
  font-size: 0.8rem;
}

.v-card-reveal {
  align-items: center;
  bottom: 0;
  left: 0;
  position: absolute;
  width: 100%;
  height: 100%;
  color: white;
  background-color: transparent;
  font-size: 20px;
  justify-content: center;
}

.big-font {
    font-size: 30px;
}

.altura-harcoded {
  height: 300px;
}
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
