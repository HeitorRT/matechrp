<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'
    import { ref } from 'vue';

    const $q = useQuasar()

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

    const submit = () => {
        form.put(route("admin.notification.update", form.id), {
            onSuccess: () => {
                $q.notify({
                    type: 'positive',
                    message: 'Notificação atualizado com sucesso',
                    position: 'top',
                })
            },
        })
    };

    const editorContentEmailRef = ref(null)

    const insertImgContentEmail = () => {
        const input = document.createElement('input')
        input.type = 'file'
        input.accept = '.png, .jpg'

        input.onchange = () => {
            const files = Array.from(input.files)
            const reader = new FileReader()

            reader.onloadend = function() {
                const img = document.createElement('img')
                img.src = reader.result;

                const div = document.createElement('div')
                div.append(img)

                const edit = editorContentEmailRef.value
                edit.caret.restore()
                edit.runCmd('insertHTML', div.innerHTML)
                edit.focus()
            }

            reader.readAsDataURL(files[0])
        }

        input.click()
    }

    const insertTagContentEmail = (tag) => {
        const edit = editorContentEmailRef.value
        edit.caret.restore()
        edit.runCmd('insertHTML', tag)
        edit.focus()
    }

    const editorContentPusherRef = ref(null)

    const insertImgContentPusher = () => {
        const input = document.createElement('input')
        input.type = 'file'
        input.accept = '.png, .jpg'

        input.onchange = () => {
            const files = Array.from(input.files)
            const reader = new FileReader()

            reader.onloadend = function() {
                const img = document.createElement('img')
                img.src = reader.result;

                const div = document.createElement('div')
                div.append(img)

                const edit = editorContentPusherRef.value
                edit.caret.restore()
                edit.runCmd('insertHTML', div.innerHTML)
                edit.focus()
            }

            reader.readAsDataURL(files[0])
        }

        input.click()
    }

    const insertTagContentPusher = (tag) => {
        const edit = editorContentPusherRef.value
        edit.caret.restore()
        edit.runCmd('insertHTML', tag)
        edit.focus()
    }

    const tags = [{
        tag: '[[aluno_nome]]',
        label: 'Nome do aluno'
    }, {
        tag: '[[aluno_email]]',
        label: 'E-mail do aluno'
    }, {
        tag: '[[professor_nome]]',
        label: 'Nome do professor'
    }];
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Notificação | Editar" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Editar notificação </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Notificações" class="text-grey"/>
                    <q-breadcrumbs-el label="Editar notificação" class="text-primary" />
                </q-breadcrumbs>
            </div>

            <div class="col-12 col-md-6 flex justify-end items-center">
                <q-btn
                    color="primary"
                    rounded
                    no-caps
                    @click="submit"
                    :disabled="form.processing"
                >
                    <q-icon name="check" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Salvar notificação
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
                    <q-checkbox
                        v-model="form.mandatory"
                        label="Notificação obrigatória"
                    />
                </div>

                <div class="col-12 q-col-gutter-lg">
                    <q-checkbox
                        v-model="form.send_by_whatsapp"
                        label="Enviar por WhatsApp"
                    />

                    <q-checkbox
                        v-model="form.send_by_sms"
                        label="Enviar por SMS"
                    />

                    <q-checkbox
                        v-model="form.send_by_email"
                        label="Enviar por e-mail"
                    />

                    <q-checkbox
                        v-model="form.send_by_pusher"
                        label="Enviar por pusher"
                    />
                </div>

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.content_whatsapp"
                        label="Conteúdo WhatsApp"
                        :bottom-slots="Boolean(errors.content_whatsapp)"
                        type="textarea"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.content_whatsapp }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.content_sms"
                        label="Conteúdo SMS"
                        :bottom-slots="Boolean(errors.content_sms)"
                        type="textarea"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.content_sms }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-12">
                    <div class="q-field__label q-pb-sm">
                        Conteúdo e-mail
                    </div>

                    <q-editor
                        ref="editorContentEmailRef"
                        v-model="form.content_email"
                        :toolbar="[
                            ['left','center','right','justify','bold','italic','underline','strike','undo','redo'],
                            ['upload', 'fullscreen'],
                            [{
                                icon: 'text_fields',
                                list: 'no-icons',
                                options: ['size-1', 'size-2', 'size-3', 'size-4', 'size-5', 'size-6', 'size-7']
                            }],
                            ['tag']
                        ]"
                    >
                        <template v-slot:upload>
                            <q-btn
                                dense
                                unelevated
                                size="sm"
                                icon="o_image"
                                @click="insertImgContentEmail"
                            />
                        </template>
                        <template v-slot:tag>
                            <q-btn-dropdown
                                dense
                                unelevated
                                label="Tag"
                                size="sm"
                            >
                                <q-list dense>
                                    <q-item
                                        v-for="tag in tags"
                                        clickable
                                        @click="insertTagContentEmail(tag.tag)"
                                        v-close-popup
                                    >
                                        <q-item-section>{{ tag.label }}: {{ tag.tag }}</q-item-section>
                                    </q-item>
                                </q-list>
                            </q-btn-dropdown>
                        </template>

                    </q-editor>
                </div>

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.content_pusher"
                        label="Conteúdo pusher"
                        :bottom-slots="Boolean(errors.content_pusher)"
                        type="textarea"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.content_pusher }} </div>
                        </template>
                    </q-input>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
