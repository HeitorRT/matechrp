<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'
    import DialogConfirm from '@/Components/Admin/DialogConfirm.vue';
    import draggable from 'vuedraggable'

    const $q = useQuasar()

    const props = defineProps({
        section: Object,
        errors: Object,
    });

    const form = useForm({
        id: props.section.id,
        name: props.section.name,
        identifier: props.section.identifier,
        can_delete: props.section.can_delete,
        contents: props.section.contents,
    });

    const submit = () => {
        form.put(route("admin.section.update", form.id), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Seção atualizado com sucesso',
                        position: 'top',
                    })
                },
            })
    };

    function destroy() {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Excluir seção',
                message: 'Ao excluir a seção, todos os vínculos com conteúdos serão desfeitos. Deseja realmente excluir?',
            },
        }).onOk(() => {
            useForm().delete(route('admin.section.destroy', form.id), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Seção excluída com sucesso',
                        position: 'top',
                    })
                }
            })
        });
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Seção | Editar" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Editar seção </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Seções" class="text-grey"/>
                    <q-breadcrumbs-el label="Editar seção" class="text-primary" />
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
                    v-if="form.can_delete"
                >
                    <q-icon name="close" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Excluir seção
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
                        Salvar
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

                <div class="col-12 col-md-12" v-if="form.identifier">
                    <q-input
                        outlined
                        v-model="form.identifier"
                        label="Identificador"
                        disable
                    />
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

                <div class="col-12 items-center q-mt-xs" v-if="form.contents.length > 0">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Conteúdos
                    </div>
                </div>

                <div class="col-12" v-if="form.contents.length > 0">
                    <q-markup-table
                        class="text-grey-8"
                        flat
                        dense
                    >
                        <tbody>
                            <draggable
                                :list="form.contents"
                                item-key="index"
                            >
                                <template #item="{element: content, index}">
                                    <tr>
                                        <td class="text-center" style="width: 10%">
                                            <q-icon name="subject" size="sm" class="cursor-pointer"/>
                                        </td>
                                        <td class="text-left" style="padding: 0; width: 10%">
                                            <q-img
                                                :src="content.image"
                                                style="height: 56px; width: 176px;"
                                            />
                                        </td>
                                        <td class="text-left" >{{ content.name }}</td>
                                    </tr>
                                </template>
                            </draggable>
                        </tbody>

                    </q-markup-table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
