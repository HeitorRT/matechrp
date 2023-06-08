<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'

    const $q = useQuasar()

    const props = defineProps({
        systemSetting: Object,
        errors: Object,
        canSystemSettingEdit: Boolean
    });

    const form = useForm({
        script: props.systemSetting.script,
    });

    const submit = () => {
        form.put(route("admin.system-setting.update", form.id), {
            onSuccess: () => {
                $q.notify({
                    type: 'positive',
                    message: 'Configurações atualizadas com sucesso',
                    position: 'top',
                })
            },
        })
    };
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Configurações de sistema" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Configurações de sistema </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Configurações de sistema" class="text-grey"/>
                </q-breadcrumbs>
            </div>

            <div class="col-12 col-md-6 flex justify-end items-center">
                <q-btn
                    color="primary"
                    rounded
                    no-caps
                    @click="submit"
                    :disabled="form.processing"
                    v-if="canSystemSettingEdit"
                >
                    <q-icon name="check" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Salvar configurações
                    </div>
                </q-btn>
            </div>
        </div>

        <div class="bg-white q-py-lg q-px-lg app-br-16">
            <div class="row q-col-gutter-lg">
                <div class="col-12 items-center q-mt-xs">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Configurações
                    </div>
                </div>

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.script"
                        label="Script"
                        :bottom-slots="Boolean(errors.script)"
                        type="textarea"
                        :disable="! canSystemSettingEdit"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.script }} </div>
                        </template>
                    </q-input>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
