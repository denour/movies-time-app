<template>
    <app-layout title="Turns">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                    <jet-form-section @submitted="updateTurn">
                        <template #title>
                            {{ turn ? 'Edicion' : 'Creacion' }} Turno
                        </template>
                        <template #description>
                            Turno {{turn ? turn.time : ''}}
                        </template>
                        <template #form>
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="time" value="Turno" />
                                <Datepicker minutesIncrement="30" :startTime="{hours: 0, minutes: 30}"  timePicker v-model="form.time"></Datepicker>
                                <jet-input-error :message="form.errors.time" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 flex">
                                <jet-input id="status" type="checkbox" @click="handleStatus" ref="status" :checked="form.status" autocomplete="status" />
                                <jet-label for="status" class="ml-2" value="Status" />
                                <jet-input-error :message="form.errors.status" class="mt-2" />
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
import Datepicker from 'vue3-date-time-picker';
import 'vue3-date-time-picker/dist/main.css'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
export default defineComponent({
    props: {
        errors: Object,
        turn: Object,
    },
    components: {
        AppLayout,
        JetInput,
        JetInputError,
        JetLabel,
        JetButton,
        Datepicker,
        JetActionMessage,
        JetFormSection
    },
    created() {
        if (this.turn) {
            const time = this.turn.time.split(":");
            this.form = this.$inertia.form({
                time: {
                    hours: time[0],
                    minutes: time[1]
                },
                status: this.turn.status
            });
        }
    },
    data() {
        return {
            form: this.$inertia.form({
                time: '',
                status: false
            })
        }
    },
    methods: {
        handleAddFile({file}) {
            this.form.thumbnail = file;
        },
        handleStatus() {
            this.form.status = !this.form.status
        },
        updateTurn() {
            if (this.turn) {
                this.form.transform(data => {
                    data.time = data.time.hours + ':' + data.time.minutes;
                    return data;
                }).put(route('turns.update', this.turn.id), {
                    errorBag: 'updateTurn',
                    preserveScroll: true,
                    onSuccess: () => this.form.reset(),
                });
            } else {
                this.form.transform(data => {
                    data.time = data.time.hours + ':' + data.time.minutes;
                    return data;
                }).post(route('turns.store'), {
                    errorBag: 'updateTurn',
                    preserveScroll: true,
                    onSuccess: () => this.form.reset(),
                });
            }
        }
    }
})
</script>
