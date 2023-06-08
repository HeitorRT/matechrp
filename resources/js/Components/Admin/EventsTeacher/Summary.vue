<script setup>
    import { computed } from 'vue';
    import EventData from '@/Components/Admin/EventsTeacher/EventData.vue';

    const props = defineProps({
        nextEventsTeacher: Object,
    });

    const firstEvent = computed(() => {
        let first = props.nextEventsTeacher.length > 0 ? Object.values(props.nextEventsTeacher).slice(0,1) : [];
        return first.length > 0 ? first[0] : null;
    })

    const futureEvents = computed(() => {
        return props.nextEventsTeacher.length > 0 ? Object.values(props.nextEventsTeacher).slice(1,3) : [];
    })

</script>

<template>
     <div class="row q-pb-lg q-col-gutter-lg">
        <!-- Datas mais próximas -->
        <div class="col-12 col-md-5">
            <q-card flat class="app-br-16 q-pa-sm full-height">
                <q-card-section class="adm-text-primary-dark app-fs-16 app-lh-10 app-fw-700 items-center">
                    Datas mais próximas
                </q-card-section>

                <q-card-section>
                    <EventData
                        v-if="firstEvent"
                        :nextEvent="firstEvent"
                        :typeCard="'nextEvent'"
                        class="fit"
                    />
                    <div class="col-12 adm-text-primary-dark app-fs-13 app-lh-10 app-fw-300 text-center q-py-sm" v-else>
                        Nenhum evento agendado
                    </div>
                </q-card-section>
            </q-card>
        </div>

        <!-- Datas futuras -->
        <div class="col-12 col-md-7">
            <q-card flat class="app-br-16 q-pa-sm full-height">
                <q-card-section class="adm-text-primary-dark app-fs-16 app-lh-10 app-fw-700 items-center justify-between">
                    Datas futuras
                </q-card-section>

                <q-card-section>
                    <div class="row">
                        <div class="col-6" v-for="futureEvent in futureEvents">
                            <EventData
                                    :nextEvent="futureEvent"
                                    :typeCard="'futureEvent'"
                                    class="fit"
                            />
                        </div>
                        <div class="col-12 adm-text-primary-dark app-fs-13 app-lh-10 app-fw-300 text-center q-py-sm" v-if="futureEvents.length===0">
                            Nenhum evento agendado
                        </div>
                    </div>
                </q-card-section>

            </q-card>
        </div>
    </div>

</template>
