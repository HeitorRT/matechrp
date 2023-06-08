<script setup>
    import { ref, computed } from 'vue'
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        student: Object,
        errors: Object,
        groups: Array,
    });

    const form = useForm({
        id: props.student.id,
        name: props.student.name,
        email: props.student.email,
        cpf: props.student.cpf,
        phone: props.student.phone,
        address: {
            cep: props.student.address?.cep,
            street: props.student.address?.street,
            number: props.student.address?.number,
            district: props.student.address?.district,
            complement: props.student.address?.complement,
            city: props.student.address?.city,
            state: props.student.address?.state,
            country: props.student.address?.country,
        },
        link: props.student.link,
        active: props.student.active,
        profile_image: null,
        customer_cpf: props.student.customer_cpf,
        customer_phone: props.student.customer_phone,
        equal_data: props.student.equal_data,
    });

    const customerCPF = computed({
        get: () => form.equal_data ? form.cpf : form.customer_cpf,
        set: (newValue) => form.customer_cpf = newValue
    })

    const customerPhone = computed({
        get: () => form.equal_data ? form.phone : form.customer_phone,
        set: (newValue) => form.customer_phone = newValue
    })

    const goBack = () => useForm().get(route('admin.student.index'))
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Aluno | Visualizar" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Visualizar aluno </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Alunos" class="text-grey"/>
                    <q-breadcrumbs-el label="Visualizar aluno" class="text-primary" />
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
                        Dados do aluno
                    </div>
                </div>

                <div class="col-12 col-md-2">
                    <q-input
                        outlined
                        v-model="form.id"
                        label="ID do aluno"
                        disable
                    />
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.name"
                        label="Nome do aluno"
                        disable
                    />
                </div>

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.cpf"
                        label="CPF do aluno"
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
                        label="E-mail do aluno"
                        disable
                    />
                </div>

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.phone"
                        label="Telefone do aluno"
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




                <div class="col-12 items-center q-mt-xs">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Dados do cliente
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="customerCPF"
                        label="CPF do cliente"
                        mask="###.###.###-##"
                        disable
                    />
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="customerPhone"
                        label="Telefone do cliente"
                        mask="(##) #########"
                        disable
                    />
                </div>

                <div class="col-12">
                    <q-checkbox
                        v-model="form.equal_data"
                        label="Dados iguais"
                        disable
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
