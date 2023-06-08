<script setup>
    import AuthenticatedLayout from '@/Layouts/Student/AuthenticatedLayout.vue';
    import ShoppingCard from '@/Components/Student/Course/ShoppingCard.vue';

    import Slider from '@/Components/Student/HighLight/Slider.vue';
    import ContentHighLight from '@/Components/Student/HighLight/Content.vue';
    import LiveEventHighLight from '@/Components/Student/HighLight/LiveEvent.vue';
    import MeetingHighLight from '@/Components/Student/HighLight/Meeting.vue';

    import Carrousel from '@/Components/Student/Carrousel/Index.vue';
    import Item from '@/Components/Student/Content/Item.vue';

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
                    <ContentHighLight
                        :content="item"
                        v-if="item.type === 'content'"
                    />

                    <LiveEventHighLight
                        :liveEvent="item"
                        v-if="item.type === 'liveEvent'"
                    />

                    <MeetingHighLight
                        :meeting="item"
                        v-if="item.type === 'meeting'"
                    />
                </template>
            </Slider>
        </div>

        <div>
            <Carrousel
                v-for="section in sections"
                :title="section.name"
                :items="section.contents"
            >
                <template v-slot:item="{ item }">
                    <Item :item="item"/>
                </template>
            </Carrousel>
        </div>

        <div style="padding: 0 104px" v-if="courses.length > 0">
            <div class="text-white app-fw-700 app-fs-27 app-lh-32 q-mb-md">
                Cursos
            </div>

            <div class="row q-col-gutter-lg">
                <div class="col-12 col-md-4" v-for="course in courses">
                    <ShoppingCard
                        :title="course.name"
                        :imageUrl="course.image"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
