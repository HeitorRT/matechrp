<script setup>
    import MainLayout from '@/Layouts/Site/MainLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        service: Object,
    });

    const goBack = () => useForm().get(route('site.services'))
   
</script>

<template>
    <Head title="Serviços"/>

    <MainLayout>
        <div class="row">
            <div class="bg-dark q-mt-xl" style="height: 100px; width: 100%;">
                <q-btn
                    color="white"
                    class="absolute"
                    label="Voltar"
                    style="top: 80px; left: 15%"
                    flat
                    icon="arrow_back"
                    @click="goBack"
                    size="md"
                />

                <div class="fit flex flex-center text-white app-fs-40 app-fw-650">
                    {{ service.title }}
                </div>
            </div>
            <div class="site-container-content">
                <div class="q-pa-md" style="border-radius: 20px;">
                    <div class="row q-my-lg">
                        <div class="col-5 flex flex-center">
                            <div>
                                <!-- <div class="app-fs-36 q-my-lg">
                                    Título
                                </div> -->
                                {{ service.text }}
                            </div>
                        </div>
                        <div class="col"></div>
                        <div class="col-6 q-pa-md flex flex-center">
                            <q-img :src="service.srcImg" height="400px" style="border: 3px solid;">
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
