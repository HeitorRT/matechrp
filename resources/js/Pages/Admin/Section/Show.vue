<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        section: Object,
        errors: Object,
    });

    const form = useForm({
        id: props.section.id,
        name: props.section.name,
        contents: props.section.contents,
    });

    const goBack = () => useForm().get(route('admin.section.index'))
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Categoria | Visualizar" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Visualizar seção </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Seções" class="text-grey"/>
                    <q-breadcrumbs-el label="Visualizar seção" class="text-primary" />
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

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.name"
                        label="Nome"
                        disable
                    />
                </div>

                <div class="col-12 items-center q-mt-xs">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Conteúdos
                    </div>
                </div>

                <div class="col-12">
                    <q-markup-table
                        class="text-grey-8"
                        flat
                        dense
                    >
                        <tbody>
                            <tr v-for="content in form.contents">
                                <td class="text-left" style="padding: 0; width: 10%">
                                    <q-img
                                        :src="content.image"
                                        style="height: 56px; width: 176px;"
                                    />
                                </td>
                                <td class="text-left" >{{ content.name }}</td>
                            </tr>
                        </tbody>
                    </q-markup-table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
