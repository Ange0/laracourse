<template>
    <div>
       
       <div class="bg-gray-200 w-full rounded">
            <div class="bg-green-500 text-white rounded-l text-center transition-width duration-500" :style="'width:'+ percentage + '%'">
                {{ percentage }}%
            </div>
       </div>
    </div>
</template>
<script>
export default {
      props: ['watchedEpisodes','episodes'],
      data(){
          return {
              watchedEpisodesData : this.watchedEpisodes
          }
      },
      computed: // attribut 
      {
          percentage() 
          {
              let filterEpisodes = this.episodes.filter(coursEp => {
                  return this.watchedEpisodesData.find(watchedEp => {
                     return  watchedEp.id === coursEp.id;
                  })
              });

              return Math.ceil(filterEpisodes.length / this.episodes.length * 100); // calcul du poucentage puis arrondi avec ceil
          }
      },
      mounted(){
         /*  console.log(this.watchedEpisodes,this.episodes) */
         eventBus.$on('toggleProgress',data => this.watchedEpisodesData = data ) // on le recoit l'evement ici
      }
}
</script>