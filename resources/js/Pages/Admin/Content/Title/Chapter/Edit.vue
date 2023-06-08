<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { ref, computed } from 'vue';
    import { useDropzone } from "vue3-dropzone";
    import { useQuasar } from 'quasar'

    const $q = useQuasar()

    const props = defineProps({
        content: Object,
        chapter: Object,
        errors: Object,
    });

    const form = useForm({
        name: props.chapter.name,
        number: 1,
        duration : props.chapter.duration,
        cast : props.chapter.cast,
        direction : props.chapter.direction,
        main_player : props.chapter.main_player,
        vimeo_link : props.chapter.vimeo_link,
        vimeo_embed : props.chapter.vimeo_embed,
        sambatech_link : props.chapter.sambatech_link,
        sambatech_embed : props.chapter.sambatech_embed,
        image: props.chapter.image,
        description: props.chapter.description,
        embed: props.chapter.embed,
    });

    const imageSrc = computed(() => {
        return form.image == null ? '' : (typeof form.image === 'object') ? URL.createObjectURL(form.image) : form.image;
    });

    const dropZoneImage = useDropzone({
        onDrop: (acceptFiles, rejectReasons) => {
            if (rejectReasons.length > 0) {
                $q.notify({ message: 'Insira apenas uma imagem', position: 'center' })
            } else {
                form.image = acceptFiles[0];
            }
        },
        accept: ['image/*'],
        maxFiles: 1
    });

    const removeImage = () => form.image = null;

    const submit = () => {
        form
            .transform((data) => ({...data, _method: 'put' }))
            .post(route("admin.content.chapter.update", {
                content: props.content.id,
                chapter: props.chapter.id
            }), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Conteúdo atualizado com sucesso',
                        position: 'top',
                    })
                },
            })
    };

    const tab = ref('titles')

    const goExtraTab = () => {
        if (form.isDirty) {
            tab.value = 'main';

            $q.dialog({
                component: AdminDialog,
                componentProps: {
                    title: 'Alterações não salvas',
                    message: 'Ao sair suas alterações serão perdidas. Tem certeza disso?',
                    confirm: true
                }
            }).onOk(() => {
                useForm().get(route('admin.content.extra.index', props.content.id))
            })
        } else {
            useForm().get(route('admin.content.extra.index', props.content.id))
        }
    };

    const goMainTab = () => {
        if (form.isDirty) {
            tab.value = 'main';

            $q.dialog({
                component: AdminDialog,
                componentProps: {
                    title: 'Alterações não salvas',
                    message: 'Ao sair suas alterações serão perdidas. Tem certeza disso?',
                    confirm: true
                }
            }).onOk(() => {
                useForm().get(route('admin.content.edit', props.content.id))
            })
        } else {
            useForm().get(route('admin.content.edit', props.content.id))
        }
    }

    const goBack = () => {
        if (form.isDirty) {
            tab.value = 'main';

            $q.dialog({
                component: AdminDialog,
                componentProps: {
                    title: 'Alterações não salvas',
                    message: 'Ao sair suas alterações serão perdidas. Tem certeza disso?',
                    confirm: true
                },
            }).onOk(() => {
                useForm().get(route('admin.content.index'))
            })
        } else {
            useForm().get(route('admin.content.index'))
        }
    };
</script>

<template>
    <AuthenticatedLayout>
        <Head :title="content.name" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8">
                    {{ content.name }}
                </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Conteúdos" class="text-grey"/>
                    <q-breadcrumbs-el :label="content.name" class="text-primary" />
                </q-breadcrumbs>
            </div>
        </div>

        <div class="bg-white app-br-16">
            <q-tabs
                v-model="tab"
                dense
                class="text-grey"
                active-color="primary"
                indicator-color="primary"
                align="justify"
                no-caps
            >
                <q-tab
                    name="main"
                    label="Dados do conteúdo"
                    class="q-py-md"
                    @click="goMainTab"
                />

                <q-tab
                    name="titles"
                    label="Títulos"
                    class="q-py-md"
                />

                <q-tab
                    name="extras"
                    label="Extras"
                    class="q-py-md"
                    @click="goExtraTab"
                />
            </q-tabs>

            <div class="bg-white q-py-lg q-px-lg app-br-16">
                <div class="row q-col-gutter-lg">
                    <div class="col-12 items-center q-mt-xs">
                        <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                            Editar episódio
                        </div>
                    </div>

                    <div class="col-12 col-md-9">
                        <q-input
                            outlined
                            v-model="form.name"
                            label="Nome do episódio *"
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
                            v-model="form.duration"
                            mask="##:##"
                            label="Duração"
                            :bottom-slots="Boolean(errors.duration)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.duration }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 col-md-9">
                        <q-input
                            outlined
                            v-model="form.cast"
                            label="Elenco"
                            :bottom-slots="Boolean(errors.cast)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.cast }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 col-md-3">
                        <q-input
                            outlined
                            v-model="form.direction"
                            label="Direção"
                            :bottom-slots="Boolean(errors.direction)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.direction }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12">
                        <q-input
                            outlined
                            v-model="form.description"
                            label="Descrição"
                            :bottom-slots="Boolean(errors.description)"
                            type="textarea"
                            clearable
                            max_length="500"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.description }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12">
                        <div class="q-gutter-sm row items-center">
                            <div> Player do vídeo: </div>

                            <q-radio v-model="form.main_player" val="vimeo" label="Vimeo" />
                            <q-radio v-model="form.main_player" val="sambatech" label="Sambatech" />
                            <q-radio v-model="form.main_player" val="outros" label="Outros" />
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <q-input
                            outlined
                            v-model="form.vimeo_link"
                            label="Link do Vimeo"
                            :bottom-slots="Boolean(errors.vimeo_link)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.vimeo_link }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 col-md-8">
                        <q-input
                            outlined
                            v-model="form.vimeo_embed"
                            label="Código embed Vimeo"
                            :bottom-slots="Boolean(errors.vimeo_embed)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.vimeo_embed }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 col-md-4">
                        <q-input
                            outlined
                            v-model="form.sambatech_link"
                            label="Link do Sambatech"
                            :bottom-slots="Boolean(errors.sambatech_link)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.sambatech_link }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 col-md-8">
                        <q-input
                            outlined
                            v-model="form.sambatech_embed"
                            label="Código embed Sambatech"
                            :bottom-slots="Boolean(errors.sambatech_embed)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.sambatech_embed }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12">
                        <q-input
                            outlined
                            v-model="form.embed"
                            label="Link do embed"
                            :bottom-slots="Boolean(errors.embed)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.embed }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 items-center q-mt-xs">
                        <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                            Imagem opcional

                            <q-icon
                                name="help_outline"
                                size="xs"
                                class="cursor-pointer"
                            >
                                <q-tooltip
                                    anchor="center right"
                                    self="center left"
                                    :offset="[10, 10]"
                                    class="text-body2 bg-grey-10"
                                >
                                    Tamanho recomendado: 800px X 600px
                                </q-tooltip>
                            </q-icon>
                        </div>
                    </div>

                    <div class="col-12 col-md-4" v-if="imageSrc">
                        <q-img
                            :src="imageSrc"
                            style="height: 400px"
                            class="app-br-16"
                        >
                            <div class="absolute-bottom text-subtitle2 row items-center">
                                <q-icon name="o_photo" size="md" class="q-mr-md"/>

                                <q-btn
                                    color="white"
                                    class="absolute"
                                    style="top: 8px; right: 8px"
                                    flat
                                    icon="close"
                                    size="md"
                                    @click="removeImage"
                                />

                                <div class="flex cursor-pointer" v-bind="dropZoneImage.getRootProps()">
                                    <input v-bind="dropZoneImage.getInputProps()"/>
                                    Alterar imagem
                                </div>
                            </div>
                        </q-img>
                    </div>

                    <div class="col-12" v-else>
                        <div
                            v-bind="dropZoneImage.getRootProps()"
                            class="column flex-center q-py-lg text-grey adm-border-dashed-blue app-br-16"
                        >
                            <input v-bind="dropZoneImage.getInputProps()"/>

                            <q-icon name="o_photo" size="md"/>

                            <div class="q-mt-sm">
                                Clique aqui ou arraste sua imagem
                            </div>
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
                                Salvar
                            </div>
                        </q-btn>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
