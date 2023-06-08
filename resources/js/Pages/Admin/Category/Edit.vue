<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'
    import { Inertia } from '@inertiajs/inertia';
    import DialogConfirm from '@/Components/Admin/DialogConfirm.vue';

    const $q = useQuasar()

    const props = defineProps({
        category: Object,
        errors: Object,
    });

    const form = useForm({
        id: props.category.id,
        name: props.category.name,
    });

    const submit = () => {
        form.put(route("admin.category.update", form.id), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Categoria atualizado com sucesso',
                        position: 'top',
                    })
                },
            })
    };

    function destroy() {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Excluir categoria',
                message: 'Ao excluir a categoria, todos os vínculos com conteúdos serão desfeitos. Deseja realmente excluir?',
            },
        }).onOk(() => {
            Inertia.delete(route('admin.category.destroy', form.id), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Categoria excluído com sucesso',
                        position: 'top',
                    })
                }
            })
        });
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Categoria | Editar" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Editar categoria </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Categorias" class="text-grey"/>
                    <q-breadcrumbs-el label="Editar categoria" class="text-primary" />
                </q-breadcrumbs>
            </div>

            <div class="col-12 col-md-6 flex justify-end items-center">
                <q-btn
                    color="negative"
                    class="q-mr-md"
                    rounded
                    no-caps
                    outline
                    @click="destroy"
                >
                    <q-icon name="close" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Excluir categoria
                    </div>
                </q-btn>

                <q-btn
                    color="primary"
                    rounded
                    no-caps
                    @click="submit"
                    :disabled="form.processing"
                >
                    <q-icon name="check" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Salvar categoria
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
                        label="Nome *"
                        :bottom-slots="Boolean(errors.name)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.name }} </div>
                        </template>
                    </q-input>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
