<script setup>
    import { computed } from 'vue';
    import { date } from 'quasar';
    import LiveEventChip from '@/Components/Admin/Schedule/LiveEventChip.vue';
    import MeetingChip from '@/Components/Admin/Schedule/MeetingChip.vue';

    const props = defineProps({
        dateLiveEvent: String,
        liveEventCount: {
            type: Number,
            default: 0
        },
        meetingCount: {
            type: Number,
            default: 0
        },
        nextEventDate: String,
        nextEvent: Object
    });

    const dateLiveEvent = computed(() => {
        return props.nextEventDate ? date.formatDate(new Date(props.nextEventDate), 'dddd, DD [de] MMMM') : null;
    })

</script>

<template>
     <div class="row q-pb-lg q-col-gutter-lg">
        <!-- A receber diário -->
        <div class="col-12 col-md-6">
            <q-card flat class="app-br-16 q-pa-sm full-height">
                <q-card-section class="adm-text-primary-dark app-fs-16 app-lh-24 app-fw-700 q-py-none flex items-center justify-between">
                    Evento mais próximo

                    <q-icon name="o_info" size="xs" class="cursor-pointer">
                        <q-tooltip
                            anchor="top middle"
                            self="bottom middle"
                            class="text-body2 bg-grey-10"
                        >
                            Evento ao vivo ou encontro mais próximo
                        </q-tooltip>
                    </q-icon>
                </q-card-section>

                <q-card-section class="row items-stretch justify-between">
                    <div class="col-12 col-md-9 adm-text-primary app-lh-48 app-fs-35 app-fw-700">
                        {{ dateLiveEvent }}
                    </div>

                    <div class="col-12 col-md-3 self-end">
                        <LiveEventChip
                            :liveEvent="nextEvent"
                            v-if="nextEvent?.type === 'liveEvent'"
                            class="fit"
                        />

                        <MeetingChip
                            :meeting="nextEvent"
                            v-if="nextEvent?.type === 'meeting'"
                            class="fit"
                        />
                    </div>
                </q-card-section>
            </q-card>
        </div>

        <!-- Total de Eventos ao vivo -->
        <div class="col-12 col-md-3">
            <q-card flat class="app-br-16 q-pa-md full-height">
                <q-card-section class="adm-text-primary-dark app-fs-16 app-lh-24 app-fw-700 q-py-none flex items-center justify-between">
                    Total de Eventos ao vivo

                    <q-icon name="o_info" size="xs" class="cursor-pointer">
                        <q-tooltip
                            anchor="top middle"
                            self="bottom middle"
                            class="text-body2 bg-grey-10"
                        >
                            Eventos ao vivo que ainda irão acontecer, ou seja, data e hora de início maiores do que data e hora atual
                        </q-tooltip>
                    </q-icon>
                </q-card-section>

                <q-card-section class="flex flex-center adm-text-primary app-lh-48 app-fs-39 app-fw-700 fit">
                    {{ meetingCount }}
                </q-card-section>
            </q-card>
        </div>

        <!-- Total de Encontros -->
        <div class="col-12 col-md-3">
            <q-card flat class="app-br-16 q-pa-md full-height">
                <q-card-section class="adm-text-primary-dark app-fs-16 app-lh-24 app-fw-700 q-py-none flex items-center justify-between">
                    Total de Encontros
                    <q-icon name="o_info" size="xs" class="cursor-pointer">
                        <q-tooltip
                            anchor="top middle"
                            self="bottom middle"
                            class="text-body2 bg-grey-10"
                        >
                            Encontros que ainda irão acontecer, ou seja, data e hora de início maiores do que data e hora atual
                        </q-tooltip>
                    </q-icon>
                </q-card-section>

                <q-card-section class="flex flex-center adm-text-purple app-lh-48 app-fs-39 app-fw-700 fit">
                    {{ liveEventCount }}
                </q-card-section>
            </q-card>
        </div>
    </div>
</template>
