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

    const tab = ref('titles')

    const goExtraTab = () => useForm().get(route('admin.content.extra.show-list', props.content.id))

    const goMainTab = () => useForm().get(route('admin.content.show', props.content.id));

    const goBack = () => useForm().get(route('admin.content.index'))

</script>

<template>
    <AuthenticatedLayout>
        <Head :title="`Visualizar títulos: ${content.name}`" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8">
                    Visualizar {{ content.name }}
                </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Conteúdos" class="text-grey"/>
                    <q-breadcrumbs-el :label="`Visualizar títulos: ${content.name}`" class="text-primary" />
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
                            label="Nome do episódio"
                            disable
                        />
                    </div>

                    <div class="col-12 col-md-3">
                        <q-input
                            outlined
                            v-model="form.duration"
                            mask="##:##"
                            label="Duração"
                            disable
                        />
                    </div>

                    <div class="col-12 col-md-9">
                        <q-input
                            outlined
                            v-model="form.cast"
                            label="Elenco"
                            disable
                        />
                    </div>

                    <div class="col-12 col-md-3">
                        <q-input
                            outlined
                            v-model="form.direction"
                            label="Direção"
                            disable
                        />
                    </div>

                    <div class="col-12">
                        <q-input
                            outlined
                            v-model="form.description"
                            label="Descrição"
                            type="textarea"
                            clearable
                            disable
                        />
                    </div>

                    <div class="col-12">
                        <div class="q-gutter-sm row items-center">
                            <div> Autor da produção: </div>

                            <q-radio v-model="form.main_player" val="vimeo" label="Vimeo" disable />
                            <q-radio v-model="form.main_player" val="sambatech" label="Sambatech" disable />
                            <q-radio v-model="form.main_player" val="outros" label="Outros" disable />
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <q-input
                            outlined
                            v-model="form.vimeo_link"
                            label="Link do Vimeo"
                            disable
                        />
                    </div>

                    <div class="col-12 col-md-8">
                        <q-input
                            outlined
                            v-model="form.vimeo_embed"
                            label="Código embed Vimeo"
                            disable
                        />
                    </div>

                    <div class="col-12 col-md-4">
                        <q-input
                            outlined
                            v-model="form.sambatech_link"
                            label="Link do Sambatech"
                            disable
                        />
                    </div>

                    <div class="col-12 col-md-8">
                        <q-input
                            outlined
                            v-model="form.sambatech_embed"
                            label="Código embed Sambatech"
                            disable
                        />
                    </div>

                    <div class="col-12">
                        <q-input
                            outlined
                            v-model="form.embed"
                            label="Link do embed"
                            disable
                        />
                    </div>

                    <div class="col-12 items-center q-mt-xs">
                        <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                            Imagem opcional
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
                            </div>
                        </q-img>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
