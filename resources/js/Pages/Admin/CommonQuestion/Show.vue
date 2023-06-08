<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        commonQuestion: Object,
        errors: Object,
    });

    const form = useForm({
        id: props.commonQuestion.id,
        question_text: props.commonQuestion.question_text,
        answer_text: props.commonQuestion.answer_text,
        show: props.commonQuestion.show,
    });

    const goBack = () => useForm().get(route('admin.common-question.index'))
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Pergunta | Visualizar" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Visualizar pergunta </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Perguntas" class="text-grey"/>
                    <q-breadcrumbs-el label="Visualizar pergunta" class="text-primary" />
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
                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.question_text"
                        label="Pergunta"
                        type="textarea"
                        disable
                    />
                </div>

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.answer_text"
                        label="Resposta"
                        type="textarea"
                        disable
                    />
                </div>

                <div class="col-12">
                    <q-checkbox
                        v-model="form.show"
                        label="Exibir para o aluno"
                        disable
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
