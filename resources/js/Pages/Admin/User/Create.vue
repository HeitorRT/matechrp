<script setup>
    import { ref, computed } from 'vue'
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'

    const $q = useQuasar()

    const props = defineProps({
        errors: Object,
        roles: Array,
    });

    const form = useForm({
        id: null,
        name: null,
        email: null,
        cpf: null,
        phone: null,
        whereby_link: null,
        is_system_user: true,
        is_teacher: false,
        is_partner: false,
        address: {
            cep: null,
            street: null,
            number: null,
            district: null,
            complement: null,
            city: null,
            state: null,
            country: null,
        },
        link: null,
        active: true,
        role_ids: [],
    });

    const submit = () => {
        form.post(route("admin.user.store"), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                $q.notify({
                    type: 'positive',
                    message: 'Usuário cadastrado com sucesso',
                    position: 'top',
                })
            },
        })
    };

    const optionsRoles = ref(props.roles)

    const filterroles = (val, update, abort) => {
        update(() => optionsRoles.value = props.roles.filter(s => s.name.toLowerCase().indexOf(val.toLowerCase()) > -1))
    }

    const goBack = () => useForm().get(route('admin.user.index'))
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Usuário | Novo" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Novo usuário </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Usuários" class="text-grey"/>
                    <q-breadcrumbs-el label="Novo usuário" class="text-primary" />
                </q-breadcrumbs>
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
                        label="Nome do usuário *"
                        :bottom-slots="Boolean(errors.name)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.name }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.cpf"
                        label="CPF do usuário"
                        :bottom-slots="Boolean(errors.cpf)"
                        mask="###.###.###-##"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.cpf }} </div>
                        </template>
                    </q-input>
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
                        :bottom-slots="Boolean(errors.active)"
                        map-options
                        emit-value
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.active }} </div>
                        </template>

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
                        label="E-mail do usuário *"
                        :bottom-slots="Boolean(errors.email)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.email }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.phone"
                        label="Telefone do usuário"
                        :bottom-slots="Boolean(errors.phone)"
                        mask="(##) #########"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.phone }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.address.cep"
                        label="CEP"
                        :bottom-slots="Boolean(errors.address?.cep)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.address?.cep }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="form.address.street"
                        label="Rua"
                        :bottom-slots="Boolean(errors.address?.street)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.address?.street }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-2">
                    <q-input
                        outlined
                        v-model="form.address.number"
                        label="Número"
                        :bottom-slots="Boolean(errors.address?.number)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.address?.number }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.address.district"
                        label="Bairro"
                        :bottom-slots="Boolean(errors.address?.district)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.address?.district }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.address.city"
                        label="Cidade"
                        :bottom-slots="Boolean(errors.address?.city)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.address?.city }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.address.country"
                        label="País"
                        :bottom-slots="Boolean(errors.address?.country)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.address?.country }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.address.complement"
                        label="Complemento"
                        :bottom-slots="Boolean(errors.address?.complement)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.address?.complement }} </div>
                        </template>
                    </q-input>
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
                        :bottom-slots="Boolean(errors.role_ids)"
                        clearable
                        use-input
                        @filter="filterroles"
                        multiple
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.role_ids }} </div>
                        </template>

                        <template v-slot:selected-item="scope">
                            <q-chip
                                class="adm-chip-primary q-my-none"
                                :label="scope.opt.name"
                                dense
                            >
                                <q-icon
                                    name="cancel"
                                    size="xs"
                                    @click="scope.removeAtIndex(scope.index)"
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
                    />
                </div>

                <div class="col-12">
                    <q-checkbox
                        v-model="form.is_teacher"
                        label="Professor"
                    />
                </div>

                <div class="col-12" v-if="form.is_teacher">
                    <q-input
                        outlined
                        v-model="form.whereby_link"
                        label="Whereby"
                        :bottom-slots="Boolean(errors.whereby_link)"
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
                    />
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
                            Criar usuário
                        </div>
                    </q-btn>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
