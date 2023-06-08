 <script setup>
    import AuthenticatedLayout from '@/Layouts/Student/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar, date } from 'quasar'
    import { ref, computed } from 'vue'
    import axios from 'axios';

    const $q = useQuasar();

    const props = defineProps({
        meeting: Object,
        errors: Object,
    });

    const messages = ref([])
    const message = ref('')

    const sendMessage = () => {
        axios.post(route('student.chat-message.send', props.meeting.id), {
            message: message.value
        }).then(() => {
            message.value = null;
        });
    }

    window.Echo.channel(`chat-message.${props.meeting.id}`).listen('.chat-message', (e) => {
        messages.value = e.messages;
    })
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Chat" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> {{ meeting.name }} </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Encontros" class="text-grey"/>
                    <q-breadcrumbs-el :label="meeting.name" class="text-primary" />
                </q-breadcrumbs>
            </div>

            <div class="col-12 col-md-6 flex justify-end items-center">
                <q-btn
                    color="primary"
                    class="q-mr-md"
                    rounded
                    no-caps
                    outline
                    @click="sendMessage"
                    v-if="message"
                >
                    <q-icon name="o_play_arrow" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        sendMessage
                    </div>
                </q-btn>
            </div>
        </div>

        <div class="bg-white q-py-lg q-px-lg app-br-16">

            <div class="row justify-center adm-border-dashed-blue app-br-16">
                <div style="width: 100%; max-width: 80%;">
                    <q-chat-message
                        v-for="message in messages"
                        :name="message.user.name"
                        :text="[message.message]"
                        :sent="message.user.id === $page.props.auth.user.id"
                        size="5"
                    />
                </div>
            </div>

            <div class="col-12">
                <q-input
                    outlined
                    v-model="message"
                    label="Mensagem"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
