<script setup>
    import { ref, computed, onMounted } from 'vue';
    import { date } from 'quasar';

    const props = defineProps({
        meeting: Object,
    });

    const dateFormated = computed(() => {
        return props.meeting.start_at ? date.formatDate(new Date(props.meeting.start_at), 'DD [de] MMMM [ás] HH[h]') : null;
    })
</script>

<template>
    <div class="student-highlight-container">
        <img
            :src="meeting.image"
            :alt="meeting.name"
        />

        <div
            style="padding-left: 104px;"
            class="row items-center student-highlight-container-content"
        >
            <div class="col-md-6 col-10">
                <div class="student-text-purple app-fw-800 app-fs-12 app-lh-16 q-mb-md student-label-category-carrousel">
                    Ciné Debát
                </div>

                <div class="text-white app-fw-800 app-fs-58 app-lh-72 q-mb-lg">
                    {{ meeting.name }}
                </div>

                <div class="text-white app-fw-400 app-fs-19 app-lh-24 q-mb-lg" >
                    {{ meeting.description }}
                </div>

                <div class="row items-center q-mb-lg">
                    <div class="text-white app-fw-700 app-fs-19 app-lh-24">
                        {{ dateFormated }}
                    </div>
                </div>

                <div class="q-pt-md">
                    <q-btn
                        unelevated
                        class="app-br-16 student-bg-purple text-white q-mr-md"
                        padding="20px 24px"
                    >
                        <q-icon name="o_calendar_today" size="sm" class="q-ml-sm"/>

                        <div class="text-caption q-mx-sm app-fw-600 app-fs-16 app-lh-16" style="letter-spacing: 1px;">
                            Agendar horário
                        </div>
                    </q-btn>
                </div>
            </div>
        </div>
    </div>
</template>
