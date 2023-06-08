 <script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm, usePage } from '@inertiajs/inertia-vue3';
    import { useQuasar, date } from 'quasar'
    import { ref, computed } from 'vue'

    const $q = useQuasar();

    const props = defineProps({
        liveEvent: Object,
        errors: Object,
    });

    const imageForDoc = 'https://i.pinimg.com/564x/04/54/7c/04547c2b354abb70a85ed8a2d1b33e5f.jpg';

    const toggleLaunchOffer = () => {
        useForm().put(route('admin.live-event.toggle-offer-availability', props.liveEvent.id), {
            preserveScroll: true,
            onSuccess: () => {
                let action = props.liveEvent.offer_available ? 'liberada' : 'encerrar';

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

    const calculateTimeClassStarted = () => {
        let dateMatch = props.liveEvent.start_at.match(/(\d\d)\/(\d\d)\/(\d\d\d\d) (\d\d):(\d\d)/)

        let dateStarted = date.buildDate({
            year: dateMatch[3],
            month: dateMatch[2],
            day: dateMatch[1],
            hours: dateMatch[4],
            minutes: dateMatch[5],
            seconds: 0,
        });

        return date.getDateDiff(Date.now(), dateStarted, 'seconds');
    }

    const timeClassStarted = ref(calculateTimeClassStarted());

    const timeClassStartedtoString = computed(() => {
        return timeClassStarted.value > 0 ? new Date(timeClassStarted.value * 1000).toISOString().slice(11, 19) : '00:00:00';
    })

    const checkIfNowItIsBiggerEndAt = () => {
        let dateMatch = props.liveEvent.end_at.match(/(\d\d)\/(\d\d)\/(\d\d\d\d) (\d\d):(\d\d)/)

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
    const showTimerAndBtnOffer = computed(() => timeClassStarted.value > 0 && !nowItIsBiggerEndAt.value);

    let intervalTimeStart = setInterval(() => {
        nowItIsBiggerEndAt.value = checkIfNowItIsBiggerEndAt();

        if (nowItIsBiggerEndAt.value) {
            clearInterval(intervalTimeStart);
        } else {
            timeClassStarted.value = calculateTimeClassStarted();
        }
    }, 1000);
</script>

<template>
    <AuthenticatedLayout>
        <Head :title="liveEvent.name" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> {{ liveEvent.name }} </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Eventos ao vivo" class="text-grey"/>
                    <q-breadcrumbs-el :label="liveEvent.name" class="text-primary" />
                </q-breadcrumbs>
            </div>

            <div class="col-12 col-md-6 flex justify-end items-center">
                <q-btn
                    :color="liveEvent.offer_available ? 'warning' : 'primary'"
                    color="primary"
                    rounded
                    no-caps
                    @click="toggleLaunchOffer"
                    v-if="showTimerAndBtnOffer && liveEvent.has_live_offer"
                    unelevated
                >
                    <q-icon :name="liveEvent.offer_available ? 'money_off' : 'attach_money'" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        {{ liveEvent.offer_available ? "Encerrar oferta" : "Liberar oferta" }}
                    </div>
                </q-btn>

                <div
                    class="q-mx-md text-primary"
                    v-if="showTimerAndBtnOffer"
                >
                    {{ timeClassStartedtoString }}
                </div>

                <div
                    class="q-mx-md text-red app-fw-600"
                    v-if="nowItIsBiggerEndAt"
                >
                    Finalizado
                </div>
            </div>
        </div>

        <div class="bg-white q-py-lg q-px-lg app-br-16">
            <div class="row q-col-gutter-lg">
                <div class="col-12" v-if="liveEvent.embed">
                    <div
                        v-html="liveEvent.embed"
                        class="app-player-iframe"
                    ></div>
                </div>

                <div class="col-12 items-center q-mt-xs" v-if="liveEvent.has_live_offer">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Oferta
                    </div>
                </div>

                <div class="col-12 col-md-5" v-if="liveEvent.has_live_offer">
                    <q-input
                        outlined
                        v-model="liveEvent.name_offer"
                        label="Nome da oferta"
                        disable
                    />
                </div>

                <div class="col-12 col-md-7" v-if="liveEvent.has_live_offer">
                    <q-input
                        outlined
                        v-model="liveEvent.embed_offer"
                        label="Link da oferta"
                        disable
                    />
                </div>

                <div class="col-12" v-if="liveEvent.has_live_offer">
                    <q-input
                        outlined
                        v-model="liveEvent.description_offer"
                        label="Descrição da oferta"
                        disable
                    />
                </div>

                <div class="col-12 items-center" v-if="liveEvent.materials.length > 0">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Material
                    </div>
                </div>

                <div class="col-12 col-md-3"
                    v-for="(material, index) in liveEvent.materials"
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
