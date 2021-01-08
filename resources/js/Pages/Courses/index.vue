<template>
    <app-layout>
        <template #header>
                Liste des formations
        </template>
        <div v-for="course in this.courselist" v-bind:key="course.id">
            <h2> {{ course.title}}</h2>
            <p> {{ course.description}}</p>
        </div>
        Coucou  toto
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