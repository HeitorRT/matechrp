<script setup>
    import { ref } from 'vue'
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        user: Object,
        errors: Object,
        roles: Array,
    });

    const form = useForm({
        id: props.user.id,
        name: props.user.name,
        email: props.user.email,
        cpf: props.user.cpf,
        phone: props.user.phone,
        whereby_link: props.user.whereby_link,
        is_system_user: props.user.is_system_user,
        is_teacher: props.user.is_teacher,
        is_partner: props.user.is_partner,
        address: {
            cep: props.user.address?.cep,
            street: props.user.address?.street,
            number: props.user.address?.number,
            district: props.user.address?.district,
            complement: props.user.address?.complement,
            city: props.user.address?.city,
            state: props.user.address?.state,
            country: props.user.address?.country,
        },
        link: props.user.link,
        active: props.user.active,
        role_ids: props.user.role_ids,
    });

    const optionsRoles = ref(props.roles)

    const goBack = () => useForm().get(route('admin.user.index'))
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Usuário | Visualizar" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Visualizar usuário </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Usuários" class="text-grey"/>
                    <q-breadcrumbs-el label="Visualizar usuário" class="text-primary" />
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
                        Dados do usuário
                    </div>
                </div>

                <div class="col-12 col-md-2">
                    <q-input
                        outlined
                        v-model="form.id"
                        label="ID do usuário"
                        disable
                    />
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.name"
                        label="Nome do usuário"
                        disable
                    />
                </div>

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.cpf"
                        label="CPF do usuário"
                        mask="###.###.###-##"
                        disable
                    />
                </div>

                <div class="col-12 col-md-3">
                    <q-select
                        :options="[{
                            label: 'Ativo',
                            value: true
                        }, {
                            label: 'Inativo',
                            value: false
                        }]"
                        outlined
                        v-model="form.active"
                        label="Status"
                        map-options
                        emit-value
                        disable
                    >
                        <template v-slot:selected-item="scope">
                            <q-chip
                                :tabindex="scope.tabindex"
                                text-color="white"
                                :class="{
                                    'adm-bg-positive':  scope.opt.value,
                                    'adm-bg-negative': !scope.opt.value
                                }"
                                dense
                                class="q-my-none"
                            >
                                {{ scope.opt.label }}
                            </q-chip>
                        </template>
                    </q-select>
                </div>

                <div class="col-12 col-md-9">
                    <q-input
                        outlined
                        v-model="form.email"
                        label="E-mail do usuário"
                        disable
                    />
                </div>

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.phone"
                        label="Telefone do usuário"
                        mask="(##) #########"
                        disable
                    />
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.address.cep"
                        label="CEP"
                        disable
                    />
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="form.address.street"
                        label="Rua"
                        disable
                    />
                </div>

                <div class="col-12 col-md-2">
                    <q-input
                        outlined
                        v-model="form.address.number"
                        label="Número"
                        disable
                    />
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.address.district"
                        label="Bairro"
                        disable
                    />
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.address.city"
                        label="Cidade"
                        disable
                    />
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.address.country"
                        label="País"
                        disable
                    />
                </div>

                <div class="col-12 col-md-12">
                    <q-select
                        :options="optionsRoles"
                        option-value="id"
                        option-label="name"
                        emit-value
                        map-options
                        outlined
                        v-model="form.role_ids"
                        label="Grupos de permissão"
                        disable
                        multiple
                    >
                        <template v-slot:selected-item="scope">
                            <q-chip
                                class="adm-chip-primary q-my-none"
                                :label="scope.opt.name"
                                dense
                            >
                                <q-icon
                                    name="cancel"
                                    size="xs"
                                    class="q-ml-xs cursor-pointer"
                                />
                            </q-chip>
                        </template>
                    </q-select>
                </div>

                <div class="col-12">
                    <q-checkbox
                        v-model="form.is_system_user"
                        label="Usuário de sistema"
                        disable
                    />
                </div>

                <div class="col-12">
                    <q-checkbox
                        v-model="form.is_teacher"
                        label="Professor"
                        disable
                    />
                </div>

                <div class="col-12" v-if="form.is_teacher">
                    <q-input
                        outlined
                        v-model="form.whereby_link"
                        label="Whereby"
                        :bottom-slots="Boolean(errors.whereby_link)"
                        disable
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.whereby_link }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12">
                    <q-checkbox
                        v-model="form.is_partner"
                        label="Parceiro"
                        disable
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
