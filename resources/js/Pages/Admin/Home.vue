<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import SummaryContents from '@/Components/Admin/Content/SummaryContents.vue';
    import { ref, computed } from 'vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import SummaryCommercial from '@/Components/Admin/Commercial/Summary.vue';
    import SummaryFinancial from '@/Components/Admin/Financial/Summary.vue';
    import SummarySchedule from '@/Components/Admin/Schedule/Summary.vue';
    import SummaryEventsTeacher from '@/Components/Admin/EventsTeacher/Summary.vue';

    const props = defineProps({
        errors: Object,

        /** Content summary */
        contentReleasedThisMonth: Object,
        contentsMostViewed: Object,
        contentsExpiresIn60Days: Object,

        /** Summary Commericial */
        totalActiveStudentsCount: Number,
        newStudentsInSelectedMonthCount: Number,
        newStudentsInTheMonthBeforeTheSelectedMonthCount: Number,
        churnRateInSelectedMonth: Number,
        churnRateInTheMonthBeforeTheSelectedMonth: Number,

        /** Schedule Data */
        liveEventCount: Number,
        meetingCount: Number,
        nextEventDate: String,
        nextLiveEvent: Object,
        nextMeeting: Object,
        nextEvent: Object,

        /** Summary Financial */
        valueOfOrdersCanceledInSelectedMonth: Number,
        valueOfOrdersCanceledInTheMonthBeforeSelectedMonth: Number,
        valueOfOrdersExpiredInSelectedMonth: Number,
        valueOfOrdersExpiredInTheMonthBeforeSelectedMonth: Number,
        valueOfOrdersToBeReceivedInSelectedMonth: Number,
        valueOfOrdersToBeReceivedInTheMonthBeforeSelectedMonth: Number,
        valueOfOrdersToBeReceivedToday: Number,
        valueOfOrdersToBeReceivedYesterday: Number,

        /** Events Teacher */
        nextEventsTeacher: Object,

        selectedMonth: Number,
        isSystemUser: Boolean,
        isTeacher: Boolean,
        isPartner: Boolean,
    });

    const optionsMonths = computed(() => [
        { value: 1, label: 'Janeiro' },
        { value: 2, label: 'Fevereiro'},
        { value: 3, label: 'Março' },
        { value: 4, label: 'Abril' },
        { value: 5, label: 'Maio' },
        { value: 6, label: 'Junho' },
        { value: 7, label: 'Julho' },
        { value: 8, label: 'Agosto' },
        { value: 9, label: 'Setembro' },
        { value: 10, label: 'Outubro' },
        { value: 11, label: 'Novembro' },
        { value: 12, label: 'Dezembro' },
    ])

    const month = ref(props.selectedMonth)

    const selectedMonthSubmit = () => {
        useForm({ month: month.value }).get(route('admin.home'), {
            preserveState: true,
            preserveScroll: true,
        });
    }
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div class="row q-pb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Dashboard </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Dashboard" class="text-primary" />
                </q-breadcrumbs>
            </div>
        </div>

        <div class="row items-center justify-between q-pb-md q-mt-lg" v-if="isTeacher">
            <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Seus próximos eventos </div>
        </div>

        <SummaryEventsTeacher
            v-if="isTeacher"
            :nextEventsTeacher="nextEventsTeacher"
        />

        <div class="row items-center justify-between q-pb-md q-mt-lg" v-if="isSystemUser">
            <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Agenda </div>

            <q-select
                :options="optionsMonths"
                borderless
                emit-value
                map-options
                v-model="month"
                @update:model-value="selectedMonthSubmit"
                class="q-mr-sm"
            />
        </div>

        <SummarySchedule
            v-if="isSystemUser"
            :liveEventCount="liveEventCount"
            :meetingCount="meetingCount"
            :nextEventDate="nextEventDate"
            :nextEvent="nextEvent"
        />

        <div class="row q-pb-md q-mt-lg" v-if="isSystemUser || isPartner">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Comercial </div>
            </div>
        </div>

        <SummaryCommercial
            v-if="isSystemUser || isPartner"
            :newStudentsInSelectedMonthCount="newStudentsInSelectedMonthCount"
            :newStudentsInTheMonthBeforeTheSelectedMonthCount="newStudentsInTheMonthBeforeTheSelectedMonthCount"
            :churnRateInSelectedMonth="churnRateInSelectedMonth"
            :churnRateInTheMonthBeforeTheSelectedMonth="churnRateInTheMonthBeforeTheSelectedMonth"
            :totalActiveStudentsCount="totalActiveStudentsCount"
        />

        <div class="row q-pb-md q-mt-lg" v-if="isSystemUser">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Financeiro </div>
            </div>
        </div>

        <SummaryFinancial
            v-if="isSystemUser"
            :valueOfOrdersCanceledInSelectedMonth="valueOfOrdersCanceledInSelectedMonth"
            :valueOfOrdersCanceledInTheMonthBeforeSelectedMonth="valueOfOrdersCanceledInTheMonthBeforeSelectedMonth"
            :valueOfOrdersExpiredInSelectedMonth="valueOfOrdersExpiredInSelectedMonth"
            :valueOfOrdersExpiredInTheMonthBeforeSelectedMonth="valueOfOrdersExpiredInTheMonthBeforeSelectedMonth"
            :valueOfOrdersToBeReceivedInSelectedMonth="valueOfOrdersToBeReceivedInSelectedMonth"
            :valueOfOrdersToBeReceivedInTheMonthBeforeSelectedMonth="valueOfOrdersToBeReceivedInTheMonthBeforeSelectedMonth"
            :valueOfOrdersToBeReceivedToday="valueOfOrdersToBeReceivedToday"
            :valueOfOrdersToBeReceivedYesterday="valueOfOrdersToBeReceivedYesterday"
        />

        <div class="row q-pb-md q-mt-lg" >
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Conteúdos </div>
            </div>
        </div>

        <SummaryContents
            :contentReleasedThisMonth="contentReleasedThisMonth"
            :contentsMostViewed="contentsMostViewed"
            :contentsExpiresIn60Days="contentsExpiresIn60Days"
        />
    </AuthenticatedLayout>
</template>
