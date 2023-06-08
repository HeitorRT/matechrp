<script setup>
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { useQuasar } from 'quasar'
    import draggable from 'vuedraggable'

    const $q = useQuasar()

    const props = defineProps({
        sections: Object,
        errors: Object,
    });

    const reOrder = () => {
        useForm({
            sections: props.sections
        }).post(route('admin.section.reorder'), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                $q.notify({
                    type: 'positive',
                    message: `Seções ordenadas com sucesso`,
                    position: 'top',
                })
            }
        });
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Ordenar seções" />

        <div class="row q-pb-xl">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Ordenar seções </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Seções" class="text-primary" />
                    <q-breadcrumbs-el label="Ordenar" class="text-primary" />
                </q-breadcrumbs>
            </div>

             <div class="col-12 col-md-6 flex justify-end items-center">
                <q-btn
                    color="primary"
                    rounded
                    no-caps
                    @click="reOrder"
                >
                    <q-icon name="check" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Salvar ordenação
                    </div>
                </q-btn>
            </div>
        </div>

        <q-card flat class="app-br-16">
            <q-card-section class="row flex-center q-py-md q-px-lg text-grey-8">
                Arraste e solte para ordenar seções
            </q-card-section>

            <q-card-section class="q-py-none">
                <q-separator color="grey-3"/>
            </q-card-section>

            <q-card-section class="q-pt-none q-pb-xl">
                <q-markup-table
                    class="text-grey-8"
                    flat
                >
                    <thead>
                        <tr>
                            <th class="text-left">
                            </th>
                            <th class="text-left" style="width: 95%;">
                                <div class="app-fw-700 app-fs-16 q-py-sm">
                                    Nome
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <draggable
                        :list="sections"
                        item-key="index"
                        tag="tbody"
                    >
                        <template #item="{element: section, index}">
                            <tr>
                                <td>
                                    <div class="q-py-sm text-center">
                                        <q-icon
                                            name="subject"
                                            size="sm"
                                            class="cursor-pointer"
                                        >
                                                <q-tooltip
                                                    anchor="center right"
                                                    self="center left"
                                                    :offset="[10, 10]"
                                                    class="text-body2 bg-grey-10"
                                                >
                                                Arraste e solte para ordenar seções
                                            </q-tooltip>
                                        </q-icon>
                                    </div>
                                </td>
                                <td>
                                    {{ section.name }}
                                </td>
                            </tr>
                        </template>
                    </draggable>
                </q-markup-table>
            </q-card-section>
        </q-card>
    </AuthenticatedLayout>
</template>

