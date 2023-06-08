<script setup>
    import GuestLayout from '@/Layouts/Student/GuestLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { ref } from 'vue';

    const props = defineProps({
        errors: Object,
        contents: Object
    });


    const goLoginPage = () => useForm().get(route('student.auth.sign-in'))

    const scrollAreaRef = ref(null)
    const count = ref(0);

    setInterval(() => {
        scrollAreaRef.value.setScrollPercentage('horizontal', count.value, 8000)

        if (count.value < 1) {
            count.value += 0.1;
        } else {
            count.value = 0;
        }
    }, 8000)
</script>

<template>
    <GuestLayout>
        <Head title="Seja Bem-vindo" />

        <div class="student-bg-dark q-pb-xl">
            <div class="student-wellcome-banner row items-center justify-center">
                <div class="col-6 q-pa-none">
                </div>

                <div class="col-6 flex items-center justify-start">
                    <q-card
                        class="transparent text-white"
                        flat
                        style="padding: 0 100px;"
                    >
                        <q-card-section class="q-mb-lg">
                            <div class="app-fs-58 app-fw-800 app-lh-72">
                                Título mais ou menos até aqui
                            </div>

                            <div class="app-fs-19 app-fw-500 q-mt-md">
                                Lorem ipsum dolor sit amet consectetur. <br/>
                                Vitae pellentesque amet molestie lorem in urna ac eu imperdiet.
                            </div>
                        </q-card-section>

                        <q-card-section class="row q-col-gutter-sm q-mt-lg  ">
                            <div class="col-12">
                                <q-btn
                                    unelevated
                                    label="Fazer login"
                                    @click="goLoginPage"
                                    padding="10px 24px"
                                    class="app-br-16 app-fs-16 student-bg-purple"
                                />
                            </div>
                        </q-card-section>
                    </q-card>
                </div>
            </div>

            <div class="row items-center justify-center">
                <div class="col-6 flex items-center justify-center">
                    <q-card
                        class="transparent text-white"
                        flat
                        style="padding: 0 100px;"
                    >
                        <q-card-section class="q-mb-lg">
                            <div class="app-fs-58 app-fw-800">
                                Nosso catálogo
                            </div>

                            <div class="app-fs-19 app-fw-500">
                                Lorem ipsum dolor sit amet consectetur. <br/>
                                Vitae pellentesque amet molestie lorem in urna ac eu imperdiet.
                            </div>
                        </q-card-section>
                    </q-card>
                </div>

                <div class="col-6 q-gutter-md">
                    <q-scroll-area
                        style="height: 532px;"
                        :thumb-style="{opacity: 0}"
                        :bar-style="{opacity: 0}"
                        ref="scrollAreaRef"
                    >
                        <div class="row no-wrap q-gutter-md q-px-md">
                            <div
                                v-for="content in contents"
                                :style="{
                                    width: '410px',
                                    height: '532px',
                                    background: `linear-gradient(360deg, rgba(21, 21, 21, 0.8) 0%, rgba(21, 21, 21, 0) 100%), url('${content.image}')`,
                                    backgroundSize: 'cover',
                                    backgroundPosition: 'center'
                                }"
                                class="app-br-16"
                            ></div>
                        </div>
                    </q-scroll-area>
                </div>
            </div>

            <div class="student-wellcome-banner-paris">
            </div>
        </div>
    </GuestLayout>
</template>
