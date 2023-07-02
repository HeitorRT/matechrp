<script setup>
    import MainLayout from '@/Layouts/Site/MainLayout.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import { ref } from 'vue';

    const slide = ref(1);
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
                    class="bg-grey-9 shadow-2 no-padding"
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
            <div class="col-12 bg-blue-grey-10" style="height: 500px;">

            </div>
        </div>

    </MainLayout>
</template>
