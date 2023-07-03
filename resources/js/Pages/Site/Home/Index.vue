<script setup>
    import MainLayout from '@/Layouts/Site/MainLayout.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import { ref } from 'vue';

    const slide = ref(1);
    const slide2 = ref(1);
    const autoplay = ref(false);
    const controlType = ref('push');

</script>

<template>
    <Head title="Home"/>

    <MainLayout>

        <div class="row">
            <div class="col-12">
                <q-carousel
                    animated
                    swipeable
                    v-model="slide"
                    infinite
                    :autoplay="autoplay"
                    arrows
                    transition-prev="slide-right"
                    transition-next="slide-left"
                    @mouseenter="autoplay = false"
                    @mouseleave="autoplay = true"
                    height="500px"
                    control-color="blue-grey-10"
                    :control-type="controlType"
                    class="bg-grey-9"
                >
                    <q-carousel-slide :name="1" class="no-padding">
                        <!-- <div class="row fit justify-center"> -->
                            <q-img class="rounded-borders col-11 full-height" src="https://images.unsplash.com/photo-1614624532983-4ce03382d63d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8c2V0dXB8ZW58MHx8MHx8fDA%3D&w=1000&q=80" />
                        <!-- </div> -->
                    </q-carousel-slide>   
                    <q-carousel-slide :name="2" class="no-padding">
                        <!-- <div class="row fit justify-center"> -->
                            <q-img class="rounded-borders col-11 full-height" src="https://images.unsplash.com/photo-1542315192-1f61a1792f33?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" />
                        <!-- </div> -->
                    </q-carousel-slide>   
                    <q-carousel-slide :name="3" class="no-padding">
                        <!-- <div class="row fit justify-center"> -->
                            <q-img class="rounded-borders col-11 full-height" src="https://images.unsplash.com/photo-1590212151175-e58edd96185b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80" />
                        <!-- </div> -->
                    </q-carousel-slide>      
                    <q-carousel-slide :name="4" class="no-padding">
                        <!-- <div class="row fit justify-center"> -->
                            <q-img class="rounded-borders col-11 full-height" src="https://images.unsplash.com/photo-1594636797501-ef436e157819?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" />
                        <!-- </div> -->
                    </q-carousel-slide>               
                </q-carousel>
            </div>
        </div>

        <div class="row">
            <div class="col-6 bg-dark">
                <div class="flex flex-center bg-danger text-white app-fs-30 app-fw-650 q-pt-lg">
                    Serviços
                </div>
                <q-carousel
                    animated
                    swipeable
                    v-model="slide2"
                    infinite
                    :autoplay="autoplay"
                    transition-prev="slide-right"
                    transition-next="slide-left"
                    @mouseenter="autoplay = false"
                    @mouseleave="autoplay = true"
                    height="550px"
                    class="bg-dark q-py-xl q-px-md"
                    ref="carousel"
                >
                    <q-carousel-slide :name="1" class="column no-wrap no-padding ">
                        <div class="row fit justify-center items-center q-gutter-sm q-col-gutter no-wrap">
                            <q-img class="rounded-borders col-6 full-height" src="https://cdn.quasar.dev/img/mountains.jpg" />
                            <q-img class="rounded-borders col-6 full-height" src="https://cdn.quasar.dev/img/parallax1.jpg" />
                        </div>
                    </q-carousel-slide>   
                    
                    <q-carousel-slide :name="2" class="column no-wrap no-padding">
                        <div class="row fit justify-center items-center q-gutter-sm q-col-gutter no-wrap">
                            <q-img class="rounded-borders col-6 full-height" src="https://cdn.quasar.dev/img/parallax2.jpg" />
                            <q-img class="rounded-borders col-6 full-height" src="https://cdn.quasar.dev/img/quasar.jpg" />
                        </div>
                    </q-carousel-slide>

                    <q-carousel-slide :name="3" class="column no-wrap no-padding">
                        <div class="row fit justify-center items-center q-gutter-sm q-col-gutter no-wrap">
                            <q-img class="rounded-borders col-6 full-height" src="https://cdn.quasar.dev/img/cat.jpg" />
                            <q-img class="rounded-borders col-6 full-height" src="https://cdn.quasar.dev/img/linux-avatar.png" />
                        </div>
                    </q-carousel-slide>

                    <q-carousel-slide :name="4" class="column no-wrap no-padding">
                        <div class="row fit justify-center items-center q-gutter-sm q-col-gutter no-wrap">
                            <q-img class="rounded-borders col-6 full-height" src="https://cdn.quasar.dev/img/material.png" />
                            <q-img class="rounded-borders col-6 full-height" src="https://cdn.quasar.dev/img/donuts.png" />
                        </div>
                    </q-carousel-slide>

                    <template v-slot:control>

                        <q-carousel-control
                            position="bottom-left"
                            :offset="[25, 60]"
                            class="q-gutter-xs"
                        >
                        <q-btn
                            push round dense color="blue-grey" text-color="white" icon="arrow_left"
                            @click="$refs.carousel.previous()"
                        />
                        <q-btn
                            push round dense color="blue-grey" text-color="white" icon="arrow_right"
                            @click="$refs.carousel.next()"
                        />
                        </q-carousel-control>
                    </template>            
                </q-carousel>

            </div>       


            <div class="col-6 bg-dark">
                <div class="flex flex-center">

                </div>
                <div class="flex flex-center text-white app-fs-30 app-fw-650 q-pt-lg">
                    Assistências Autorizadas
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 bg-red-14" style="height: 500px;">

            </div>
        </div>
    </MainLayout>
</template>
