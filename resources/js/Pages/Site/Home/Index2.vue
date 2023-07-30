<script setup>
    import MainLayout from '@/Layouts/Site/MainLayout.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import { ref } from 'vue';

    const slide = ref(1);
    const autoplay = ref(false);

</script>

<template>
    <Head title="Home"/>

    <MainLayout>
        <div class="row flex flex-center">
            <div class="col-11 q-py-lg">
                <q-carousel
                    animated
                    swipeable
                    v-model="slide"
                    arrows
                    infinite
                    :autoplay="autoplay"
                    transition-prev="slide-right"
                    transition-next="slide-left"
                    @mouseenter="autoplay = false"
                    @mouseleave="autoplay = true"
                    height="730px"
                    class="bg-grey-9 shadow-5 rounded-borders"
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
                                
                </q-carousel>
            </div>
        </div>
        
        <div class="row flex flex-center">
            <div class="col-11 q-px-lg q-py-lg q-mb-xl">
                <div class="flex flex-center app-fs-30 app-fw-650 q-mt-xl q-mb-md">
                    Serviços
                </div>
                <div class="row flex flex-center ">
                    <div class="col-3 app-mx-30">
                        <q-card flat bordered>
                            <q-img
                                src="https://img.ibxk.com.br/2021/12/22/22114318707193.jpg?ims=328x"
                                style="height: 500px;"
                            />
                            <q-card-section class="flex flex-center">
                                <div class="text-h5 q-mt-sm">Limpeza Personalizada</div>
                            </q-card-section>

                            <q-card-actions class="flex flex-center">
                                <q-btn flat color="primary" label="Ver mais" @click="" />
                            </q-card-actions>
                        </q-card>
                    </div>
                    <div class="col-3 app-mx-30">
                        <q-card  flat bordered>
                            <q-img
                                src="https://img.ibxk.com.br/2021/12/22/22114318707193.jpg?ims=328x"
                                style="height: 500px;"
                            />
                            <q-card-section class="flex flex-center">
                                <div class="text-h5 q-mt-sm">Limpeza Personalizada</div>
                            </q-card-section>

                            <q-card-actions class="flex flex-center">
                                <q-btn flat color="primary" label="Ver mais" @click="" />
                            </q-card-actions>
                        </q-card>
                    </div>
                    <div class="col-3 app-mx-30">
                        <q-card  flat bordered>
                            <q-img
                                src="https://img.ibxk.com.br/2021/12/22/22114318707193.jpg?ims=328x"
                                style="height: 500px;"
                            />
                            <q-card-section class="flex flex-center">
                                <div class="text-h5 q-mt-sm">Limpeza Personalizada</div>
                            </q-card-section>

                            <q-card-actions class="flex flex-center">
                                <q-btn flat color="primary" label="Ver mais" @click="" />
                            </q-card-actions>
                        </q-card>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row flex flex-center">
            <div class="col-11 q-px-lg q-py-lg q-mb-xl">
                <div class="flex flex-center app-fs-30 app-fw-650 q-mt-xl q-mb-md">
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
    </MainLayout>
</template>
