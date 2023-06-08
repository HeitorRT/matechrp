<script setup>
    import { ref, computed, onMounted, watch } from 'vue';
    import { useForm } from '@inertiajs/inertia-vue3';

    import CardItem from '@/Components/Student/Content/ModalContentLive/CardItem.vue';

    const props = defineProps({
        content: Object,
        show: Boolean,
    });

    const seasonId = ref(null);

    const showModal = ref(false);

    onMounted(() => {
        if (props.content.count_seasons > 0) {
            seasonId.value = props.content.seasons[0].id;
        }
    })

    const seletedSeasonIndex = (season_id) => {
        return props.content.seasons ? props.content.seasons.findIndex(s => s.id == season_id) + 1 : null;
    }

    const seletedSeason = computed(() => {
        if(! props.content.seasons){
            return null;
        }

        let index = props.content.seasons.findIndex(s => s.id == seasonId.value);

        return props.content.seasons[index];
    })

    const toogleToList = () => {
        useForm().post(route('student.content.toggle-content-inside-list', props.content.id), {
            preserveState: true,
            preserveScroll: true,
        })
    }

    const emit = defineEmits(['close'])

    watch(() => props.show, (show, prevShow) => {
        showModal.value = show;
    })

    watch(() => showModal.value, (showModal, prevShowModal) => {
        emit('close', showModal)
    })

    const downloadFile = (path, name = 'file') => {
        const link = document.createElement('a');
        link.href = path;
        link.target = '_blank';
        link.setAttribute('download', name);
        link.click();
    }

    const showChapter = (chapterId) => useForm().get(route('student.chapter.show', chapterId))

    const showFirstChapter = () => {
        let chapterId;

        if (props.content.count_seasons > 0) {
            chapterId = props.content.seasons[0]?.chapters[0]?.id;
        } else {
            chapterId = props.content.chapter.id;
        }

        showChapter(chapterId)
    }
</script>

<template>
    <q-dialog v-model="showModal" full-height>
        <q-card style="max-width: 1200px" class="column fit student-bg-main">
            <q-card-section class="student-content-modal-container q-pa-none">
                <img
                    :src="content.image"
                    :alt="content.name"
                />

                <div
                    style="padding: 0 80px"
                    class="row items-center student-content-modal-container-content"
                >
                    <div class="col">
                        <div class="text-white app-fw-800 app-fs-12 app-lh-16 q-mb-sm student-label-category-carrousel">
                            {{ content.category_name }}
                        </div>

                        <div class="text-white app-fw-800 app-fs-58 app-lh-72 q-mb-md">
                            {{ content.name }}
                        </div>

                        <div class="text-white app-fw-400 app-fs-19 app-lh-24 q-mb-lg" >
                            {{ content.description }}
                        </div>

                        <div class="text-white app-fw-400 app-fs-19 app-lh-24 q-my-sm row items-center" >
                            <div>
                                {{ content.year }}
                            </div>

                            <q-icon name="lens" size="5px" class="q-mx-md"/>

                            <div v-if="content.count_seasons">
                                {{ content.count_seasons }} temporadas
                            </div>

                            <q-icon name="lens" size="5px" class="q-mx-md" v-if="content.count_seasons"/>

                            <div>
                                {{ content.category_name }}
                            </div>

                            <q-icon name="lens" size="5px" class="q-mx-md" v-if="content.genres_name"/>

                            <div>
                                {{ content.genres_name }}
                            </div>
                        </div>

                        <div class="q-py-md">
                            <q-btn
                                class="app-br-16 student-bg-purple text-white q-mr-md"
                                padding="14px 24px"
                                @click="showFirstChapter"
                            >
                                <q-icon name="o_play_arrow" size="lg" class="q-ml-sm"/>

                                <div class="text-caption q-mx-sm app-fw-600 app-fs-16 app-lh-16" style="letter-spacing: 1px;">
                                    Assistir
                                </div>
                            </q-btn>

                            <q-btn
                                unelevated
                                class="app-br-16 q-mr-md text-white student-btn-more-info"
                                padding="16px 24px"
                            >
                                <q-icon name="o_edit" size="md" class="q-ml-sm"/>

                                <div class="text-caption q-mx-sm app-fw-600 app-fs-16 app-lh-16" style="letter-spacing: 1px;">
                                    Fazer Quizz
                                </div>
                            </q-btn>

                            <q-btn
                                outline
                                color="white"
                                unelevated
                                class="app-br-16"
                                padding="16px 24px"
                                @click="toogleToList"
                            >
                                <q-icon
                                    :name="content.is_on_the_student_list ? 'close' : 'add'"
                                    size="md"
                                />

                                <div
                                    class="text-caption q-mx-sm app-fw-600 app-fs-16 app-lh-16"
                                    style="letter-spacing: 1px;"
                                >
                                    {{ content.is_on_the_student_list ? 'Remover da minha lista' : 'Adicionar a minha lista' }}
                                </div>
                            </q-btn>
                        </div>

                        <div class="text-white app-fw-400 app-fs-19 app-lh-24 q-pt-md" v-if="content.responsible_name">
                            Direção: {{ content.responsible_name }}
                        </div>

                        <div class="q-pt-xl q-pb-md" v-if="content.count_seasons > 0">
                            <q-select
                                :options="content.seasons"
                                option-value="id"
                                :option-label="opt => `Temporada ${seletedSeasonIndex(opt.id)}: ${opt.name}`"
                                emit-value
                                map-options
                                outlined
                                v-model="seasonId"
                                dark
                                style="width: 420px;"
                                color="purple"
                                label="Temporada"
                            >
                            </q-select>
                        </div>

                        <div class="text-white app-fw-700 app-fs-39 app-lh-48 q-py-md">
                           {{ content.count_seasons ? 'Episódios' : 'Conteúdo' }}
                        </div>

                        <q-list
                            v-for="(chapter, indexChapter) in seletedSeason.chapters"
                            v-if="seletedSeason"
                        >
                            <q-item class="q-pa-none">
                                <CardItem
                                    :image="chapter.image"
                                    :title="`${indexChapter + 1}. ${chapter.name}`"
                                    :title-right="chapter.duration"
                                    :description="chapter.description"
                                    @click="showChapter(chapter.id)"
                                    class="cursor-pointer"
                                />
                            </q-item>
                        </q-list>

                        <CardItem
                            v-if="content.chapter"
                            :image="content.chapter.image"
                            :title="content.chapter.name"
                            :title-right="content.chapter.duration"
                            :description="content.chapter.description"
                            @click="showChapter(content.chapter.id)"
                            class="cursor-pointer"
                        />

                        <div class="text-white app-fw-700 app-fs-39 app-lh-48 q-py-md" v-if="content.quizzes.length > 0">
                            Quizz
                        </div>

                        <CardItem
                            v-for="quizz in content.quizzes"
                            :image="quizz.image"
                            :title="quizz.name"
                            :title-right="`${quizz.count_questions} questões`"
                            :description="quizz.description"
                        />

                        <div class="text-white app-fw-700 app-fs-39 app-lh-48 q-py-md" v-if="content.files.length > 0">
                            Arquivos
                        </div>

                        <div class="row" v-if="content.files.length > 0">
                            <div class="col-3" v-for="file in content.files">
                                <q-card
                                    class="transparent"
                                    flat
                                >
                                    <q-card-section>
                                        <q-img
                                            class="app-br-16"
                                            :src="file.file"
                                            width="230px"
                                            height="162px"
                                            v-if="file.is_image"
                                        />

                                        <div
                                            v-else
                                            class="app-br-16 flex flex-center"
                                            :style="{
                                                width: '230px',
                                                height: '162px',
                                                border: '1px dashed grey'
                                            }"
                                        >
                                            <q-icon name="folder" size="80px" color="grey"/>
                                        </div>

                                        <div class="text-white app-fw-700 app-fs-22 app-lh-32 q-py-md text-no-wrap">
                                            {{ file.name }}
                                        </div>

                                        <div
                                            class="text-white app-fw-400 app-fs-16 app-lh-24 app-text-with-underline cursor-pointer"
                                            @click="downloadFile(file.file, file.name)"
                                        >
                                            Download
                                        </div>
                                    </q-card-section>
                                </q-card>
                            </div>
                        </div>
                    </div>
                </div>
            </q-card-section>
        </q-card>
    </q-dialog>
</template>
