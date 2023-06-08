 <script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm, usePage } from '@inertiajs/inertia-vue3';
    import { useQuasar, date } from 'quasar'
    import { ref, computed, onMounted } from 'vue'
    import DialogConfirm from '@/Components/Admin/DialogConfirm.vue';

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
                });

                startCountStartTime();
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
    const meetingEnded = computed(() => props.meeting.status === 'Finalizado');
    const meetingDidNotEnd = computed(() => props.meeting.status !== 'Finalizado');

    const lessThanFiveMinutesToStart = ref(calculateDiffInSeconds() <= 300);
    const authUserIsTeacherThisMeeting = computed(() => props.meeting.teacher.id === usePage().props.value.auth.user.id);

    const canStartClass = computed(() => authUserIsTeacherThisMeeting.value && lessThanFiveMinutesToStart.value && meetingIsOpen.value);
    const canFinishClass = computed(() => authUserIsTeacherThisMeeting.value && meetingStarted.value);
    const canStartMeeting = computed(() => authUserIsTeacherThisMeeting.value && !lessThanFiveMinutesToStart.value && meetingIsOpen.value);

    const calculateTimeClassStarted = () => {
        if (! props.meeting.started_at) {
            return 0;
        }

        let dateMatchStartedAt = props.meeting.started_at.match(/(\d\d)\/(\d\d)\/(\d\d\d\d) (\d\d):(\d\d):(\d\d)/)

        let dateStarted = date.buildDate({
            year: dateMatchStartedAt[3],
            month: dateMatchStartedAt[2],
            day: dateMatchStartedAt[1],
            hours: dateMatchStartedAt[4],
            minutes: dateMatchStartedAt[5],
            seconds: dateMatchStartedAt[6],
        });

        return date.getDateDiff(Date.now(), dateStarted, 'seconds');
    }

    const timeClassStarted = ref(calculateTimeClassStarted());

    const timeClassStartedtoString = computed(() => timeClassStarted.value > 0 ? new Date(timeClassStarted.value * 1000).toISOString().slice(11, 19) : '00:00:00')

    const intervalTimeStart = ref();

    const startCountStartTime = () => {
        intervalTimeStart.value = setInterval(() => {
            if (meetingStarted.value) {
                timeClassStarted.value = calculateTimeClassStarted();
            } else {
                clearInterval(intervalTimeStart.value);
            }
        }, 1000);
    }


    const calculateSecondsToFinish = () => {
        let dateMatch = props.meeting.end_at.match(/(\d\d)\/(\d\d)\/(\d\d\d\d) (\d\d):(\d\d)/)

        let dateEndBuilt = date.buildDate({
            year: dateMatch[3],
            month: dateMatch[2],
            day: dateMatch[1],
            hours: dateMatch[4],
            minutes: dateMatch[5],
            seconds: 0,
        });

        return date.getDateDiff(dateEndBuilt, Date.now(), 'seconds');
    }

    const timeToFinish = ref(calculateSecondsToFinish());

    const timeToFinishToString = computed(() => timeToFinish.value > 0 ? new Date(timeToFinish.value * 1000).toISOString().slice(14, 19) : '00:00')
    const showFirstWarning =  computed(() => timeToFinish.value < 300 && timeToFinish.value > 0 && meetingDidNotEnd.value);
    const showSecondWarning =  computed(() => timeToFinish.value <= 0 && meetingDidNotEnd.value);
    const nowItIsBiggerEndAt =  computed(() => timeToFinish.value <= 0);

    let calculateSecondsToFinishInterval = setInterval(() => {
        timeToFinish.value = calculateSecondsToFinish();

        if (timeToFinish.value === 0) {
            clearInterval(calculateSecondsToFinishInterval);
        }
    }, 1000);


    const calculateSecondsToStartMeeting = () => {
        let dateMatchStart = props.meeting.start_at.match(/(\d\d)\/(\d\d)\/(\d\d\d\d) (\d\d):(\d\d):(\d\d)/)

        let dateStartBuilt = date.buildDate({
            year: dateMatchStart[3],
            month: dateMatchStart[2],
            day: dateMatchStart[1],
            hours: dateMatchStart[4],
            minutes: dateMatchStart[5],
            seconds: dateMatchStart[6],
        });

        return date.getDateDiff(dateStartBuilt, Date.now(), 'seconds') - 300;
    }

    const timeToStartMeeting = ref(calculateSecondsToStartMeeting());

    const timeToStartToStringMeeting = computed(() => timeToStartMeeting.value > 0 ? new Date(timeToStartMeeting.value * 1000).toISOString().slice(11, 19) : '00:00:00')

    let calculateSecondsToStartMeetingInterval = setInterval(() => {
        timeToStartMeeting.value = calculateSecondsToStartMeeting();

        if (timeToStartMeeting.value === 0) {
            clearInterval(calculateSecondsToStartMeetingInterval);
        }
    }, 1000);

    onMounted(() => {
        startCountStartTime();
    })
</script>

<template>
    <AuthenticatedLayout>
        <Head :title="meeting.name" />

        <div class="bg-red app-br-16 text-white text-center q-py-sm q-mb-md" v-if="showFirstWarning">
            Atenção: este encontro deve terminar em {{ timeToFinishToString }} minutos.
        </div>

        <div class="bg-red app-br-16 text-white text-center q-py-sm q-mb-md" v-if="showSecondWarning">
            Atenção: o prazo de encerramento deste encontro já estourou.
        </div>

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
                    v-if="canStartClass"
                    @click="start()"
                >
                    <q-icon name="o_play_arrow" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Iniciar encontro
                    </div>
                </q-btn>

                <q-btn
                    color="primary"
                    class="q-mr-md cursor-inherit"
                    rounded
                    no-caps
                    outline
                    v-if="canStartMeeting"
                >
                    <q-icon name="pan_tool" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Aguarde, você poderá iniciar o encontro em {{ timeToStartToStringMeeting }}
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
                    {{ timeClassStartedtoString }}
                </div>

                <div
                    class="q-mx-md text-red app-fw-600"
                    v-if="meetingEnded"
                >
                    Finalizado
                </div>
            </div>
        </div>

        <div class="bg-white q-py-lg q-px-lg app-br-16">
            <div class="row q-col-gutter-lg">
                <div class="col-12 col-md-12" v-if="meeting.teacher?.whereby_link">
                    <iframe
                        :title="`Aula de ${meeting.teacher.name}`"
                        class="adm-player-embed app-br-16"
                        allowfullscreen
                        :src="meeting.teacher?.whereby_link"
                        allow="camera; microphone; fullscreen; speaker; display-capture"
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
        </div>
    </AuthenticatedLayout>
</template>
