<script setup>
    import AuthenticatedLayout from '@/Layouts/Student/AuthenticatedLayout.vue';
    import SearchContent from '@/Components/Student/Search/Content.vue';
    import { ref, computed } from 'vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { date } from 'quasar';

    const props = defineProps({
        errors: Object,
        contents: Object,
        content: Object,
        genres: Array,
    });

    const requestData = useForm({
        filter_content: null,
        genre_id: null,
    });

    const titleContents = computed(() => {
        return props.content ? 'Títulos semelhantes' : '';
    })

    const filterContents = () => {
        requestData.get(route('student.search'), {
            preserveState: true,
            preserveScroll: true,
        })
    }

    const filterContentsGenre = (id, filterContent) => {
        requestData.genre_id = id;
        requestData.filter_content = filterContent;
        requestData.get(route('student.search'), {
            preserveState: true,
            preserveScroll: true,
        })
    }

    const clearFilters = () => useForm().get(route('student.search'))

    const modalInfo = ref(false);

    const info = () => {
        modalInfo.value = true;
    }

    const show = () => {
        alert(`Será redirecionado para o conteúdo ${props.content.name}`)
    }

    const toogleToList = () => {
        useForm().post(route('student.content.toggle-content-inside-list', props.content.id), {
            preserveState: true,
            preserveScroll: true,
        })
    }

    const mouseOverInAddBtn = ref(false)

    const dateYearContent = computed(() => {
        return date.formatDate(new Date(props.content?.launch_start_at), 'YYYY');
    })

    const searchStyleBtn = (id) => {
        return requestData.genre_id === id ? 'student-bg-purple text-black' : 'student-border-purple student-text-purple';
    }
</script>

<template>
    <Head title="Search"/>

    <AuthenticatedLayout>
        <div class="search-container">
            <div class="search-container-content">
                <div class="col-12 text-white">
                    <q-input bottom-slots v-model="requestData.filter_content" dark class="app-fs-30" @change="filterContents()">
                        <template v-slot:prepend>
                            <q-icon name="search" class="material-symbols-outlined app-fw-100 app-fs-50" />
                        </template>
                        <template v-slot:append>
                            <q-icon name="cancel" @click="clearFilters" class="material-symbols-outlined app-fw-100 app-fs-50 cursor-pointer" />
                        </template>
                    </q-input>
                </div>

                <div class="row q-mt-lg" v-if="content">
                    <div class="col-12 col-sm-6 search-content-height">
                        <q-img :src="content.image" class="search-img"/>
                    </div>
                    <div class="col-12 col-sm-6 q-pt-lg q-pl-lg">
                        <div class="col-md-6 col-10 q-ml-lg">
                            <div class="student-text-purple app-fw-800 app-fs-12 app-lh-16 q-mb-md q-mt-lg text-uppercase">
                                {{ content.category.name }}
                            </div>
                            <div class="text-white app-fw-800 app-fs-58 app-lh-72 q-mb-lg">
                                {{ content.name }}
                            </div>
                            <div class="text-white app-fw-400 app-fs-19 app-lh-24 q-mb-lg" >
                                {{ content.description }}
                            </div>
                            <div class="text-white app-fw-400 app-fs-19 app-lh-24 q-mb-lg" >
                                {{ dateYearContent }} &bull; {{ content.seasons.length ? `${content.seasons.length} temporadas` : 'Filme' }} &bull; {{ content.category.name }} &bull; {{ content.genres[0].name }}
                            </div>

                            <div class="q-pt-md">
                                <q-btn
                                    class="app-br-16 student-bg-purple text-white q-mr-md q-mt-sm"
                                    padding="14px 24px"
                                    @click="show"
                                >
                                    <q-icon name="o_play_arrow" size="lg" class="q-ml-sm"/>

                                    <div class="text-caption q-mx-sm app-fw-600 app-fs-14 app-lh-16" style="letter-spacing: 1px;">
                                        Assistir
                                    </div>
                                </q-btn>

                                <q-btn
                                    unelevated
                                    class="app-br-16 q-mr-md text-white student-btn-more-info q-mt-sm"
                                    padding="16px 24px"
                                    @click="info"
                                >
                                    <q-icon name="o_info" size="md" class="q-ml-sm"/>

                                    <div class="text-caption q-mx-sm app-fw-600 app-fs-14 app-lh-16" style="letter-spacing: 1px;">
                                        Mais Informações
                                    </div>
                                </q-btn>

                                <q-btn
                                    outline
                                    color="white"
                                    unelevated
                                    class="app-br-16 q-mt-sm"
                                    padding="16px 24px"
                                    @click="toogleToList"
                                    @mouseover="mouseOverInAddBtn = true"
                                    @mouseleave="mouseOverInAddBtn = false"
                                >
                                    <q-icon
                                        :name="content.is_on_the_student_list ? 'close' : 'add'"
                                        size="md"
                                    />
                                </q-btn>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-white q-mt-lg text-center" v-if="contents.length === 0">
                    <label class="app-fs-18 app-fw-300">Nenhum conteúdo encontrado.</label>
                </div>

                <div class="col-12 text-white q-mt-lg" v-if="genres && contents.length > 0">
                    <label class="app-fs-25 app-fw-500">Filtrar por categorias</label>
                    <div class="q-mt-md">
                        <q-btn
                            v-for="genre in genres"
                            :label="genre.name"
                            @click="filterContentsGenre(genre.id, requestData.filter_content)"
                            no-caps
                            :class="`q-mr-sm app-fs-16 q-mt-sm ${searchStyleBtn(genre.id)}`"
                        />
                    </div>
                </div>

                <div class="q-mt-lg">
                    <SearchContent
                        :title="titleContents"
                        :items="contents"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
