<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Turnos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end">
                    <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" :href="route('turns.create')">Crear Turno</a>
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
                                Tiempo
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
                        <tr v-for="turn in turnList.data" :key="turn.id">
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{turn.id}}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{turn.time}}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span
                                    v-if="turn.status"
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
                                <a :href="'/turns/' + turn.id + '/edit'" class="cursor-pointer"><i class="material-icons">create</i></a>
                                <a @click.prevent="updateStatus(turn)" class="cursor-pointer">
                                    <i v-if="!turn.status" class="material-icons">lock</i>
                                    <i v-else class="material-icons">lock_open</i>
                                </a>
                                <a @click.prevent="deleteTurn(turn)" class="cursor-pointer"><i class="material-icons">delete</i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="flex justify-center">
                        <pagination class="my-6" :links="turnList.links"/>
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

export default defineComponent({
    props: [
        'turnList'
    ],
    data() {
        return {
            columns: []
        }
    },
    methods: {
        updateStatus(turn) {
            this.$inertia.put(route("turns.update", turn.id),
                {
                    status: !turn.status
                })
        },
        deleteTurn(turn) {
            this.$inertia.delete(route("turns.destroy", turn.id))
        }
    },
    components: {
        Pagination,
        AppLayout,
    },
})
</script>

