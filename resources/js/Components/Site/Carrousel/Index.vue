<script setup>
    import VueHorizontal from "vue-horizontal";

    const props = defineProps({
        title: String,
        has_image: Boolean,
        image: String,
        items: Array
    });

    const imageSrc = (image) => {
        if (image == null) {
            return '';
        }

        return (typeof image === 'object') ? URL.createObjectURL(image) : image;
    };
</script>

<template>
    <div class="q-mb-xl" style="max-width: 100vw">
        <div
            class="text-white app-fw-700 app-fs-27 app-lh-32 q-mb-md"
            style="margin-left: 104px;"
        >
            {{ title ?? 'Items' }}
        </div>

        <VueHorizontal :button-between="false">
            <div v-for="(item, index) in items" :key="index">
                <div :style="{ margin: index == 0 ? '0 24px 0 104px' : '0 24px 0 0' }">
                    <slot
                        name="item"
                        :item="item"
                    >
                    </slot>
                </div>
            </div>

            <template v-slot:btn-next>
                <q-btn
                    round
                    dense
                    flat
                    color="white"
                    class="q-mr-lg"
                >
                    <q-icon name="chevron_right" size="40px" />
                </q-btn>
            </template>

            <template v-slot:btn-prev>
                <q-btn
                    round
                    dense
                    flat
                    color="white"
                    class="q-ml-lg"
                >
                    <q-icon name="chevron_left" size="40px" />
                </q-btn>
            </template>
        </VueHorizontal>

        <div v-if="has_image">
            <q-img
                :src="imageSrc(image)"
                style="height: 400px"
                class="q-mt-lg"
            />
        </div>
    </div>
</template>
