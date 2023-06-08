<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        notification: Object,
        errors: Object,
    });

    const form = useForm({
        id: props.notification.id,
        identifier: props.notification.identifier,
        name: props.notification.name,
        send_by_email: props.notification.send_by_email,
        send_by_whatsapp: props.notification.send_by_whatsapp,
        send_by_sms: props.notification.send_by_sms,
        send_by_pusher: props.notification.send_by_pusher,
        content_pusher: props.notification.content_pusher,
        content_email: props.notification.content_email,
        content_sms: props.notification.content_sms,
        content_whatsapp: props.notification.content_whatsapp,
        mandatory: props.notification.mandatory,
        active: props.notification.active,
    });

    const goBack = () => useForm().get(route('admin.notification.index'))
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Notificação | Visualizar" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Visualizar notificação </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Notificações" class="text-grey"/>
                    <q-breadcrumbs-el label="Visualizar notificação" class="text-primary" />
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

                <div class="col-12 col-md-9">
                    <q-input
                        outlined
                        v-model="form.identifier"
                        label="Identificador"
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

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.name"
                        label="Nome *"
                        disable
                    />
                </div>

                <div class="col-12 col-md-12">
                    <q-checkbox
                        v-model="form.mandatory"
                        label="Notificação obrigatória"
                        disable
                    />
                </div>

                <div class="col-12 q-col-gutter-lg">
                    <q-checkbox
                        v-model="form.send_by_whatsapp"
                        label="Enviar por WhatsApp"
                        disable
                    />

                    <q-checkbox
                        v-model="form.send_by_sms"
                        label="Enviar por SMS"
                        disable
                    />

                    <q-checkbox
                        v-model="form.send_by_email"
                        label="Enviar por e-mail"
                        disable
                    />

                    <q-checkbox
                        v-model="form.send_by_pusher"
                        label="Enviar por pusher"
                        disable
                    />
                </div>

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.content_whatsapp"
                        label="Conteúdo WhatsApp"
                        type="textarea"
                        disable
                    />
                </div>

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.content_sms"
                        label="Conteúdo SMS"
                        type="textarea"
                        disable
                    />
                </div>

                <div class="col-12 col-md-12">
                    <div class="q-field__label q-pb-sm">
                        Conteúdo e-mail
                    </div>

                    <q-editor
                        ref="editorContentEmailRef"
                        v-model="form.content_email"
                        disable
                    />
                </div>

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.content_pusher"
                        label="Conteúdo pusher"
                        type="textarea"
                        disable
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
