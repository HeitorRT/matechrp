<script setup>
    import { ref, onMounted } from 'vue';

    const props = defineProps({
        items: Array,
        time: {
            type: Number,
            default: 10000
        },
    });

    const indexSelected = ref(0);

    const previousContent = () => {
        indexSelected.value--;

        if (indexSelected.value < 0) {
            indexSelected.value = props.items.length - 1;
        }
    }

    const nextContent = () => {
        indexSelected.value++;

        if (indexSelected.value == props.items.length) {
            indexSelected.value = 0;
        }
    }

    onMounted(() => {
        setInterval(() => {
            nextContent()
        }, props.time)
    })
</script>

<template>
    <div>
        <div v-for="item, index in items">
            <div v-if="indexSelected === index">
                <slot :item="item"/>
            </div>
        </div>

        <div
            style="height: 25vh"
            v-if="items.length === 0"
        >
            <slot name="empty-items"/>
        </div>

        <q-btn
            round
            dense
            flat
            color="white"
            @click="previousContent"
            class="absolute student-arrow-left-image"
            v-if="items.length > 1"
        >
            <q-icon name="chevron_left" size="50px" />
        </q-btn>

        <q-btn
            round
            dense
            flat
            color="white"
            @click="nextContent"
            class="absolute student-arrow-right-image"
            v-if="items.length > 1"
        >
            <q-icon name="chevron_right" size="50px" />
        </q-btn>

        <div class="absolute fixed-center" style="top: 75vh">
            <q-btn
                v-for="item, index in items"
                @click="indexSelected = index"
                size="7px"
                icon="fiber_manual_record"
                :color="indexSelected === index ? 'white' : 'grey'"
                flat
                round
                dense
            />
        </div>
    </div>
</template>
