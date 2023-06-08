<script setup>
    import { useForm } from '@inertiajs/inertia-vue3';
    import { computed } from 'vue';
    import { date } from 'quasar';

    const props = defineProps({
        nextEvent: Object,
        typeCard: String,
    });

    const studentsByPlaces = computed(() => `${props.nextEvent?.students_count}/${props.nextEvent?.number_of_students}`)

    const dateLiveEvent = computed(() => {
        return props.nextEvent?.next_event_date && props.typeCard === 'nextEvent' ? date.formatDate(new Date(props.nextEvent?.next_event_date), 'dddd, DD [de] MMMM') : date.formatDate(new Date(props.nextEvent?.next_event_date), 'DD [de] MMMM');
    })

    const eventIcon = computed(() => {
        return props.nextEvent?.type_event === 'liveEvent' ? 'wifi' : 'chat_bubble_outline';
    })

    const eventName = computed(() => {
        return props.nextEvent?.type_event === 'liveEvent' ? 'Evento ao vivo' : 'Encontro';
    })

    const eventShow = computed(() => {
        return props.nextEvent?.type_event === 'liveEvent' ? 'evento' : 'encontro';
    })

    const eventList = computed(() => {
        return props.nextEvent?.type_event === 'liveEvent' ? 'eventos' : 'encontros';
    })

    const eventBgColor = computed(() => {
        return props.nextEvent?.type_event === 'liveEvent' ? 'adm-bg-purple' : 'adm-bg-primary';
    })

    const eventTextColor = computed(() => {
        return props.nextEvent?.type_event === 'liveEvent' ? 'adm-text-purple' : 'adm-text-primary';
    })

    const list = () => {
        if(props.nextEvent?.type_event === 'meeting') {
            useForm().get(route('admin.meeting.index'))
        } else if(props.nextEvent?.type_event === 'liveEvent') {
            useForm().get(route('admin.live-event.index'))
        }
    };

    const follow = () => {
        if(props.nextEvent?.type_event === 'meeting') {
            useForm().get(route('admin.meeting.follow', props.nextEvent?.id))
        } else if(props.nextEvent?.type_event === 'liveEvent') {
            useForm().get(route('admin.live-event.follow', props.nextEvent?.id))
        }
    };

    const show = () => {
        if(props.nextEvent?.type_event === 'meeting') {
            useForm().get(route('admin.meeting.show', props.nextEvent?.id))
        } else if(props.nextEvent?.type_event === 'liveEvent') {
            useForm().get(route('admin.live-event.show', props.nextEvent?.id))
        }
    };

</script>

<template>
    <div>
        <div class="row items-stretch justify-between">
            <div class="col-12 app-fs-28 app-fw-700" :class="eventTextColor">
                {{ dateLiveEvent }}
            </div>
        </div>

        <div class="adm-text-primary-dark app-fs-16 app-fw-700 flex q-mt-md">
            Tipo do evento
        </div>

        <div class="adm-text-primary-dark app-fs-16 app-fw-700 q-py-none flex q-mt-sm">
            <q-chip
                    :icon="eventIcon"
                    :class="eventBgColor"
                    rounded
                    class="q-py-none q-pl-md cursor-inherit"
                    text-color="white"
            >
                <div class="q-ml app-fw-500 app-fs-14">
                    {{ eventName }}
                </div>
            </q-chip>
            <div class="q-ml-sm app-fw-500 app-fs-16 app-lh-30">
                <q-icon name="person_outline" size="sm"/>
                {{ nextEvent?.type }}

                <q-icon name="schedule" size="sm" class="q-ml-sm"/>
                {{ nextEvent?.hour_at }}
            </div>
        </div>

        <div class="q-mt-sm adm-text-primary-dark app-fs-16 app-fw-700 flex q-mt-md">
            Nome do evento
        </div>

        <div class="adm-text-primary-dark app-fw-700 q-py-none q-mt-sm">
            <div class="app-fw-400 app-fs-16">
                {{ nextEvent?.name }}
            </div>
        </div>

        <div class="q-mt-sm adm-text-primary-dark app-fs-16 app-fw-700 flex q-mt-md">
            <div v-if="nextEvent?.type_event === 'meeting'">
                {{ studentsByPlaces }} vagas preenchidas
            </div>
            <div v-if="nextEvent?.type_event === 'liveEvent'">
                &nbsp;
            </div>
        </div>

        <div class="adm-text-primary app-lh-24 app-fw-700 flex q-mt-lg" >
            <div class="app-fw-500 app-fs-14 cursor-pointer" @click="show" v-if="typeCard === `nextEvent`">
                Visualizar {{ eventShow }}
            </div>

            <div class="app-fw-500 app-fs-14 cursor-pointer" @click="list" v-if="typeCard === `futureEvent`">
                Visualizar mais {{ eventList }}
            </div>

            <q-btn v-if="nextEvent?.type_event === `meeting` && typeCard === `nextEvent`"
                color="primary"
                rounded
                no-caps
                class="q-py-none q-ml-auto"
                @click="follow"

            >
                <q-icon name="play_arrow" class="material-icons-outlined" size="sm"/>

                <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                    Iniciar encontro
                </div>
            </q-btn>
        </div>
    </div>
</template>
