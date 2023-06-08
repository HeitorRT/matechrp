<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'
    import { ref, computed } from 'vue'

    const $q = useQuasar()

    const props = defineProps({
        quizz: Object,
        errors: Object,
        answerTypes: Object,
        linkableTypes: Object,
        contents: Array,
        seasonsOrChapters: Array,
    });

    const form = useForm({
        id: props.quizz.id,
        name: props.quizz.name,
        description: props.quizz.description,
        questions: props.quizz.questions,
        content_id: props.quizz.content_id,
        linkable_id: props.quizz.linkable_id,
        linkable_type: props.quizz.linkable_type,
    });

    const optionsContents = ref(props.contents)

    const labelOptionsSeasonsOrChapters = computed(() => {
        if (form.linkable_type === 'season') {
            return 'Temporada';
        }

        if (form.linkable_type === 'chapter') {
            return 'Episódio';
        }

        return '';
    })

    const optionsSeasonsOrChapters = ref(props.seasonsOrChapters)

    const optionsLinkableTypes = computed(() => {
        let options = new Array();

        for (const key in props.linkableTypes) {
            options.push({ label: props.linkableTypes[key], value: key })
        }

        return options;
    })

    const optionsAnswerTypes = computed(() => {
        let options = new Array();

        for (const key in props.answerTypes) {
            options.push({ label: props.answerTypes[key], value: key })
        }

        return options;
    })

    const imageSrc = (image) => {
        if (image == null) {
            return '';
        }

        return (typeof image === 'object') ? URL.createObjectURL(image) : image;
    };

    const goBack = () => useForm().get(route('admin.quizz.index'))

    const numberToChar = (number) => String.fromCharCode(97 + number).toUpperCase()
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Quizz | Visualizar" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Visualizar quizz </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="quizzs" class="text-grey"/>
                    <q-breadcrumbs-el label="Visualizar quizz" class="text-primary" />
                </q-breadcrumbs>
            </div>

            <div class="col-12 col-md-6 flex justify-end items-center">
                <q-btn
                    color="primary"
                    class="q-mr-md"
                    rounded
                    no-caps
                    outline
                    @click="goBack"
                >
                    <q-icon name="chevron_left" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Voltar
                    </div>
                </q-btn>
            </div>
        </div>

        <div class="bg-white q-py-lg q-px-lg app-br-16">
            <div class="row q-col-gutter-lg">
                <div class="col-12 items-center q-mt-xs">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Informações
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="form.name"
                        label="Nome do Quizz"
                        disable
                    />
                </div>

                <div class="col-12 col-md-6">
                    <q-select
                        :options="optionsContents"
                        option-value="id"
                        option-label="name"
                        emit-value
                        map-options
                        outlined
                        v-model="form.content_id"
                        label="Vincular quizz ao conteúdo"
                        disable
                    >
                        <template v-slot:selected-item="scope">
                            <q-chip
                                class="adm-chip-primary q-my-none"
                                :label="scope.opt.name"
                                dense
                            />
                        </template>
                    </q-select>
                </div>

                <div class="col-12 col-md-6" >
                    <q-select
                        :options="optionsLinkableTypes"
                        emit-value
                        map-options
                        outlined
                        v-model="form.linkable_type"
                        label="Momento de vinculação do quizz"
                        disable
                    />
                </div>

                <div class="col-12 col-md-6">
                    <q-select
                        v-if="form.linkable_type !== 'content'"
                        :options="optionsSeasonsOrChapters"
                        option-value="id"
                        option-label="name"
                        emit-value
                        map-options
                        outlined
                        v-model="form.linkable_id"
                        :label="labelOptionsSeasonsOrChapters"
                        disable
                    >
                        <template v-slot:selected-item="scope">
                            <q-chip
                                class="adm-chip-primary q-my-none"
                                :label="scope.opt.name"
                                dense
                            />
                        </template>
                    </q-select>
                </div>

                <div class="col-12 items-center q-mt-xs">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Questões do Quizz
                    </div>
                </div>

                <div class="col-12">
                    <div
                        v-for="(element, index) in form.questions"
                    >
                        <div class="row q-col-gutter-lg q-mb-lg">
                            <div class="col-md-6 col-12">
                                <q-input
                                    outlined
                                    v-model="element.title"
                                    :label="`Questão ${index + 1}`"
                                    disable
                                />
                            </div>

                            <div class="col-md-6 offset-md-0 col-11 offset-1">
                                <q-select
                                    :options="optionsAnswerTypes"
                                    outlined
                                    label="Tipo de questão"
                                    v-model="element.answer_type"
                                    emit-value
                                    map-options
                                    disable
                                />
                            </div>

                            <div
                                class="col-12 row"
                                v-for="(alternative, index) in element.alternatives"
                                v-if="element.answer_type === 'fechada'"
                            >
                                <div class="col-md-6 col-10 offset-2">
                                    <q-input
                                        outlined
                                        :label="`Opção resposta ${numberToChar(index)}`"
                                        v-model="alternative.name"
                                        disable
                                    >
                                        <template v-slot:append>
                                            <q-checkbox
                                                v-model="alternative.is_correct"
                                                label="Resposta correta"
                                                class="app-fs-12"
                                                color="green"
                                                left-label
                                                disable
                                            />
                                        </template>
                                    </q-input>
                                </div>
                            </div>

                            <div class="offset-1 col-11 flex items-center">
                                <div class="text-grey-8">
                                    Anexos vinculados:
                                </div>

                                <q-checkbox v-model="element.has_video" label="Vídeo" disable/>
                                <q-checkbox v-model="element.has_audio" label="Áudio" disable/>
                                <q-checkbox v-model="element.has_image" label="Imagem" disable/>
                            </div>

                            <div class="offset-1 col-11" v-if="element.has_video">
                                <q-input
                                    outlined
                                    label="Link do vídeo"
                                    v-model="element.video"
                                    disable
                                />
                            </div>

                            <div class="offset-1 col-11" v-if="element.has_audio">
                                <q-input
                                    outlined
                                    label="Link do áudio"
                                    v-model="element.audio"
                                    disable
                                />
                            </div>

                            <div
                                class="offset-1 col-11 col-md-4"
                                v-if="element.has_image"
                            >
                                <q-img
                                    :src="imageSrc(element.image)"
                                    style="height: 400px"
                                    class="app-br-16"
                                >
                                    <div class="absolute-bottom text-subtitle2 row items-center">
                                        <q-icon name="o_photo" size="md" class="q-mr-md"/>
                                    </div>
                                </q-img>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
