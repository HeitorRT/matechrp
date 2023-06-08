<script setup>
    import { ref } from 'vue';
    import Item from '@/Components/Student/Content/Item.vue';

    const props = defineProps({
        title: String,
        items: Array
    });

    const overIndex = ref();

    const show = (title) => {
        alert(title)
    }
</script>

<template>
    <div class="q-mb-xl q-mt-xl">
        <div
            class="text-white app-fw-700 app-fs-27 app-lh-32 q-mb-md">
            {{ title ?? 'Items' }}
        </div>

        <div class="row">
            <div class="q-mb-md" v-for="(item, index) in items" :key="index">
                <Item
                    :item="item"
                    class="search-content-cards"
                />
            </div>
        </div>
    </div>
</template>
