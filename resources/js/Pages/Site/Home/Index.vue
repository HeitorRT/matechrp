<script setup>
    import MainLayout from '@/Layouts/Site/MainLayout.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import { ref } from 'vue';

    const slide = ref(1);
    const autoplay = ref(true);
</script>

<template>
    <Head title="Home"/>

    <MainLayout>

        <div>
            <q-carousel
                animated
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
            >
                <q-carousel-slide :name="1">
                    <div class="row fit justify-center">
                        <q-img class="rounded-borders col-6 full-height" src="https://images.unsplash.com/photo-1614624532983-4ce03382d63d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8c2V0dXB8ZW58MHx8MHx8fDA%3D&w=1000&q=80" />
                    </div>
                </q-carousel-slide>   
                <q-carousel-slide :name="2">
                    <div class="row fit justify-center">
                        <q-img class="rounded-borders col-6 full-height" src="https://images.unsplash.com/photo-1614179924047-e1ab49a0a0cf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8Z2FtaW5nJTIwc2V0dXB8ZW58MHx8MHx8fDA%3D&w=1000&q=80" />
                    </div>
                </q-carousel-slide>   
                <q-carousel-slide :name="3">
                    <div class="row fit justify-center">
                        <q-img class="rounded-borders col-6 full-height" src="https://i.ytimg.com/vi/lgNeo7evtzk/maxresdefault.jpg" />
                    </div>
                </q-carousel-slide>                
            </q-carousel>
        </div>

    </MainLayout>
</template>
