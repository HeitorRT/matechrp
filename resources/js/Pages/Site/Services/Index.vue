<script setup>
    import MainLayout from '@/Layouts/Site/MainLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        services: Object,
    });

    const showService = (service_id) => useForm().get(route('site.services.show', service_id))
   
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
                            v-for="service in props.services"
                            transition="scale"
                            transition-duration="1500"
                            style=" width: 300px"
                            class="bg-white app-br-16"
                        >
                            <q-card flat class="app-br-16" >
                                <q-img :src="service.srcImg" height="250px">
                                    <div class="absolute-bottom text-uppercase text-no-wrap">
                                        <q-icon :name="service.icon" size="xs" class="q-ml-sm"/>

                                        {{ service.title }}
                                    </div>
                                </q-img>
                        
                                <q-card-section style="min-height: 350px">
                                    <div class="text-subtitle2 text-justify"> {{ service.text }} </div>
                                </q-card-section>
                            </q-card>
                        </q-intersection>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
