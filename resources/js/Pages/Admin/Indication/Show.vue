<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'

    const $q = useQuasar()

    const props = defineProps({
        indication: Object,
        errors: Object,
    });

    const form = useForm({
        id: props.indication.id,
        name: props.indication.name,
        company_name: props.indication.company_name,
        phone: props.indication.phone,
        email: props.indication.email,
        link: props.indication.link,
        start_at: props.indication.start_at,
        end_at: props.indication.end_at,
    });

    const goBack = () => useForm().get(route('admin.indication.index'))
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Indicação | Visualizar" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Visualizar indicação </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Indicações" class="text-grey"/>
                    <q-breadcrumbs-el label="Visualizar indicação" class="text-primary" />
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

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.company_name"
                        label="Empresa"
                        disable
                    />
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="form.email"
                        label="E-mail"
                        disable
                    />
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="form.phone"
                        label="Telefone"
                        mask="(##) #########"
                        disable
                    />
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="form.start_at"
                        mask="##/##/####"
                        label="Data de inicio"
                        placeholder="dia/mês/ano"
                        disable
                    >
                        <template v-slot:prepend>
                            <q-icon name="o_calendar_today" />
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="form.end_at"
                        mask="##/##/####"
                        label="Data final"
                        placeholder="dia/mês/ano"
                        disable
                    >
                        <template v-slot:prepend>
                            <q-icon name="o_calendar_today" />
                        </template>
                    </q-input>
                </div>

                <div class="col-12">
                    <q-input
                        outlined
                        v-model="form.link"
                        label="Link"
                        disable
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
