 <script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm, usePage } from '@inertiajs/inertia-vue3';
    import { useQuasar, date } from 'quasar'
    import { ref, computed, watchEffect, watch} from 'vue'
    import DialogConfirm from '@/Components/Admin/DialogConfirm.vue';
    import axios from 'axios';

    const $q = useQuasar();

    const props = defineProps({
        meeting: Object,
        errors: Object,
        canMeetingStartFinish: Boolean,
        canMeetingDetachStudent: Boolean,
    });

    const imageForDoc = 'https://i.pinimg.com/564x/04/54/7c/04547c2b354abb70a85ed8a2d1b33e5f.jpg';

    const removeStudent = (student) => {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Retirar aluno',
                message: `Tem certeza que deseja retirar ${student.name} do encontro ${props.meeting.name}?`,
            },
        }).onOk(() => {
            useForm().put(route('admin.meeting.detach-student', {
                meeting: props.meeting.id,
                student: student.id,
            }), {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: `${student.name} retirando do encontro ${props.meeting.name}.`,
                        position: 'top',
                    })
                }
            })
        })
    }

    const start = () => {
        useForm().put(route('admin.meeting.start', props.meeting.id), {
            preserveScroll: true,
            onSuccess: () => {
                $q.notify({
                    type: 'positive',
                    message: `Encontro ${props.meeting.name} iniciado.`,
                    position: 'top',
                })
            }
        })
    }

    const finish = () => {
        useForm().put(route('admin.meeting.finish', props.meeting.id), {
            preserveScroll: true,
            onSuccess: () => {
                $q.notify({
                    type: 'positive',
                    message: `Encontro ${props.meeting.name} finalizado.`,
                    position: 'top',
                })
            }
        })
    }
    const toggleLaunchOffer = () => {
        useForm().put(route('admin.meeting.toggle-offer-availability', props.meeting.id), {
            preserveScroll: true,
            onSuccess: () => {
                let action = props.meeting.offer_available ? 'liberada' : 'encerrar';

                $q.notify({
                    type: 'positive',
                    message: `Oferta ${action}`,
                    position: 'top',
                })
            }
        })
    }

    const downloadMaterial = (material) => {
        const link = document.createElement('a');
        link.href = material.link;
        link.setAttribute('download', material.name);
        link.click();
    }

    const calculateDiffInSeconds = () => {
        let dateMatch = props.meeting.start_at.match(/(\d\d)\/(\d\d)\/(\d\d\d\d) (\d\d):(\d\d)/)

        const dateStartMeeting = date.buildDate({
            year: dateMatch[3],
            month: dateMatch[2],
            day: dateMatch[1],
            hours: dateMatch[4],
            minutes: dateMatch[5],
            seconds: 0
        });

        return date.getDateDiff(dateStartMeeting, Date.now(), 'seconds')
    }

    let checkIfLessThanFiveMinutesToStart = setInterval(() => {
        if (calculateDiffInSeconds() <= 300) {
            clearInterval(checkIfLessThanFiveMinutesToStart)
            lessThanFiveMinutesToStart.value = true
        }
    }, 1000);

    const meetingIsOpen = computed(() => props.meeting.status === 'Aberto');
    const meetingStarted = computed(() => props.meeting.status === 'Iniciado');
    const meetingDidNotEnd = computed(() => props.meeting.status !== 'Finalizado');

    const lessThanFiveMinutesToStart = ref(calculateDiffInSeconds() <= 300);
    const authUserIsTeacherThisMeeting = computed(() => props.meeting.teacher.id === usePage().props.value.auth.user.id);

    const canStartClass = computed(() => authUserIsTeacherThisMeeting.value && lessThanFiveMinutesToStart.value && meetingIsOpen.value);
    const canFinishClass = computed(() => authUserIsTeacherThisMeeting.value && meetingStarted.value);

    const timeClassStartedtoString = () => {
        if (! props.meeting.started_at) {
            return '00:00:00';
        }

        let dateMatch = props.meeting.started_at.match(/(\d\d)\/(\d\d)\/(\d\d\d\d) (\d\d):(\d\d):(\d\d)/)

        let dateStarted = date.buildDate({
            year: dateMatch[3],
            month: dateMatch[2],
            day: dateMatch[1],
            hours: dateMatch[4],
            minutes: dateMatch[5],
            seconds: dateMatch[6],
        });

        return new Date(date.getDateDiff(Date.now(), dateStarted, 'seconds') * 1000).toISOString().slice(11, 19);
    }

    const timeSinceTheBeginningToString = ref(timeClassStartedtoString());

    let intervalTimeStart = setInterval(() => {
        if (meetingStarted.value) {
            timeSinceTheBeginningToString.value = timeClassStartedtoString();
        } else {
            clearInterval(intervalTimeStart);
        }
    }, 1000);

    const checkIfNowItIsBiggerEndAt = () => {
        let dateMatch = props.meeting.end_at.match(/(\d\d)\/(\d\d)\/(\d\d\d\d) (\d\d):(\d\d)/)

        let dateEndBuilt = date.buildDate({
            year: dateMatch[3],
            month: dateMatch[2],
            day: dateMatch[1],
            hours: dateMatch[4],
            minutes: dateMatch[5],
            seconds: 0,
        });

        return new Date > dateEndBuilt;
    }

    const nowItIsBiggerEndAt = ref(checkIfNowItIsBiggerEndAt())

    let intervalTimeEnd = setInterval(() => {
        if (nowItIsBiggerEndAt.value) {
            clearInterval(intervalTimeEnd);
        } else {
            nowItIsBiggerEndAt.value = checkIfNowItIsBiggerEndAt();
        }
    }, 1000);

    const messages = ref([])
    const message = ref('')

    const sendMessage = () => {
        axios.post(route('admin.chat-message.send', props.meeting.id), {
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
        <Head title="Encontro | Editar" />

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

                <q-btn
                    color="primary"
                    class="q-mr-md"
                    rounded
                    no-caps
                    outline
                    v-if="canStartClass"
                    @click="start()"
                >
                    <q-icon name="o_play_arrow" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Iniciar encontro
                    </div>
                </q-btn>

                <q-btn
                    color="negative"
                    class="q-mr-md"
                    rounded
                    no-caps
                    outline
                    v-if="canFinishClass"
                    @click="finish()"
                >
                    <q-icon name="close" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Finalizar encontro
                    </div>
                </q-btn>

                <q-btn
                    :color="meeting.offer_available ? 'warning' : 'primary'"
                    color="primary"
                    rounded
                    no-caps
                    @click="toggleLaunchOffer"
                    v-if="meetingStarted && meeting.has_live_offer"
                    unelevated
                >
                    <q-icon :name="meeting.offer_available ? 'money_off' : 'attach_money'" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        {{ meeting.offer_available ? "Encerrar oferta" : "Liberar oferta" }}
                    </div>
                </q-btn>

                <div
                    class="q-mx-md"
                    :class="{
                        'text-primary': !nowItIsBiggerEndAt,
                        'text-red': nowItIsBiggerEndAt
                    }"
                    v-if="meetingStarted"
                >
                    {{ timeSinceTheBeginningToString }}
                </div>
            </div>
        </div>

        <div class="bg-white q-py-lg q-px-lg app-br-16">

            <div class="row justify-center adm-border-dashed-blue app-br-16">
                <!-- {{ messages }} -->
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

        <!-- <div class="bg-white q-py-lg q-px-lg app-br-16">
            <div class="row q-col-gutter-lg">
                <div class="col-12 col-md-12" v-if="meeting.teacher?.whereby_link">
                    <iframe
                        :title="`Aula de ${meeting.teacher.name}`"
                        class="adm-player-embed app-br-16"
                        allowfullscreen
                        :src="meeting.teacher?.whereby_link"
                    >
                    </iframe>
                </div>

                <div class="col-12 items-center q-mt-xs">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Alunos inscritos
                    </div>
                </div>

                <div class="col-12">
                    <q-chip
                        class="adm-chip-primary"
                        :label="student.name"
                        v-for="student in meeting.students"
                    >
                        <q-icon
                            name="cancel"
                            size="xs"
                            class="q-ml-xs cursor-pointer"
                            @click="removeStudent(student)"
                            v-if="canMeetingDetachStudent && meetingDidNotEnd"
                        />
                    </q-chip>
                </div>

                <div class="col-12 items-center q-mt-xs" v-if="meeting.has_live_offer">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Oferta
                    </div>
                </div>

                <div class="col-12 col-md-5" v-if="meeting.has_live_offer">
                    <q-input
                        outlined
                        v-model="meeting.name_offer"
                        label="Nome da oferta"
                        disable
                    />
                </div>

                <div class="col-12 col-md-7" v-if="meeting.has_live_offer">
                    <q-input
                        outlined
                        v-model="meeting.embed_offer"
                        label="Link da oferta"
                        disable
                    />
                </div>

                <div class="col-12" v-if="meeting.has_live_offer">
                    <q-input
                        outlined
                        v-model="meeting.description_offer"
                        label="Descrição da oferta"
                        disable
                    />
                </div>

                <div class="col-12 items-center" v-if="meeting.materials.length > 0">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Material
                    </div>
                </div>

                <div class="col-12 col-md-3"
                    v-for="(material, index) in meeting.materials"
                    :key="`material-${index}}}`"
                >
                    <q-img
                        :src="material.is_image ? material.link : imageForDoc"
                        style="height: 240px"
                        class="app-br-16"
                    >
                        <div class="absolute-bottom text-subtitle2 row items-center">
                            <q-icon name="attach_file" size="md" class="rotate-225 q-mr-md"/>

                            <div class="column">
                                <span class="text-caption">
                                    {{ material.name.length > 25 ? material.name.slice(0, 25) + '...' : material.name }}
                                </span>

                                <span class="text-caption">
                                    ({{ material.size ?? 0 }} kb)
                                </span>
                            </div>

                            <q-btn
                                color="white"
                                class="absolute"
                                style="top: 8px; right: 8px"
                                flat
                                icon="file_download"
                                size="md"
                                @click="downloadMaterial(material)"
                                dense
                            >
                                <q-tooltip
                                    anchor="center left"
                                    self="center right"
                                    :offset="[10, 10]"
                                    class="text-body2 bg-grey-10"
                                >
                                    Clique para fazer o download
                                </q-tooltip>
                            </q-btn>
                        </div>
                    </q-img>
                </div>
            </div>
        </div> -->
    </AuthenticatedLayout>
</template>
