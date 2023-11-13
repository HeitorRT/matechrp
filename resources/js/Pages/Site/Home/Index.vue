<script setup>
    import MainLayout from '@/Layouts/Site/MainLayout.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import { ref, computed } from 'vue';
    import VueHorizontal from "vue-horizontal";
    import { useQuasar } from 'quasar'

    const props = defineProps({
        services: Object,
        topCarrouselImage: String,
        ourProcesses: Array
    });

    const processIndexSelected = ref(null);

    const $q = useQuasar()

    const isComputer = computed(() => $q.screen.gt.sm)
    const isMobile = computed(() => $q.screen.lt.md)

</script>

<template>
    <Head title="Home"/>

    <MainLayout>
        <div class="row flex flex-center">
            <div 
                class="col-12 col-md-11 q-py-xl" 
                :class="{
                    'q-px-lg': isMobile
                }"
            >
                <q-img 
                    :height="isComputer? '730px' : '350px'"
                    class="bg-white shadow-5 rounded-borders"
                    :src="topCarrouselImage"
                    fit="contain"
                />
            </div>
        </div>
        
        <div class="row flex flex-center bg-dark">
            <div class="col-12 flex flex-center text-white app-fs-30 app-fw-650 q-mt-xl q-mb-xl">
                Serviços
            </div>

            <div class="col-11 q-mb-xl">
                <VueHorizontal :button-between="false">
                    <div v-for="(service, index) in props.services" :key="index">
                        <div style="margin: 0 24px 0 0;">
                            <div
                                class="  app-br-16"
                            >
                                <q-img
                                    :src="service.srcImg"
                                    class="app-br-16"
                                    width="373px"
                                    height="500px"
                                >
                                    <div class="absolute-bottom text-uppercase text-no-wrap">
                                        <q-icon :name="service.icon" size="xs" class="q-ml-sm"/>

                                        {{ service.title }}
                                    </div>
                                </q-img>
                            </div>
                        </div>
                    </div>

                    <template v-slot:btn-next>
                        <q-btn
                            round
                            dense
                            flat
                            color="white"
                            class="q-mr-lg"
                        >
                            <q-icon name="chevron_right" size="40px" />
                        </q-btn>
                    </template>

                    <template v-slot:btn-prev>
                        <q-btn
                            round
                            dense
                            flat
                            color="white"
                            class="q-ml-lg"
                        >
                            <q-icon name="chevron_left" size="40px" />
                        </q-btn>
                    </template>
                </VueHorizontal>
            </div>
        </div>

        <div class="site-container-core q-py-xl q-mb-xl">
            <div class="flex flex-center app-fs-30 app-fw-650 q-mb-xl">
                Nossos processos
            </div>

            <div class="row q-col-gutter-md">
                <div 
                    class="col-12 col-md-3"
                    v-for="process, index in ourProcesses"
                    @mouseover="processIndexSelected = index"
                    @mouseleave="processIndexSelected = null"
                >
                    <q-card 
                        style="min-height: 300px; height: 300px;"
                        class="app-br-16"
                        :class="{
                            'shadow-10': processIndexSelected == index,
                        }"
                    >
                        <q-card-section class="bg-grey-2">
                            <div class="app-fs-19 app-fw-650 text-center"> 
                                {{ process.title }}
                            </div>
                        </q-card-section>

                        <q-card-section>
                            <div 
                                class="q-py-lg app-fs-15 app-fw-200"
                                :class="process.class"
                            >
                                <span v-html="process.text"></span>
                            </div>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
        </div>

        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14880.722908385456!2d-47.8157045!3d-21.1849784!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94b9bfaea1033077%3A0x4b50c1b45431ea7c!2sMATECH%20RP!5e0!3m2!1spt-BR!2sbr!4v1699388921008!5m2!1spt-BR!2sbr" 
            style="border:0; width: 100%; height: 700px;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade"
        >
        </iframe>

        <div class="site-container-core-secondary q-py-xl">
            <div class="row flex items-start justify-center">
                <div 
                    class="col-12 col-md-2" 
                    :class="{
                        'q-mb-lg': isMobile
                    }"
                >
                    <span class="text-h5 text-bold">Quem somos</span><br><br>
                    <span>A Matech RP é uma empresa que atua no segmento de informática em Ribeirão Preto, com manutenção e venda de periféricos.</span>
                </div>
                <q-separator color="black" class="q-mx-xl" vertical v-if="isComputer" />

                <div 
                    class="col-12 col-md-2" 
                    :class="{
                        'q-mb-lg': isMobile
                    }"
                >
                    <span class="text-h5 text-bold">Visão</span><br><br>
                    <span>Ser uma Empresa que entenda e principalmente, atenda às necessidades de seus clientes, facilitando e acrescentando seu domínio na área de Informática, buscando desta forma, sempre aprimorar suas técnicas.</span>
                </div>
                <q-separator color="black" class="q-mx-xl" vertical v-if="isComputer" />

                <div 
                    class="col-12 col-md-2" 
                    :class="{
                        'q-mb-lg': isMobile
                    }"
                >
                    <span class="text-h5 text-bold">Valores</span><br><br>
                    <span>Trabalhar de maneira ética, transparente, honesta, ambiental e socialmente correta.</span>
                </div>
                <q-separator color="black" class="q-mx-xl" vertical v-if="isComputer" />
                
                <div 
                    class="col-12 col-md-2" 
                    :class="{
                        'q-mb-lg': isMobile
                    }"
                >
                    <span class="text-h5 text-bold">Missão</span><br><br>
                    <span>Buscamos atuar com excelência nos setores de Informática, oferecer atendimento e serviços de qualidade tanto para pessoa física ou jurídica, garantindo tranquilidade e satisfação aos nossos clientes.</span>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
