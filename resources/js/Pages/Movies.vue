<template>
    <modal :show="currentMovie" @close="handleCloseTurns">
        <div class="p-2">
            <div class="col-span-6 sm:col-span-4">
                <select class="w-full" v-model="form.turns" multiple>
                    <option class="w-full" v-for="turn in turns" :value="turn.id" :selected="isSelected(turn)" :key="turn.id">
                        {{turn.time}}
                    </option>
                </select>
                <jet-input-error :message="form.errors.turns" class="mt-2" />
            </div>
        </div>
        <div class="py-2 flex justify-center">
            <button  @click="updateTurns">
                Guardar
            </button>
        </div>
    </modal>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Peliculas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end">
                    <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" :href="route('movies.create')">Crear Pelicula</a>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="min-w-full leading-normal">
                        <thead>
                        <tr>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                ID
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Fecha Publicacion
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="movie in movieList.data" :key="movie.id">
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{movie.id}}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{movie.name}}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{movie.published_at}}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span
                                    v-if="movie.status"
                                    class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                        <span aria-hidden
                                              class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
									<span class="relative">Activo</span>
									</span>

                                <span
                                    v-else
                                    class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                        <span aria-hidden
                                              class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
									<span class="relative">Inactive</span>
									</span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <a :href="'/movies/' + movie.id + '/edit'" class="cursor-pointer"><i class="material-icons">create</i></a>
                                <a @click="showTurn(movie)" class="cursor-pointer">
                                    <i class="material-icons">dehaze</i>
                                </a>
                                <a @click.prevent="updateStatus(movie)" class="cursor-pointer">
                                    <i v-if="!movie.status" class="material-icons">lock</i>
                                    <i v-else class="material-icons">lock_open</i>
                                </a>
                                <a @click.prevent="deleteMovie(movie)" class="cursor-pointer"><i class="material-icons">delete</i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="flex justify-center">
                        <pagination class="my-6" :links="movieList.links"/>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Pagination from "../Pagination";
import Modal from "../Jetstream/Modal";
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInputError from '@/Jetstream/InputError.vue'

export default defineComponent({
    props: {
        movieList: Object,
        turns: Object
    },
    data() {
        return {
            currentMovie: null,
            form: this.$inertia.form({
                id: '',
                turns: []
            })
        }
    },
    methods: {
        handleCloseTurns() {
            this.currentMovie = null;
            this.form = this.$inertia.form({
                id: '',
                turns: []
            })
        },
        updateTurns() {
            this.form.put(route('movies.update', this.form.id),  {
                errorBag: 'updateMovie',
                preserveScroll: true,
                onSuccess: () => this.form.reset(),
            });
        },
        isSelected(turn) {
          return this.form.turns.includes(turn.id)
        },
        showTurn(movie) {
            this.currentMovie = movie;
            this.form.id = movie.id;
            this.form.turns = movie.turns.map(item => item.id);
        },
        updateStatus(movie) {
            this.$inertia.put(route("movies.update", movie.id),
                {
                    status: !movie.status
                })
        },
        deleteMovie(movie) {
            this.$inertia.delete(route("movies.destroy", movie.id))
        }
    },
    components: {
        Modal,
        Pagination,
        AppLayout,
        JetFormSection,
        JetButton,
        JetInputError,

    },
})
</script>

