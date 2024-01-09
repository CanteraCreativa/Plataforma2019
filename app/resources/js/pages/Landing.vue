<template>
  <div id="banner" class="row background justify-content-md-center">
    <video id="backgroundVideo" autoplay loop muted playsinline>
        <source src="/videos/home-bg.mp4" >
    </video>
    <div class="col-md-8 p-4 p-md-0 col-lg-6 d-flex align-items-center">
      <div class="cover text-center w-100">
        <div class="row">
          <div class="col-12">
            <h1 class="cover-heading font-batman-bold big-font">Potenciá tu creatividad</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <p class="lead">
              <router-link class="font-batman-bold btn btn-lg btn-cantera2 m-3" :to="{name: 'brands'}">SOY MARCA</router-link>
              <router-link class="font-batman-bold btn btn-lg btn-cantera2 m-3" :to="{name: 'creators'}">SOY CREATIVO</router-link>
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-8 col-md-6 m-auto">
            <p>
                Somos una comunidad creativa que genera y desarrolla
                diversidad de ideas y soluciones innovadoras para marcas
                a través de una plataforma de colaboración y crowdsourcing
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>

</template>


<script>
    export default{
        mounted() {
            const video = document.getElementById('backgroundVideo');
            video.addEventListener('ended', () => {
                video.currentTime = 0.05;
                video.play();
            });
        }
    }
</script>


<style lang="scss" scoped>
    #banner {
        overflow: hidden;
        position: relative;
    }
#backgroundVideo {
    position: absolute;
    right: 0;
    bottom: 0;
    min-width: 100%;
    min-height: 100%;
}
.background {
    background-color: #000;
    background-size: cover;
    background-position: center right;
}
.logo {
  max-width: 40px;
  max-height: 40px;
}
.big-font {
    font-size: 3.5rem;
}
</style>
