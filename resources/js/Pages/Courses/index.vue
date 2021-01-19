<template>
    <app-layout>
        <template #header>
                Liste des formations
        </template>
         <div class="bg-green-200 text-green-500 p-3" v-if="$page.props.flash.success">
                     {{ $page.props.flash.success }}
         </div>
        <div  class="py-4" v-for="course in this.courselist" v-bind:key="course.id">
            <div class="mx-8 bg-white rounded shadow p-4"> 
                
               <div class="text-sm text-gray-500" >Mise en ligne par {{ course.user.name }} - <span class="text-sm text-gray-500">{{ course.participants}} Participant<span v-if=" parseInt(course.participants ) > 1">s</span></span></div>
               <div class="flex justify-between items-center">
                    <div class="text-xl"> {{ course.title}}</div>
                    <div class="text-sm text-gray-200" >{{ course.episodes_count }}</div>
               </div>
                <div class="text-sm text-gray-500"> {{ course.description}}</div>
                <a :href="route('courses.show',course.id)" class="bg-indigo-500 text-white px-2 py-1 hover:bg-indigo-700 my-1 inline-block">Voir la formation</a>
                <a :href="route('courses.edit',course.id)" v-if="course.update" class="bg-gray-500 text-white px-2 py-1 hover:bg-gray-700 my-1 inline-block">editer</a>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from './../../Layouts/AppLayout';

export default {
  components: { AppLayout },
  props: ['courses'],
  data(){
      return{
          courselist: this.courses
      }
  },
  mounted(){
      console.log(this.courselist);
  }

}
</script>