<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { ref, computed } from 'vue'
    import { useQuasar } from 'quasar'
    import DialogConfirm from '@/Components/Admin/DialogConfirm.vue';
    import { useDropzone } from "vue3-dropzone";

    const $q = useQuasar()

    const props = defineProps({
        content: Object,
        extras: Object,
        errors: Object,
        types: Object,
        players: Object,
    });

    const tab = ref('extras')

    const goMainTab = () => useForm().get(route('admin.content.edit', props.content.id))

    const goTitlesTab = () => useForm().get(route('admin.content.titles', props.content.id))

    const destroy = (extra) => {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Excluir extra ?',
                message: `Tem certeza que deseja ${extra.name}?`,
            },
        }).onOk(() => {
            useForm().delete(route('admin.content.extra.destroy', {
                content: props.content.id,
                extra: extra.id
            }), {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: `Extra ${extra.name} excluido com sucesso`,
                        position: 'top',
                    })
                }
            })
        })
    }

    /** CREATE EXTRA */
    const createModalShow = ref(false)

    const hideCreateModal = () => {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Fechar janela?',
                message: 'Ao fechar esta janela, os dados serão perdidos. Tem certeza que deseja fechar?',
            },
        }).onOk(() => {
            createModalShow.value = false;
            createForm.reset();
        })
    }

    const dropZoneCreateFile = useDropzone({
        onDrop: (acceptFiles, rejectReasons) => {
            if (rejectReasons.length > 0) {
                $q.notify({ message: 'Insira apenas um arquivo', position: 'center' })
            } else {
                createForm.file = acceptFiles[0];
                createForm.is_image = acceptFiles[0].type.includes('image');
            }
        },
        maxFiles: 1
    });

    const createForm = useForm({
        name: null,
        type: 'arquivo',
        player:null,
        embed: null,
        file: null,
        is_image: true
    });

    const storeSubmit = () => {
        createForm.post(route("admin.content.extra.store", {
            content: props.content.id,
        }),{
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                $q.notify({
                    type: 'positive',
                    message: `Extra ${createForm.name} cadastrado com sucesso`,
                    position: 'top',
                })

                createModalShow.value = false;
                createForm.reset();
            },
        })
    };
    /** END CREATE EXTRA */

    /** EDIT EXTRA */
    const editModalShow = ref(false)
    const editOriginalData = ref({})

    const editForm = useForm({
        id: null,
        name: null,
        type: null,
        player:null,
        embed: null,
        file: null
    });

    const updateSubmit = () => {
        editForm
            .transform((data) => ({...data, _method: 'put' }))
            .post(route("admin.content.extra.update", {
                content: props.content.id,
                extra: editForm.id
            }),{
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: `Extra ${editForm.name} atualizado com sucesso`,
                        position: 'top',
                    })

                    editModalShow.value = false;
                    editForm.reset();
                },
            })
    };

    const edit = (extra) => {
        editModalShow.value = true;
        editOriginalData.value = extra;

        editForm.id = extra.id;
        editForm.name = extra.name;
        editForm.type = extra.type;
        editForm.player = extra.player;
        editForm.embed = extra.embed;
        editForm.file = extra.file;
        editForm.is_image = extra.is_image;
    }

    const hideEditModal = () => {
        if (
            editForm.id == editOriginalData.value.id &&
            editForm.name == editOriginalData.value.name &&
            editForm.type == editOriginalData.value.type &&
            editForm.player == editOriginalData.value.player &&
            editForm.embed == editOriginalData.value.embed &&
            editForm.file == editOriginalData.value.file
        ) {
            editModalShow.value = false;
            editForm.reset();
        }
        else
        {
            $q.dialog({
                component: DialogConfirm,
                componentProps: {
                    title: 'Fechar janela?',
                    message: 'Ao fechar esta janela, as alterações serão perdidas. Tem certeza que deseja fechar?',
                },
            }).onOk(() => {
                editModalShow.value = false;
                editForm.reset();
            })
        }
    }

    const dropZoneEditFile = useDropzone({
        onDrop: (acceptFiles, rejectReasons) => {
            if (rejectReasons.length > 0) {
                $q.notify({ message: 'Insira apenas um arquivo', position: 'center' })
            } else {
                editForm.file = acceptFiles[0];
                editForm.is_image = acceptFiles[0].type.includes('image');
            }
        },
        maxFiles: 1
    });

    const removeEditFile = () => editForm.file = null

    /** END EDIT EXTRA */

    const optionsTypes = computed(() => {
        let options = new Array();

        for (const key in props.types) {
            options.push({ label: props.types[key], value: key })
        }

        return options;
    })

    const optionsPlayes = computed(() => {
        let options = new Array();

        for (const key in props.players) {
            options.push({ label: props.players[key], value: key })
        }

        return options;
    })

    const goBack = () => useForm().get(route('admin.content.index'))

    const imageForDoc = 'https://i.pinimg.com/564x/04/54/7c/04547c2b354abb70a85ed8a2d1b33e5f.jpg';

    const handleFile = (extra) => {
        if (extra.file == null) {
            return '';
        }

        if (extra.is_image) {
            return (typeof extra.file === 'object') ? URL.createObjectURL(extra.file) : extra.file;
        }

        return imageForDoc;
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

        <div class="bg-white app-br-16">
            <q-tabs
                v-model="tab"
                dense
                class="text-grey app-br-tl-16 app-br-tr-16"
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
                    @click="goTitlesTab"
                />

                <q-tab
                    name="extras"
                    label="Extras"
                    class="q-py-md"
                />
            </q-tabs>

            <div class="bg-white q-py-lg q-px-lg app-br-16">
                <div v-for="extra in extras" class="row q-col-gutter-lg q-mb-md">
                    <div class="col-12 items-center q-mt-xs">
                        <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                            Extra {{ extra.name }}
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <q-select
                            :options="optionsTypes"
                            outlined
                            v-model="extra.type"
                            label="Extra"
                            emit-value
                            map-options
                            disable
                        />
                    </div>

                    <div class="col-12 col-md-6">
                        <q-input
                            outlined
                            v-model="extra.name"
                            label="Nome do extra"
                            disable
                        />
                    </div>

                    <div class="col-12 col-md-6" v-if="extra.type !== 'arquivo'">
                        <q-select
                            :options="optionsPlayes"
                            outlined
                            v-model="extra.player"
                            label="Tipo de player"
                            emit-value
                            map-options
                            disable
                       />
                    </div>

                    <div class="col-12 col-md-6" v-if="extra.type !== 'arquivo'">
                        <q-input
                            outlined
                            v-model="extra.embed"
                            label="Código embed"
                            disable
                        >
                            <template v-slot:after>
                                <q-btn-group flat>
                                    <q-btn
                                        color="negative"
                                        @click="destroy(extra)"
                                        flat
                                        icon="close"
                                        padding="xs"
                                    />
                                    <q-btn
                                        color="primary"
                                        @click="edit(extra)"
                                        flat
                                        icon="o_edit"
                                        padding="xs"
                                    />
                                </q-btn-group>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12" v-if="extra.type === 'arquivo'">
                        <q-img
                            :src="handleFile(extra)"
                            style="height: 400px"
                            class="app-br-16"
                        />
                    </div>

                    <div class="col-12 flex justify-end" v-if="extra.type === 'arquivo'">
                        <q-btn-group flat>
                            <q-btn
                                color="negative"
                                @click="destroy(extra)"
                                flat
                                icon="close"
                                padding="xs"
                            />
                            <q-btn
                                color="primary"
                                @click="edit(extra)"
                                flat
                                icon="o_edit"
                                padding="xs"
                            />
                        </q-btn-group>
                    </div>
                </div>

                <div class="flex flex-center">
                    <q-btn
                        color="primary"
                        no-caps
                        flat
                        @click="createModalShow = true"
                    >
                        <q-icon name="add" size="xs"/>

                        <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                            Adicionar extra
                        </div>
                    </q-btn>
                </div>
            </div>
        </div>

        <q-dialog v-model="editModalShow" persistent>
            <q-card
                style="width: 1000px; max-width: 80vw;"
                class="app-br-16 q-my-sm q-pa-sm"
            >
                <q-card-section class="row q-col-gutter-lg">
                    <div class="col-12 items-center q-mt-xs row justify-between">
                        <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                            Editar extra
                        </div>

                        <q-btn
                            color="primary"
                            @click="hideEditModal"
                            flat
                        >
                            <q-icon name="close" size="xs"/>
                        </q-btn>
                    </div>

                    <div class="col-12 col-md-6">
                        <q-select
                            :options="optionsTypes"
                            outlined
                            v-model="editForm.type"
                            label="Extra"
                            emit-value
                            map-options
                            :bottom-slots="Boolean(editForm.errors.type)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ editForm.errors.type }} </div>
                            </template>
                        </q-select>
                    </div>

                    <div class="col-12 col-md-6">
                        <q-input
                            outlined
                            v-model="editForm.name"
                            label="Nome do extra"
                            :bottom-slots="Boolean(editForm.errors.name)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ editForm.errors.name }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 col-md-6" v-if="editForm.type !== 'arquivo'">
                        <q-select
                            :options="optionsPlayes"
                            outlined
                            v-model="editForm.player"
                            label="Tipo de player"
                            emit-value
                            map-options
                            :bottom-slots="Boolean(editForm.errors.player)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ editForm.errors.player }} </div>
                            </template>
                        </q-select>
                    </div>

                    <div class="col-12 col-md-6" v-if="editForm.type !== 'arquivo'">
                        <q-input
                            outlined
                            v-model="editForm.embed"
                            label="Código embed"
                            :bottom-slots="Boolean(editForm.errors.embed)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ editForm.errors.embed }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 text-center text-red" v-if="editForm.errors.file">
                        {{ editForm.errors.file }}
                    </div>

                    <div
                        class="col-12"
                        v-if="editForm.type === 'arquivo' && editForm.file"
                    >
                        <q-img
                            :src="handleFile(editForm)"
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
                                    @click="removeEditFile"
                                />

                                <div class="flex cursor-pointer" v-bind="dropZoneEditFile.getRootProps()">
                                    <input v-bind="dropZoneEditFile.getInputProps()"/>
                                    Alterar arquivo
                                </div>
                            </div>
                        </q-img>
                    </div>

                    <div
                        class="col-12"
                        v-if="editForm.type === 'arquivo' && !editForm.file"
                    >
                        <div
                            v-bind="dropZoneEditFile.getRootProps()"
                            class="column flex-center q-py-lg text-grey adm-border-dashed-blue app-br-16"
                        >
                            <input v-bind="dropZoneEditFile.getInputProps()"/>

                            <q-icon name="o_photo" size="md"/>

                            <div class="q-mt-sm">
                                Clique aqui ou arraste seu arquivo
                            </div>
                        </div>
                    </div>

                    <div class="col-12 row justify-end">
                        <q-btn
                            color="primary"
                            rounded
                            no-caps
                            @click="hideEditModal"
                            size="sm"
                            class="q-my-md"
                            outline
                        >
                            <q-icon name="close" size="xs"/>

                            <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                                Cancelar
                            </div>
                        </q-btn>

                        <q-btn
                            color="primary"
                            rounded
                            no-caps
                            :disabled="editForm.processing"
                            size="sm"
                            class="q-my-md q-ml-sm"
                            @click="updateSubmit"
                        >
                            <q-icon name="check" size="xs"/>

                            <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                                Atualizar
                            </div>
                        </q-btn>
                    </div>
                </q-card-section>
            </q-card>
        </q-dialog>

        <q-dialog v-model="createModalShow" persistent>
            <q-card
                style="width: 1000px; max-width: 80vw;"
                class="app-br-16 q-my-sm q-pa-sm"
            >
                <q-card-section class="row q-col-gutter-lg">
                    <div class="col-12 items-center q-mt-xs row justify-between">
                        <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                            Adicionar extra
                        </div>

                        <q-btn
                            color="primary"
                            @click="hideCreateModal"
                            flat
                        >
                            <q-icon name="close" size="xs"/>
                        </q-btn>
                    </div>

                    <div class="col-12 col-md-6">
                        <q-select
                            :options="optionsTypes"
                            outlined
                            v-model="createForm.type"
                            label="Extra"
                            emit-value
                            map-options
                            :bottom-slots="Boolean(createForm.errors.type)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ createForm.errors.type }} </div>
                            </template>
                        </q-select>
                    </div>

                    <div class="col-12 col-md-6">
                        <q-input
                            outlined
                            v-model="createForm.name"
                            label="Nome do extra"
                            :bottom-slots="Boolean(createForm.errors.name)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ createForm.errors.name }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 col-md-6" v-if="createForm.type !== 'arquivo'">
                        <q-select
                            :options="optionsPlayes"
                            outlined
                            v-model="createForm.player"
                            label="Tipo de player"
                            emit-value
                            map-options
                            :bottom-slots="Boolean(createForm.errors.player)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ createForm.errors.player }} </div>
                            </template>
                        </q-select>
                    </div>

                    <div class="col-12 col-md-6" v-if="createForm.type !== 'arquivo'">
                        <q-input
                            outlined
                            v-model="createForm.embed"
                            label="Código embed"
                            :bottom-slots="Boolean(createForm.errors.embed)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ createForm.errors.embed }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 text-center text-red" v-if="createForm.errors.file">
                        {{ createForm.errors.file }}
                    </div>

                    <div
                        class="col-12"
                        v-if="createForm.type === 'arquivo' && createForm.file"
                    >
                        <q-img
                            :src="handleFile(createForm)"
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
                                    @click="removeEditFile"
                                />

                                <div class="flex cursor-pointer" v-bind="dropZoneCreateFile.getRootProps()">
                                    <input v-bind="dropZoneCreateFile.getInputProps()"/>
                                    Alterar arquivo
                                </div>
                            </div>
                        </q-img>
                    </div>

                    <div
                        class="col-12"
                        v-if="createForm.type === 'arquivo' && !createForm.file"
                    >
                        <div
                            v-bind="dropZoneCreateFile.getRootProps()"
                            class="column flex-center q-py-lg text-grey adm-border-dashed-blue app-br-16"
                        >
                            <input v-bind="dropZoneCreateFile.getInputProps()"/>

                            <q-icon name="o_photo" size="md"/>

                            <div class="q-mt-sm">
                                Clique aqui ou arraste seu arquivo
                            </div>
                        </div>
                    </div>

                    <div class="col-12 row justify-end">
                        <q-btn
                            color="primary"
                            rounded
                            no-caps
                            @click="hideCreateModal"
                            size="sm"
                            class="q-my-md"
                            outline
                        >
                            <q-icon name="close" size="xs"/>

                            <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                                Cancelar
                            </div>
                        </q-btn>

                        <q-btn
                            color="primary"
                            rounded
                            no-caps
                            :disabled="createForm.processing"
                            size="sm"
                            class="q-my-md q-ml-sm"
                            @click="storeSubmit"
                        >
                            <q-icon name="check" size="xs"/>

                            <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                                Cadastrar
                            </div>
                        </q-btn>
                    </div>
                </q-card-section>
            </q-card>
        </q-dialog>
    </AuthenticatedLayout>
</template>
