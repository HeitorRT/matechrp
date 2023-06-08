<script setup>
    import { computed } from 'vue';
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'
    import DialogConfirm from '@/Components/Admin/DialogConfirm.vue';

    const $q = useQuasar()

    const props = defineProps({
        role: Object,
        permissions: Object,
        errors: Object,
        canRoleDestroy: Boolean,
    });

    const form = useForm({
        id: props.role.id,
        name: props.role.name,
        can_delete: props.role.can_delete,
        permission_ids: props.role.permission_ids
    });

    const submit = () => {
        form.put(route("admin.role.update", form.id), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Grupo atualizado com sucesso',
                        position: 'top',
                    })
                },
            })
    };

    function destroy() {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Excluir grupo',
                message: 'Tem certeza que deseja excluir essa grupo?',
            },
        }).onOk(() => {
            useForm().delete(route('admin.role.destroy', form.id), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Grupo excluído com sucesso',
                        position: 'top',
                    })
                }
            })
        });
    }

    const allSelected = computed({
        get: () => {
            let countPermissions = 0;
            for (const key in props.permissions) {
                countPermissions += props.permissions[key].length;
            }
            return form.permission_ids.length === countPermissions;
        },
        set: (value) => {
            form.permission_ids = [];

            if (value) {
                for (const key in props.permissions) {
                    props.permissions[key].forEach(p => form.permission_ids.push(p.id))
                }
            }
        }
    })
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Grupo | Editar" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Editar grupo de usuários </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Seções" class="text-grey"/>
                    <q-breadcrumbs-el label="Editar grupo de usuários" class="text-primary" />
                </q-breadcrumbs>
            </div>

            <div class="col-12 col-md-6 flex justify-end items-center">
                <q-btn
                    v-if="canRoleDestroy"
                    color="negative"
                    class="q-mr-md"
                    rounded
                    no-caps
                    outline
                    @click="destroy"
                >
                    <q-icon name="close" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Excluir grupo
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

                <div class="col-12 items-center q-mt-xs">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Permissões
                    </div>
                </div>

                <div class="col-12 items-center q-mt-xs">
                    <q-checkbox
                        :label="allSelected ? 'Desselecionar todas as permissões' : 'Selecionar todas as permissões'"
                        v-model="allSelected"
                    />
                </div>

                <div
                    class="col-12 col-md-4"
                    v-for="perm, index in permissions"
                >
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-16">
                        {{ index }}
                    </div>

                    <div v-for="permission in perm">
                        <q-checkbox
                            v-model="form.permission_ids"
                            :label="permission.label"
                            :val="permission.id"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
