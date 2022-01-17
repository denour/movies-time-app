<template>
    <app-layout title="Movies">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                    <jet-form-section @submitted="updateMovie">
                        <template #title>
                            {{ this.movie ? 'Edicion' : 'Creacion' }} Pelicula
                        </template>
                        <template #description>
                            Pelicula {{movie ? movie.name : ''}}
                        </template>
                        <template #form>
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="name" value="Name" />
                                <jet-input id="name" type="string" class="mt-1 px-2 block w-full" v-model="form.name" ref="name" autocomplete="name" />
                                <jet-input-error :message="form.errors.name" class="mt-2" />
                            </div>
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="fecha_publicacion" value="Fecha Publicacion" />
                                <Datepicker v-model="form.published_at"></Datepicker>
                                <jet-input-error :message="form.errors.published_at" class="mt-2" />
                            </div>
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="imagen" value="Imagen" />
                                <img v-if="movie" :src="movie.thumbnail">
                                <DropZone
                                    :uploadOnDrop="false"
                                    @addedFile="handleAddFile"
                                    :multipleUpload="false"/>
                                <jet-input-error :message="form.errors.thumbnail" class="mt-2" />
                            </div>
                        </template>
                        <template #actions>
                            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                                Saved.
                            </jet-action-message>

                            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Save
                            </jet-button>
                        </template>
                    </jet-form-section>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import DropZone from 'dropzone-vue';
import 'dropzone-vue/dist/dropzone-vue.common.css';
import Datepicker from 'vue3-date-time-picker';
import 'vue3-date-time-picker/dist/main.css'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
export default defineComponent({
    props: {
        errors: Object,
        movie: Object,
    },
    components: {
        AppLayout,
        JetInput,
        JetInputError,
        JetLabel,
        DropZone,
        JetButton,
        Datepicker,
        JetActionMessage,
        JetFormSection
    },
    created() {
        if (this.movie) {
            this.form = this.$inertia.form({
                name: this.movie.name,
                published_at: this.movie.published_at,
                thumbnail: ''
            });
        }
    },
    data() {
        return {
            form: this.$inertia.form({
                name: '',
                published_at: new Date(),
                thumbnail: ''
            })
        }
    },
    methods: {
        handleAddFile({file}) {
            this.form.thumbnail = file;
        },
        updateMovie() {
            if (this.movie) {
                this.form.transform((data) => {
                    const item = data;

                    if (item.thumbnail === '') {
                        delete item.thumbnail;
                    }

                    return ({
                        ...item,
                        _method: 'put'
                    });
                }).post(route('movies.update', this.movie.id), {
                    errorBag: 'updateMovie',
                    preserveScroll: true,
                    onSuccess: () => this.form.reset(),
                });
            } else {
                this.form.post(route('movies.store'), {
                    errorBag: 'updateMovie',
                    preserveScroll: true,
                    onSuccess: () => this.form.reset(),
                });
            }
        }
    }
})
</script>
