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
        company_name: null,
        phone: null,
        email: null,
        link: null,
        start_at: null,
        end_at: null,
    });

    const submit = () => {
        form.post(route("admin.indication.store"), {
            onSuccess: () => {
                $q.notify({
                    type: 'positive',
                    message: 'Indicação atualizado com sucesso',
                    position: 'top',
                })
            },
        })
    };

    const goBack = () => useForm().get(route('admin.indication.index'))
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Indicação | Adicionar" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Nova indicação </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Indicações" class="text-grey"/>
                    <q-breadcrumbs-el label="Nova indicação" class="text-primary" />
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

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.company_name"
                        label="Empresa *"
                        :bottom-slots="Boolean(errors.company_name)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.company_name }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="form.email"
                        label="E-mail *"
                        :bottom-slots="Boolean(errors.email)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.email }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="form.phone"
                        label="Telefone"
                        :bottom-slots="Boolean(errors.phone)"
                        mask="(##) #########"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.phone }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="form.start_at"
                        mask="##/##/####"
                        label="Data de inicio *"
                        :bottom-slots="Boolean(errors.start_at)"
                        clearable
                    >
                        <template v-slot:prepend>
                            <q-icon name="o_calendar_today"/>
                        </template>

                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.start_at }} </div>
                        </template>

                        <q-popup-proxy>
                            <q-date
                                v-model="form.start_at"
                                mask="DD/MM/YYYY"
                                square
                            >
                                <div class="row items-center justify-end">
                                    <q-btn
                                        label="Ok"
                                        color="primary"
                                        flat
                                        v-close-popup
                                    />
                                </div>
                            </q-date>
                        </q-popup-proxy>
                    </q-input>
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="form.end_at"
                        mask="##/##/####"
                        label="Data final"
                        :bottom-slots="Boolean(errors.end_at)"
                        clearable
                    >
                        <template v-slot:prepend>
                            <q-icon name="o_calendar_today"/>
                        </template>

                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.end_at }} </div>
                        </template>

                        <q-popup-proxy>
                            <q-date
                                v-model="form.end_at"
                                mask="DD/MM/YYYY"
                                square
                            >
                                <div class="row items-center justify-end">
                                    <q-btn
                                        label="Ok"
                                        color="primary"
                                        flat
                                        v-close-popup
                                    />
                                </div>
                            </q-date>
                        </q-popup-proxy>
                    </q-input>
                </div>

                <div class="col-12">
                    <q-input
                        outlined
                        v-model="form.link"
                        label="Link *"
                        :bottom-slots="Boolean(errors.link)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.link }} </div>
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
                            Criar indicação
                        </div>
                    </q-btn>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
