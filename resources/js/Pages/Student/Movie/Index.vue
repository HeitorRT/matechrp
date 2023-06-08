<script setup>
    import AuthenticatedLayout from '@/Layouts/Student/AuthenticatedLayout.vue';
    import ShoppingCard from '@/Components/Student/Course/ShoppingCard.vue';

    import Slider from '@/Components/Student/HighLight/Slider.vue';
    import ContentHighLight from '@/Components/Student/HighLight/Content.vue';

    import Carrousel from '@/Components/Student/Carrousel/Index.vue';
    import Item from '@/Components/Student/Content/Item.vue';

    import { ref } from 'vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        errors: Object,
        highlightItems: Object,
        sections: Object,
        courses: Array,
        genres: Array,
        genreId: Number
    });

    const genre = ref(props.genreId);

    const filterByGenre = () => {
        useForm().get(route('student.movie', {
            genre: genre.value
        }));
    }
</script>

<template>
    <Head title="Filmes"/>

    <AuthenticatedLayout>
        <div>
            <Slider :items="highlightItems">
                <template v-slot="{ item }">
                    <ContentHighLight :content="item">
                        <template v-slot:header>
                            <div class="q-mb-xl">
                                <q-select
                                    :options="genres"
                                    label="Gêneros"
                                    option-value="id"
                                    option-label="name"
                                    emit-value
                                    map-options
                                    outlined
                                    v-model="genre"
                                    dark
                                    style="width: 500px;"
                                    @update:model-value="filterByGenre"
                                    color="purple"
                                    clearable
                                >
                                    <template v-slot:before>
                                        <div class="text-white app-fw-700 app-fs-22 app-lh-24" >
                                            Filmes
                                        </div>
                                    </template>
                                </q-select>
                            </div>
                        </template>
                    </ContentHighLight>
                </template>

                <template v-slot:empty-items>
                    <div
                        style="padding-left: 104px; height: 40vh"
                        class="row items-center "
                    >
                        <div class="col-md-6 col-10">
                            <div class="q-mb-xl">
                                <q-select
                                    :options="genres"
                                    label="Gêneros"
                                    option-value="id"
                                    option-label="name"
                                    emit-value
                                    map-options
                                    outlined
                                    v-model="genre"
                                    dark
                                    style="width: 500px;"
                                    @update:model-value="filterByGenre"
                                    color="purple"
                                    clearable
                                >
                                    <template v-slot:before>
                                        <div class="text-white app-fw-700 app-fs-22 app-lh-24" >
                                            Filmes
                                        </div>
                                    </template>
                                </q-select>
                            </div>
                        </div>
                    </div>
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
