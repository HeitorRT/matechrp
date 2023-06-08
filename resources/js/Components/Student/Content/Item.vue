<script setup>
    import { ref } from 'vue';
    import ModalContentLive from '@/Components/Student/Content/ModalContentLive/Index.vue';

    const props = defineProps({
        item: Object
    });

    const mouseOver = ref(false);

    const showModalContentLive = ref(false);

    const show = (title) => {
        showModalContentLive.value = true
    }
</script>

<template>
    <div>
        <div
            class="student-img-hover-zoom cursor-pointer app-br-16"
            @mouseover="mouseOver = true"
            @mouseleave="mouseOver = false"
            @click="show(item.name)"
        >
            <q-img
                :src="item.image"
                class="app-br-16"
                width="265px"
                height="370px"
            >
                <div class="absolute-full text-subtitle2 flex flex-center transparent">
                    <q-icon
                        name="lens"
                        size="44px"
                        color="white"
                        v-if="mouseOver"
                        class="absolute"
                    />

                    <q-icon
                        name="play_arrow"
                        size="30px"
                        color="black"
                        v-if="mouseOver"
                        class="absolute"
                    />
                </div>
            </q-img>
        </div>

        <div class="text-white app-fw-700 app-fs-16 app-lh-24 q-mt-md">
            {{ item.name }}
        </div>

        <div class="text-white app-fw-440 app-fs-16 app-lh-24 q-mt-sm">
            {{ item.count_seasons ? `${item.count_seasons} temporadas` : 'Filme' }}
        </div>

        <ModalContentLive
            :content="item"
            :show="showModalContentLive"
            v-on:close="(e) => showModalContentLive = e"
        />
    </div>
</template>
