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
            <div class="site-container-core bg-dark column flex-center q-mt-xl" style="height: 100px;">
                <div class="text-white app-fs-40 app-fw-650">
                    TELEVISORES E MONITORES
                </div>
            </div>
            <div class="site-container-content">
                <div class="q-pa-md" style="height: 800px; border-radius: 20px;">
                    <div class="row q-my-lg">
                        <div class="col-5 flex flex-center">
                            <div>
                                <div class="app-fs-36 q-my-lg">
                                    Título
                                </div>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                            </div>
                        </div>
                        <div class="col"></div>
                        <div class="col-6 q-pa-md flex flex-center">
                            <q-img :src="services[1].srcImg" height="400px" style="border: 3px solid;">
                            </q-img>
                        </div>
                    </div>
                    <div class="row flex flex-center app-fs-36 q-mb-lg">
                        Recomendações para este serviço
                    </div>
                    <div class="row q-pb-lg justify-center">
                        <div class="col-3 rounded-borders bg-dark text-white text-center q-pa-lg" style="border: 10px solid white;">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        </div>
                        <div class="col-3 rounded-borders bg-dark text-white text-center q-pa-lg q-mx-xl" style="border: 10px solid white;">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        </div>
                        <div class="col-3 rounded-borders bg-dark text-white text-center q-pa-lg" style="border: 10px solid white;">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        </div>
                    </div>
                    <div class="row q-pb-lg justify-center">
                        <div class="col-3 rounded-borders bg-dark text-white text-center q-pa-lg" style="border: 10px solid white;">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        </div>
                        <div class="col-3 rounded-borders bg-dark text-white text-center q-pa-lg q-mx-xl" style="border: 10px solid white;">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        </div>
                        <div class="col-3 rounded-borders bg-dark text-white text-center q-pa-lg" style="border: 10px solid white;">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
