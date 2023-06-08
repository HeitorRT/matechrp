<script setup>
    import { computed } from 'vue';
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'

    const $q = useQuasar()

    const props = defineProps({
        errors: Object,
        permissions: Object,
    });

    const form = useForm({
        id: null,
        name: null,
        can_delete: null,
        permission_ids: []
    });

    const submit = () => {
        form.post(route("admin.role.store"), {
            onSuccess: () => {
                $q.notify({
                    type: 'positive',
                    message: 'Grupo cadastrado com sucesso',
                    position: 'top',
                })
            },
        })
    };

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

    const goBack = () => useForm().get(route('admin.role.index'))
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Grupo | Adicionar" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Novo grupo de usuários </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Grupos" class="text-grey"/>
                    <q-breadcrumbs-el label="Novo grupo de usuários" class="text-primary" />
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
                    v-for="role, index in permissions"
                >
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-16">
                        {{ index }}
                    </div>

                    <div v-for="permission in role">
                        <q-checkbox
                            v-model="form.permission_ids"
                            :label="permission.label"
                            :val="permission.id"
                        />
                    </div>
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
                            Criar grupo
                        </div>
                    </q-btn>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
