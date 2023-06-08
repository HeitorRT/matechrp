<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { ref, computed } from 'vue'
    import { useQuasar } from 'quasar'
    import { useDropzone } from "vue3-dropzone";
    import DialogConfirm from '@/Components/Admin/DialogConfirm.vue';

    const $q = useQuasar()

    const props = defineProps({
        content: Object,
        season: Object,
        errors: Object,
        numbers: Array
    });

    const form = useForm({
        id: props.season.id,
        name: props.season.name,
        number_of_chapters: props.season.number_of_chapters,
        number: props.season.number,
        image: props.season.image,
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

    const imageSrc = computed(() => {
        return form.image == null ? '' : (typeof form.image === 'object') ? URL.createObjectURL(form.image) : form.image;
    });

    const removeImage = () => form.image = null;

    const submit = () => {
        form
            .transform((data) => ({...data, _method: 'put' }))
            .post(route("admin.content.season.update", {
                content: props.content.id,
                season: props.season.id,
            }), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: `Temporada ${form.name} atualizada com sucesso`,
                        position: 'top',
                    })
                },
            })
    };

    function destroy() {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Excluir temporada',
                message: 'Tem certeza que deseja excluir essa temporada?',
            },
        }).onOk(() => {
            useForm().delete(route('admin.content.season.destroy', {
                content: props.content.id,
                season: props.season.id,
            }), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Temporada excluído com sucesso',
                        position: 'top',
                    })
                }
            })
        });
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head :title="content.name" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8">
                    Editar temporada: {{ season.name }}
                </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Conteúdos" class="text-grey"/>
                    <q-breadcrumbs-el :label="content.name" class="text-grey"/>
                    <q-breadcrumbs-el :label="`Editar temporada: ${season.name}`" class="text-primary" />
                </q-breadcrumbs>
            </div>

            <div class="col-12 col-md-6 flex justify-end items-center">
                <q-btn
                    color="negative"
                    class="q-mr-md"
                    rounded
                    no-caps
                    outline
                    @click="destroy"
                >
                    <q-icon name="close" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Excluir temporada
                    </div>
                </q-btn>

                <q-btn
                    color="primary"
                    rounded
                    no-caps
                    @click="submit"
                    :disabled="form.processing"
                >
                    <q-icon name="check" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Salvar
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

                <div class="col-12 col-md-3">
                    <q-select
                        option-value="position"
                        :options="numbers"
                        :option-disable="opt => !opt.empty"
                        :option-label="opt => !opt.empty ? `${opt.position} (em uso)` : opt.position"
                        emit-value
                        map-options
                        outlined
                        v-model="form.number"
                        label="Número da temporada *"
                        :bottom-slots="Boolean(errors.number)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.number }} </div>
                        </template>
                    </q-select>
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="form.name"
                        label="Nome"
                        :bottom-slots="Boolean(errors.name)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.name }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-3">
                    <q-select
                        :options="[...Array(50).keys()].map(i => ++i)"
                        :option-disable="opt => opt < season.count_chapters"
                        :option-label="opt => opt < season.count_chapters ? `${opt} (desabilitado)` : opt"
                        outlined
                        v-model="form.number_of_chapters"
                        label="Quantidade de episódios"
                        :bottom-slots="Boolean(errors.number_of_chapters)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.number_of_chapters }} </div>
                        </template>
                    </q-select>
                </div>

                <div class="col-12 items-center q-mt-xs">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Capa principal

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

                <div class="col-12" v-if="imageSrc">
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
            </div>
        </div>
    </AuthenticatedLayout>
</template>
