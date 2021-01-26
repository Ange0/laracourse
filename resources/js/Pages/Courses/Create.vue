<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>
    <div class="bg-green-200 text-green-500 p-3" v-if="$page.props.flash.success">
      {{ $page.props.flash.success }}
    </div>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div>
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                 {{ __('messages.training') }}
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                  {{ $t('createTraining')}}
                </p>
                <button type="button" class="btn btn-info">Info</button>
              </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
              <form action="#" method="POST" @submit.prevent="submit()">
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                  <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <div class="grid grid-cols-3 gap-6">
                      <div class="col-span-3 sm:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">
                          Titre de la formation (*)
                        </label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                          <input type="text" v-model="form.title" :name="form.title" id="company_website" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Formation laravel"/>
                        </div>
                        <div v-if="errors.title" class="text-red-800 mt-2" >
                            {{ errors.title }}
                        </div>
                      </div>
                    </div>
                    <div>
                      <label for="description" class="block text-sm font-medium text-gray-700"> Description de la formation (*)</label>
                      <div class="mt-1">
                        <textarea id="description" v-model="form.description" :name="form.description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Une bref description"></textarea>
                      </div>
                       <div v-if="errors.description" class="text-red-800 mt-2" >
                            {{ errors.description }}
                        </div>
                    </div>
                    <hr />
                    <div class="text-gray-500">Episodes de la formation</div>
                    <div v-for="(episode, index) in form.episodes" v-bind:key="index">
                      <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-2 sm:col-span-2">
                          <label :for="'title'+index" class="block text-sm font-medium text-gray-700">
                            Titre de l'episode n° {{ index + 1 }}
                          </label>
                          <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" v-model="form.episodes[index].title" :name="form.episodes[index].title" :id="'title'+index" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Formation laravel"/>
                          </div>
                          <div v-if="errors['episodes.'+ index +'.title']" class="text-red-800 mt-2" >
                            {{ errors['episodes.'+ index  +'.title'] }} <!-- JE precise que la premiere erreur -->
                        </div>
                        </div>
                        <div class="col-span-2 sm:col-span-2">
                          <label :for="'description'+index" class="block text-sm font-medium text-gray-700">
                            Description de l'episode n° {{ index + 1 }}
                          </label>
                          <div class="mt-1">
                            <textarea :id="'description'+index" v-model="form.episodes[index].description" :name="form.episodes[index].description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Une bref description"></textarea>
                          </div>
                          <div v-if="errors['episodes.'+ index +'.description']" class="text-red-800 mt-2" >
                            {{ errors['episodes.'+ index  +'.description'] }} <!-- JE precise que la premiere erreur -->
                          </div>
                        </div>
                      </div>
                      <div class="col-span-3 sm:col-span-2">
                        <label :for="'video_url'+index" class="block text-sm font-medium text-gray-700">
                          Lien de la video n° {{ index + 1 }}
                        </label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                          <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                            http://
                          </span>
                          <input type="text" v-model="form.episodes[index].video_url" :name="form.episodes[index].video_url" :id="'video_url'+index" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="www.example.com"/>
                        </div>
                          <div v-if="errors['episodes.'+ index +'.video_url']" class="text-red-800 mt-2" >
                            {{ errors['episodes.'+ index  +'.video_url'] }} <!-- JE precise que la premiere erreur -->
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button class="py-2 px-2 bg-red-600 rounded text-white block" title="Retirer episode" @click.prevent="remove()" v-if="form.episodes.length > 1">-</button>
                    <button class="py-2 px-2 bg-green-600 rounded text-white block" title="Ajouter une episode" @click.prevent="add()" v-if="form.episodes.length <= 15">+</button>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                      Creer ma formation
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout";



export default {
  components: {
    AppLayout,
  },
  props:{
    errors: Object
  },
  data() {
    return {
      form: {
        title: null,
        description: null,
        episodes: [{ title: null, description: null, video_url: null }],
      },
    };
  },
  methods: {
    submit() 
    {
      this.$inertia.post(route("courses.store"), this.form);
    },
    add() 
    {
        this.form.episodes.push({ title: null, description: null, video_url: null });
    },
    remove()
    {
      
       this.form.episodes.pop();
    },
  
  },

};
</script>
