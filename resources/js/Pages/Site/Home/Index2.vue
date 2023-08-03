<script setup>
    import MainLayout from '@/Layouts/Site/MainLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { ref, computed } from 'vue';
    import VueHorizontal from "vue-horizontal";

    const slide = ref(1);
    const autoplay = ref(false);

    const services = computed(() => [{
        id: 1,
        title: 'TELEVISORES E MONITORES',
        text: 'Conserto de TVs LED, LCD e Plasma. Atendemos: Samsung, LG, AOC, Philips e mais.',
        srcImg: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTsKEby5TqpefnA9W9HynmMfxyxZLob_9nubA&usqp=CAU',
        icon: 'desktop_windows'
    }, {
        id: 2,
        title: 'NOTEBOOKS E DESKTOPS',
        text: 'Formatação, limpeza e assistência completa para seu notebook ou desktop.',
        srcImg: 'https://c4.wallpaperflare.com/wallpaper/645/332/956/notebook-service-wallpaper-preview.jpg',
        icon: 'devices'
    }, {
        id: 3,
        title: 'Limpeza',
        text: 'A limpeza e a troca de pasta térmica são fundamentais para garantir a vida útil e o bom funcionamento da sua máquina.',
        srcImg: 'https://static.wixstatic.com/media/1d9c31_e1357a383f63495e8633c0292a311443~mv2.jpg/v1/fill/w_517,h_509,al_c,lg_1,q_80,enc_auto/sdfc-758x424.jpg',
        icon: 'cleaning_services'
    }, {
        id: 4,
        title: 'Upgrades de componentes',
        text: 'Realizamos upgrades em sua máquina, como a troca de HDD por SSD, aumento de memória RAM e substituição de placas de vídeo.',
        srcImg: 'https://static.wixstatic.com/media/1d9c31_9c4ced0f6e304762aae138c5e32677cd~mv2.webp',
        icon: 'trending_up'
    }, {
        id: 5,
        title: 'Soluções para de notebook',
        text: 'Realizamos a troca e reparos de teclados, telas, touchpads e carcaças de notebooks.',
        srcImg: 'https://media.istockphoto.com/id/182470801/photo/smashed-laptop.jpg?s=612x612&w=0&k=20&c=LgJIhsvkMvIn08NES-G7lbM5zj8yrSTevoFoQkauWB4=',
        icon: 'laptop_windows'
    }, {
        id: 6,
        title: ' Montagem de pc gamer',
        text: 'Você tem a opção de trazer suas próprias peças para montagem ou adquirir uma build personalizada conosco.',
        srcImg: 'https://static.wixstatic.com/media/1d9c31_325b8e5c53b34b74a19f6cd6365481b3~mv2.webp',
        icon: 'sports_esports'
    }])

    // const showService = () => useForm().get(route('admin.content.titles.show', props.content.id))
    // const showService = () => useForm().get(route('admin.content.index'))

    const mouseOverIndex = ref(null);
</script>

<template>
    <Head title="Home"/>

    <MainLayout>
        <div class="row flex flex-center">
            <div class="col-11 q-py-xl">
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
                    <q-carousel-slide :name="1" class="no-padding">
                        <q-img class="col-12 full-height" src="https://images.unsplash.com/photo-1614624532983-4ce03382d63d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8c2V0dXB8ZW58MHx8MHx8fDA%3D&w=1000&q=80" />
                    </q-carousel-slide>  

                    <q-carousel-slide :name="2" class="no-padding">
                        <q-img class="col-12 full-height" src="https://images.unsplash.com/photo-1542315192-1f61a1792f33?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" />
                    </q-carousel-slide>   

                    <q-carousel-slide :name="3" class="no-padding">
                        <q-img class="col-12 full-height" src="https://images.unsplash.com/photo-1590212151175-e58edd96185b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80" />
                    </q-carousel-slide>    

                    <q-carousel-slide :name="4" class="no-padding">
                        <q-img class="col-12 full-height" src="https://images.unsplash.com/photo-1594636797501-ef436e157819?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" />
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
            <div class="col-11 app-br-16">
                <div class="flex flex-center text-white app-fs-30 app-fw-650 q-mt-xl q-mb-xl">
                    Serviços
                </div>
                <div class="row flex flex-center">
                    <div class="col-11 q-mb-xl" style="max-width: 100vw">
                        <VueHorizontal :button-between="false">
                            <div v-for="(service, index) in services" :key="index">
                                <div style="margin: 0 24px 0 0;">
                                    <div
                                        class="site-img-hover-zoom cursor-pointer app-br-16"
                                        @mouseover="mouseOverIndex = index"
                                        @mouseleave="mouseOverIndex = null"
                                    >
                                        <q-img
                                            :src="service.srcImg"
                                            class="app-br-16"
                                            width="373px"
                                            height="500px"
                                        >
                                            <div class="absolute-full text-subtitle2 flex flex-center" :class="{ transparent: mouseOverIndex != index }">
                                                <div class="flex flex-center" v-if="mouseOverIndex == index">
                                                    <div class="q-mr-sm app-fs-14 text-uppercase">
                                                        Ver mais
                                                    </div>

                                                    <q-icon name="arrow_right_alt" size="xs"/>
                                                </div>
                                            </div>
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
            </div>
        </div>
        
        <div class="row flex flex-center">
            <div class="col-11 q-mb-xl">
                <div class="flex flex-center app-fs-30 app-fw-650 q-mb-xl">
                    Nossos processos
                </div>
                <div class="row flex flex-center">
                    <div class="col-3 app-mx-60" style="height: 500px;">
                        <div class="rounded-borders bg-white flex flex-center" style="border: 1px solid;">
                            <div class="app-fs-19 app-fw-650 q-pt-md">
                                Como solicitar orçamento
                            </div>
                            <div class="app-mx-40 q-py-lg">
                                <div class="app-fs-15 app-fw-200">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tincidunt nibh eget porta rhoncus. Vestibulum egestas vel nibh pretium dictum. Ut consequat ligula neque, non pulvinar ipsum blandit sed. Mauris sit amet nunc magna. Aenean sed volutpat ligula. Morbi gravida orci in nisl finibus rhoncus. Sed facilisis eros non justo imperdiet, id aliquam neque sagittis. Aliquam euismod sollicitudin lorem at mattis.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 app-mx-60" style="height: 500px;">
                        <div class="rounded-borders bg-white flex flex-center" style="border: 1px solid;">
                            <div class="app-fs-19 app-fw-650 q-pt-md">
                                Como solicitar orçamento
                            </div>
                            <div class="app-mx-40 q-py-lg">
                                <div class="app-fs-15 app-fw-200">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tincidunt nibh eget porta rhoncus. Vestibulum egestas vel nibh pretium dictum. Ut consequat ligula neque, non pulvinar ipsum blandit sed. Mauris sit amet nunc magna. Aenean sed volutpat ligula. Morbi gravida orci in nisl finibus rhoncus. Sed facilisis eros non justo imperdiet, id aliquam neque sagittis. Aliquam euismod sollicitudin lorem at mattis.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 app-mx-60" style="height: 500px;">
                        <div class="rounded-borders bg-white flex flex-center" style="border: 1px solid;">
                            <div class="app-fs-19 app-fw-650 q-pt-md">
                                Como solicitar orçamento
                            </div>
                            <div class="app-mx-40 q-py-lg">
                                <div class="app-fs-15 app-fw-200">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tincidunt nibh eget porta rhoncus. Vestibulum egestas vel nibh pretium dictum. Ut consequat ligula neque, non pulvinar ipsum blandit sed. Mauris sit amet nunc magna. Aenean sed volutpat ligula. Morbi gravida orci in nisl finibus rhoncus. Sed facilisis eros non justo imperdiet, id aliquam neque sagittis. Aliquam euismod sollicitudin lorem at mattis.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row flex flex-center bg-dark q-py-xl">
            <iframe 
                class="col-11"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6326.896027282484!2d-46.64570939219926!3d-23.598067506081108!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce5a264d6b6611%3A0xae18ff6a2797997b!2sHospital%20S%C3%A3o%20Paulo!5e1!3m2!1spt-BR!2sbr!4v1690757710215!5m2!1spt-BR!2sbr" 
                style="border:0; height: 700px;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade"
            >
            </iframe>
        </div>
    </MainLayout>
</template>
