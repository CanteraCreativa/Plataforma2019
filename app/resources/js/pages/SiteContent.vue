<template>
    <div class="row text-dark justify-content-md-center" id="siteContent">
        <div class="col-md-10  col-lg-8 p-0">

            <div class="row">
                <div class="col-12">
                    <a href="#" @click="$router.go(-1)">Volver</a>
                </div>
                <div class="col-12">
                    <h1 class=" floating-title font-batman-bold">
                        {{content.title}}
                    </h1>
                </div>


                <div class="col-12" v-html="content.content"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SiteContent",
        data: () => ({
            content: null,
        }),
        beforeMount() {
            axios.get('/api/site_content/' + this.$route.params.slug).then((response) => {
                console.log(response)
                if(response.data.success != false) {
                    this.content = response.data.content
                } else {
                    this.content = {
                        title: 'La página no existe',
                        content: 'El contenido que está intentando ver no existe'
                    }
                }
            })
        }
    }
</script>

<style scoped>

</style>
