<script setup>
    import MainLayout from '@/Layouts/Site/MainLayout.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import { ref, computed } from 'vue'

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

    const showService = () => useForm().get(route('admin.content.titles.show', props.content.id))
   
</script>

<template>
    <Head title="Serviços"/>

    <MainLayout>
        <div class="row">
            <div class="site-container-core bg-blue column justify-end q-pb-xl" style="height: 300px;">
                <div class="text-white app-fs-40 app-fw-650">
                    Serviços
                </div>

                <div class="text-white app-fs-18 q-mt-lg">
                    A MatechRP é especializada na manutenção e conserto de televisores, monitores, notebooks, computadores, upgrades e montagem.
                </div>
            </div>

            <div class="site-container-core q-py-xl">
                <div class="q-pa-md">
                    <div class="row justify-center q-gutter-md">
                        <q-intersection
                            v-for="service in services"
                            transition="scale"
                            transition-duration="1500"
                            style=" width: 300px"
                            class="bg-white app-br-16"
                        >
                            <q-card flat class="app-br-16">
                                <q-img :src="service.srcImg" height="250px">
                                    <div class="absolute-bottom text-uppercase text-no-wrap">
                                        <q-icon :name="service.icon" size="xs" class="q-ml-sm"/>

                                        {{ service.title }}
                                    </div>
                                </q-img>
                        
                                <q-card-section style="height: 130px;">
                                    <div class="text-subtitle2"> {{ service.text }} </div>
                                </q-card-section>

                                <q-card-section class="q-pa-none">
                                    <q-btn
                                        @click="showService(service.id)"
                                        color="blue"
                                        class="full-width app-br-br-16 app-br-bl-16"
                                        flat
                                    >
                                        <div class="q-mr-sm app-fs-14">
                                            Ver mais 
                                        </div>

                                        <q-icon name="arrow_right_alt" size="xs"/>
                                    </q-btn>
                                </q-card-section>
                            </q-card>
                        </q-intersection>
                    </div>
            </div>
            </div>
        </div>
    </MainLayout>
</template>
