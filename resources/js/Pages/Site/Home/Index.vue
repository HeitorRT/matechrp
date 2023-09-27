<script setup>
    import MainLayout from '@/Layouts/Site/MainLayout.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import { ref } from 'vue';
    import VueHorizontal from "vue-horizontal";

    const props = defineProps({
        services: Object,
        topCarrousel: Array,
        ourProcesses: Array
    });

    const slide = ref(1);
    const autoplay = ref(false);

    const processIndexSelected = ref(null);
</script>

<template>
    <Head title="Home"/>

    <MainLayout>
        <div class="row flex flex-center">
            <div class="col-12 col-md-11 q-py-xl">
                <q-carousel
                    animated
                    swipeable
                    v-model="slide"
                    infinite
                    :autoplay="autoplay"
                    transition-prev="slide-right"
                    transition-next="slide-left"
                    @mouseenter="autoplay = false"
                    @mouseleave="autoplay = true"
                    height="730px"
                    class="bg-grey-9 shadow-5 rounded-borders"
                    ref="carousel"
                >
                    <q-carousel-slide 
                        v-for="item, index in topCarrousel"
                        :name="index" 
                        class="no-padding"
                    >
                        <q-img 
                            class="full-height" 
                            :src="item.image"
                        />
                    </q-carousel-slide>

                    <template v-slot:control>
                        <q-carousel-control
                            position="left"
                            :offset="[-30, 300]"
                        >
                            <q-btn
                                color="white"
                                padding="none"
                                flat
                                dense
                                @click="$refs.carousel.previous()"
                                unelevated
                                style="padding-right: 0px; !important"
                            >
                                <q-icon name="sym_o_chevron_left" size="150px"/>
                            </q-btn>
                        </q-carousel-control>

                        <q-carousel-control
                            position="right"
                            :offset="[-30, 300]"
                        >
                            <q-btn
                                color="white"
                                padding="none"
                                flat
                                dense
                                @click="$refs.carousel.next()"
                                unelevated
                            >
                                <q-icon name="sym_o_chevron_right" size="150px"/>
                            </q-btn>
                        </q-carousel-control>
                    </template>
                </q-carousel>
            </div>
        </div>
        
        <div class="row flex flex-center app-my-100 bg-dark">
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

        <div class="site-container-core q-py-xl q-my-xl">
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

                        <q-card-section class="q-px-lg">
                            <div class="q-py-lg app-fs-15 app-fw-200 text-center">
                                {{ process.text }}
                            </div>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
        </div>

        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3720.180727096364!2d-47.815704499999995!3d-21.1849784!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94b9beeefdb26e87%3A0x482ff78f8b66942b!2sR.%20Visc.%20de%20Inha%C3%BAma%2C%201657%20-%20Jardim%20Sumare%2C%20Ribeir%C3%A3o%20Preto%20-%20SP%2C%2014025-100!5e0!3m2!1spt-BR!2sbr!4v1695839067832!5m2!1spt-BR!2sbr" 
            allowfullscreen="" 
            style="width: 100%; height: 700px;"
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade"
        >
        </iframe>
    </MainLayout>
</template>
