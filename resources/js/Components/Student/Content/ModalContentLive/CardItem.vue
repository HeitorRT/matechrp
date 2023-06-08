<script setup>
    import { ref } from 'vue';

    const props = defineProps({
        image: String,
        title: String,
        titleRight: String,
        description: String
    });

    const mouseOver = ref(false);
</script>

<template>
    <q-card class="transparent fit" flat>
        <q-card-section
            horizontal
            @mouseover="mouseOver = true"
            @mouseleave="mouseOver = false"
        >
            <q-card-section class="flex flex-center q-px-none">
                <q-img
                    class="app-br-8"
                    :src="image"
                    width="182px"
                    height="112px"
                />
            </q-card-section>

            <q-card-section class="column justify-between q-py-lg full-width">
                <div class="text-white app-fs-19 app-fw-700 app-lh-24 row justify-between">
                    <div>
                        {{ title }}
                    </div>
                    <div>
                        {{ titleRight }}
                    </div>
                </div>
                <div class="text-white app-fs-19 app-fw-400 app-lh-24">
                    {{ description }}
                </div>
            </q-card-section>
        </q-card-section>
    </q-card>
</template>
