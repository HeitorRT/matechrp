<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'

    const $q = useQuasar()

    const props = defineProps({
        errors: Object,
    });

    const form = useForm({
        id: null,
        name: null,
    });

    const submit = () => {
        form.post(route("admin.section.store"), {
            onSuccess: () => {
                $q.notify({
                    type: 'positive',
                    message: 'Seção cadastrada com sucesso',
                    position: 'top',
                })
            },
        })
    };

    const goBack = () => useForm().get(route('admin.section.index'))
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Seção | Adicionar" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Nova seção </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Seções" class="text-grey"/>
                    <q-breadcrumbs-el label="Nova seção" class="text-primary" />
                </q-breadcrumbs>
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
                        label="Nome *"
                        :bottom-slots="Boolean(errors.name)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.name }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 flex justify-end items-center">
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

                    <q-btn
                        color="primary"
                        rounded
                        no-caps
                        @click="submit"
                        :disabled="form.processing"
                    >
                        <q-icon name="add" size="xs"/>

                        <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                            Criar seção
                        </div>
                    </q-btn>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
