<script setup>
    import { ref, computed, onMounted } from 'vue';
    import { useForm } from '@inertiajs/inertia-vue3';

    import ModalContentLive from '@/Components/Student/Content/ModalContentLive/Index.vue';

    const props = defineProps({
        content: Object,
    });

    const modalInfo = ref(false);

    const info = () => {
        modalInfo.value = true;
    }

    const toogleToList = () => {
        useForm().post(route('student.content.toggle-content-inside-list', props.content.id), {
            preserveState: true,
            preserveScroll: true,
        })
    }

    const mouseOverInAddBtn = ref(false)

    const showFirstChapter = () => {
        let chapterId;

        if (props.content.count_seasons > 0) {
            chapterId = props.content.seasons[0]?.chapters[0]?.id;
        } else {
            chapterId = props.content.chapter.id;
        }

        useForm().get(route('student.chapter.show', chapterId))
    }
</script>

<template>
    <div class="student-highlight-container">
        <img
            :src="content.image"
            :alt="content.name"
        />

        <div
            style="padding-left: 104px;"
            class="row items-center student-highlight-container-content"
        >
            <div class="col-md-6 col-10">
                <slot name="header"></slot>

                <div class="student-text-purple app-fw-800 app-fs-12 app-lh-16 q-mb-md student-label-category-carrousel">
                    {{ content.category_name }}
                </div>

                <div class="text-white app-fw-800 app-fs-58 app-lh-72 q-mb-lg">
                    {{ content.name }}
                </div>

                <div class="text-white app-fw-400 app-fs-19 app-lh-24 q-mb-lg" >
                    {{ content.description }}
                </div>

                <div class="q-pt-md">
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
                        @click="info"
                    >
                        <q-icon name="o_info" size="md" class="q-ml-sm"/>

                        <div class="text-caption q-mx-sm app-fw-600 app-fs-16 app-lh-16" style="letter-spacing: 1px;">
                            Mais Informações
                        </div>
                    </q-btn>

                    <q-btn
                        outline
                        color="white"
                        unelevated
                        class="app-br-16"
                        padding="16px 24px"
                        @click="toogleToList"
                        @mouseover="mouseOverInAddBtn = true"
                        @mouseleave="mouseOverInAddBtn = false"
                    >
                        <q-icon
                            :name="content.is_on_the_student_list ? 'close' : 'add'"
                            size="md"
                        />

                        <div
                            class="text-caption q-mx-sm app-fw-600 app-fs-16 app-lh-16"
                            style="letter-spacing: 1px;"
                            v-if="mouseOverInAddBtn"
                        >
                            {{ content.is_on_the_student_list ? 'Minha lista' : 'Adicionar a minha lista' }}
                        </div>
                    </q-btn>
                </div>
            </div>
        </div>
    </div>

    <ModalContentLive
        :content="content"
        :show="modalInfo"
        v-on:close="(e) => modalInfo = e"
    />
</template>
