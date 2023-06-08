<script setup>
    import { computed } from 'vue';

    const props = defineProps({
        title: String,
        imageUrl: String
    });

    const styleBackgroundImageCourseCard = computed(() => ({
        height: '747px',
        backgroundSize: 'cover',
        backgroundImage: `linear-gradient(to bottom, #ffffff00 80%, #151515 100%), url('${props.imageUrl}')`
    }));
</script>

<template>
     <div
        :style="styleBackgroundImageCourseCard"
        class="app-br-16 flex items-end"
    >
        <div class="flex full-width justify-between q-mb-xl q-px-lg">
            <div class="text-white app-fw-700 app-fs-27 app-lh-32 q-mb-md q-ml-lg">
                {{ title }}
            </div>

            <q-btn
                unelevated
                class="app-br-16 student-bg-purple text-white"
                padding="8px 24px"
            >
                <q-icon name="o_shopping_cart" size="lg" class="q-ml-sm"/>

                <div class="text-caption q-mx-sm app-fw-600 app-fs-16 app-lh-16">
                    Comprar
                </div>
            </q-btn>
        </div>
    </div>
</template>
