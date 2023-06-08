<script setup>
    import AuthenticatedLayout from '@/Layouts/Student/AuthenticatedLayout.vue';
    import Carrousel from '@/Components/Student/Carrousel/Index.vue';

    import Item from '@/Components/Student/Live/Item.vue';

    import Slider from '@/Components/Student/HighLight/Slider.vue';
    import LiveEventHighLight from '@/Components/Student/HighLight/LiveEvent.vue';

    import { Head } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        errors: Object,
        highlightItems: Object,
        sections: Object,
        courses: Array,
    });
</script>

<template>
    <Head title="Home"/>

    <AuthenticatedLayout>
        <div>
            <Slider :items="highlightItems">
                <template v-slot="{ item }">
                    <LiveEventHighLight
                        :liveEvent="item"
                        v-if="item.type === 'liveEvent'"
                    />
                </template>
            </Slider>
        </div>

        <div>
            <Carrousel
                v-for="section in sections"
                :title="section.name"
                :items="section.lives"
            >
                <template v-slot:item="{ item }">
                    <Item :item="item"/>
                </template>
            </Carrousel>
        </div>
    </AuthenticatedLayout>
</template>
