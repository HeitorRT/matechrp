<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { ref, computed } from 'vue';
    import { useQuasar } from 'quasar'
    import DialogConfirm from '@/Components/Admin/DialogConfirm.vue';
    import { useDropzone } from "vue3-dropzone";

    const $q = useQuasar()

    const props = defineProps({
        content: Object,
        seasons: Object,
        errors: Object,
    });

    const tab = ref('titles')

    const showSeason = (id) => useForm().get(route('admin.content.season.show', {
        content: props.content.id,
        season: id
    }));

    const chaptersSelected = ref([])


    const optionsNumberOfChapterCreateModal = computed(() => {
        let options = new Array();

        for (let i = 1; i <= createChapterSeason.value.number_of_chapters; i++) {
            options.push({
                position: i,
                empty: createChapterSeason.value.chapters.filter(chap => chap.number === i).length === 0
            });
        }

        return options;
    });

    /** */
    const showChapterModalShow = ref(false)

    const showChapterForm = useForm({
        id: null,
        name: null,
        number: null,
        duration : null,
        cast : null,
        direction : null,
        main_player : 'vimeo',
        vimeo_link : null,
        vimeo_embed : null,
        sambatech_link : null,
        sambatech_embed : null,
        image: null,
        description: null,
        embed: null,
    });

    const showShowChapterModal = (chapter) => {
        showChapterModalShow.value = true;

        showChapterForm.id = chapter.id;
        showChapterForm.name = chapter.name;
        showChapterForm.number = chapter.number;
        showChapterForm.duration  = chapter.duration;
        showChapterForm.cast  = chapter.cast;
        showChapterForm.direction  = chapter.direction;
        showChapterForm.main_player  = chapter.main_player;
        showChapterForm.vimeo_link  = chapter.vimeo_link;
        showChapterForm.vimeo_embed  = chapter.vimeo_embed;
        showChapterForm.sambatech_link  = chapter.sambatech_link;
        showChapterForm.sambatech_embed  = chapter.sambatech_embed;
        showChapterForm.image = chapter.image;
        showChapterForm.description = chapter.description;
        showChapterForm.embed = chapter.embed;
    }

    const hideShowChapterModal = () => {
        showChapterModalShow.value = false;
        showChapterForm.reset();
    }

    const imageChapterShowSrc = computed(() => {
        return showChapterForm.image == null ? '' : (typeof showChapterForm.image === 'object') ? URL.createObjectURL(showChapterForm.image) : showChapterForm.image;
    });

    const goMainTab = () => useForm().get(route('admin.content.show', props.content.id))

    const goExtraTab = () => useForm().get(route('admin.content.extra.show-list', props.content.id))

    const goBack = () => useForm().get(route('admin.content.show', props.content.id))

</script>

<template>
    <AuthenticatedLayout>
        <Head :title="`Visualizar temporadas ${content.name}`" />

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
                    <q-breadcrumbs-el :label="`Visualizar temporadas: ${content.name}`" class="text-primary" />
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

        <div class="bg-white app-br-16" >
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
                />

                <q-tab
                    name="extras"
                    label="Extras"
                    class="q-py-md"
                    @click="goExtraTab"
                />
            </q-tabs>

            <div
                v-if="seasons.length == 0"
                class="q-py-lg q-px-lg app-br-16 flex flex-center text-grey"
                style="height: 416px;"
            >
                Nenhum título adicionado
            </div>

            <div v-else class="bg-white q-pa-lg app-br-16">
                <q-card
                    v-for="season in seasons"
                    flat
                    bordered
                    class="q-mt-sm app-br-16"
                >
                    <q-card-section class="q-pa-none">
                        <q-expansion-item header-class="q-pa-none app-br-tl-16 app-br-tr-16">
                            <template v-slot:header>
                                <div class="row full-width">
                                    <div class="col-2 ">
                                        <q-img
                                            :src="season.image"
                                            style="min-height: 152px;"
                                            class="app-br-tl-16"
                                        />
                                    </div>

                                    <div class="col-9 column justify-center q-pl-md">
                                        <div class="app-fs-16 app-lh-24 app-fw-700 text-grey-8">
                                            Temporada {{ season.number }}: {{ season.name }}
                                        </div>
                                        <div class="text-grey-8">
                                            {{ season.chapters.length ?? 0 }} de {{ season.number_of_chapters }} episódios adicionados
                                        </div>
                                    </div>

                                    <div class="col-1 flex items-center justify-end">
                                        <q-btn icon="visibility" flat @click="showSeason(season.id)">
                                        </q-btn>
                                    </div>
                                </div>
                            </template>

                            <template v-slot:default>
                                <div class="q-pa-md">
                                    <div
                                        v-if="season.chapters.length == 0"
                                        class="app-br-16 flex flex-center text-grey"
                                    >
                                        Nenhum episódio adicionado
                                    </div>

                                    <q-markup-table
                                        v-else
                                        class="text-grey-8"
                                        flat
                                        dense
                                    >
                                        <thead>
                                            <tr>
                                                <th class="text-left">
                                                </th>
                                                <th class="text-left">
                                                    <div class="app-fw-700 app-fs-16">
                                                        Capa
                                                    </div>
                                                </th>
                                                <th class="text-left">
                                                    <div class="app-fw-700 app-fs-16">
                                                        Número
                                                    </div>
                                                </th>
                                                <th class="text-left">
                                                    <div class="app-fw-700 app-fs-16">
                                                        Nome do episódio
                                                    </div>
                                                </th>
                                                <th class="text-left">
                                                    <div class="app-fw-700 app-fs-16">
                                                        Duração
                                                    </div>
                                                </th>
                                                <th class="text-left">
                                                    <div class="app-fw-700 app-fs-16">
                                                        Player principal
                                                    </div>
                                                </th>
                                                <th class="text-left">
                                                    <div class="app-fw-700 app-fs-16">
                                                        Ação
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="chapter in season.chapters">
                                                <td>
                                                    <q-checkbox
                                                        v-model="chaptersSelected"
                                                        :val="chapter.id"
                                                        disable
                                                    />
                                                </td>
                                                <td class="text-left" style="padding: 0">
                                                    <q-img
                                                        :src="chapter.image"
                                                        style="height: 56px; width: 176px;"
                                                    />
                                                </td>
                                                <td class="text-left">{{ chapter.number }}</td>
                                                <td class="text-left">{{ chapter.name }}</td>
                                                <td class="text-left">{{ chapter.duration }}</td>
                                                <td class="text-left">{{ chapter.main_player.replace(/^./, str => str.toUpperCase()) }}</td>
                                                <td>
                                                    <q-btn icon="visibility" flat @click="showShowChapterModal(chapter)">
                                                    </q-btn>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </q-markup-table>
                                </div>
                            </template>
                        </q-expansion-item>
                    </q-card-section>

                    <q-separator />

                    <q-card-section class="q-pa-none" v-if="season.number_of_chapters > season.chapters.length">
                        <q-btn
                            color="primary"
                            no-caps
                            flat
                            class="fit q-py-lg"
                            @click="showCreateChapterModal(season)"
                        >
                            <q-icon name="add" size="xs"/>

                            <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                                Adicionar episódio
                            </div>
                        </q-btn>
                    </q-card-section>
                </q-card>
            </div>
        </div>

        <q-dialog v-model="createChapterModalShow" persistent>
            <q-card style="width: 80vw; max-width: 80vw;">
                <div class="bg-white q-py-lg q-px-lg app-br-16">
                    <div class="row q-col-gutter-lg">
                        <div class="col-12 items-center q-mt-xs row justify-between">
                            <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                                Adicionar episódio
                            </div>

                            <q-btn
                                color="primary"
                                @click="hideCreateChapterModal"
                                flat
                            >
                                <q-icon name="close" size="xs"/>
                            </q-btn>
                        </div>

                        <div class="col-12 col-md-2">
                            <q-select
                                option-value="position"
                                :options="optionsNumberOfChapterCreateModal"
                                outlined
                                v-model="createChapterForm.number"
                                label="Número do episódio"
                                :bottom-slots="Boolean(createChapterForm.errors.number)"
                                emit-value
                                map-options
                                :option-disable="opt => !opt.empty"
                                :option-label="opt => !opt.empty ? `${opt.position} (em uso)` : opt.position"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ createChapterForm.errors.number }} </div>
                                </template>
                            </q-select>
                        </div>

                        <div class="col-12 col-md-7">
                            <q-input
                                outlined
                                v-model="createChapterForm.name"
                                label="Nome do episódio"
                                :bottom-slots="Boolean(createChapterForm.errors.name)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ createChapterForm.errors.name }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12 col-md-3">
                            <q-input
                                outlined
                                v-model="createChapterForm.duration"
                                mask="##:##"
                                label="Duração"
                                :bottom-slots="Boolean(createChapterForm.errors.duration)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ createChapterForm.errors.duration }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12 col-md-9">
                            <q-input
                                outlined
                                v-model="createChapterForm.cast"
                                label="Elenco"
                                :bottom-slots="Boolean(createChapterForm.errors.cast)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ createChapterForm.errors.cast }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12 col-md-3">
                            <q-input
                                outlined
                                v-model="createChapterForm.direction"
                                label="Direção"
                                :bottom-slots="Boolean(createChapterForm.errors.direction)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ createChapterForm.errors.direction }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12">
                            <q-input
                                outlined
                                v-model="createChapterForm.description"
                                label="Descrição"
                                :bottom-slots="Boolean(createChapterForm.errors.description)"
                                type="textarea"
                                clearable
                                max_length="500"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ createChapterForm.errors.description }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12">
                            <q-input
                                outlined
                                v-model="createChapterForm.embed"
                                label="Link do embed"
                                :bottom-slots="Boolean(createChapterForm.errors.embed)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ createChapterForm.errors.embed }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12">
                            <div class="q-gutter-sm row items-center">
                                <div> Autor da produção: </div>

                                <q-radio v-model="createChapterForm.main_player" val="vimeo" label="Vimeo" />
                                <q-radio v-model="createChapterForm.main_player" val="sambatech" label="Sambatech" />
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <q-input
                                outlined
                                v-model="createChapterForm.vimeo_link"
                                label="Link do Vimeo"
                                :bottom-slots="Boolean(createChapterForm.errors.vimeo_link)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ createChapterForm.errors.vimeo_link }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12 col-md-8">
                            <q-input
                                outlined
                                v-model="createChapterForm.vimeo_embed"
                                label="Código embed Vimeo"
                                :bottom-slots="Boolean(createChapterForm.errors.vimeo_embed)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ createChapterForm.errors.vimeo_embed }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12 col-md-4">
                            <q-input
                                outlined
                                v-model="createChapterForm.sambatech_link"
                                label="Link do Sambatech"
                                :bottom-slots="Boolean(createChapterForm.errors.sambatech_link)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ createChapterForm.errors.sambatech_link }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12 col-md-8">
                            <q-input
                                outlined
                                v-model="createChapterForm.sambatech_embed"
                                label="Código embed Sambatech"
                                :bottom-slots="Boolean(createChapterForm.errors.sambatech_embed)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ createChapterForm.errors.sambatech_embed }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12 items-center q-mt-xs">
                            <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                                Imagem opcional
                            </div>
                        </div>

                        <div class="col-12 col-md-4" v-if="imageChapterCreateSrc">
                            <q-img
                                :src="imageChapterCreateSrc"
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
                                        @click="removeChapterCreateImage"
                                    />

                                    <div class="flex cursor-pointer" v-bind="dropZoneCreateChapterImage.getRootProps()">
                                        <input v-bind="dropZoneCreateChapterImage.getInputProps()"/>
                                        Alterar imagem
                                    </div>
                                </div>
                            </q-img>
                        </div>

                        <div class="col-12" v-else>
                            <div
                                v-bind="dropZoneCreateChapterImage.getRootProps()"
                                class="column flex-center q-py-lg text-grey adm-border-dashed-blue app-br-16"
                            >
                                <input v-bind="dropZoneCreateChapterImage.getInputProps()"/>

                                <q-icon name="o_photo" size="md"/>

                                <div class="q-mt-sm">
                                    Clique aqui ou arraste sua imagem
                                </div>
                            </div>
                        </div>


                        <div class="col-12 flex justify-end items-center">
                            <q-btn
                                color="primary"
                                rounded
                                no-caps
                                @click="hideCreateChapterModal"
                                class="q-mr-sm"
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
                                @click="storeChapterSubmit"
                                :disabled="createChapterForm.processing"
                            >
                                <q-icon name="add" size="xs"/>

                                <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                                    Salvar
                                </div>
                            </q-btn>
                        </div>
                    </div>
                </div>
            </q-card>
        </q-dialog>

        <q-dialog v-model="editChapterModalShow" persistent>
            <q-card style="width: 80vw; max-width: 80vw;">
                <div class="bg-white q-py-lg q-px-lg app-br-16">

                    <div class="row q-col-gutter-lg">
                        <div class="col-12 items-center q-mt-xs row justify-between">
                            <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                                Editar episódio
                            </div>

                            <q-btn
                                color="primary"
                                @click="hideEditChapterModal"
                                flat
                            >
                                <q-icon name="close" size="xs"/>
                            </q-btn>
                        </div>

                        <div class="col-12 col-md-2">
                            <div class="col-12 col-md-2">
                                <q-select
                                    option-value="position"
                                    :options="optionsNumberOfChapterEditModal"
                                    outlined
                                    v-model="editChapterForm.number"
                                    label="Número do episódio"
                                    :bottom-slots="Boolean(editChapterForm.errors.number)"
                                    emit-value
                                    map-options
                                    :option-disable="opt => !opt.empty"
                                    :option-label="opt => !opt.empty ? `${opt.position} (em uso)` : opt.position"
                                >
                                    <template v-slot:hint>
                                        <div class="text-red"> {{ editChapterForm.errors.number }} </div>
                                    </template>
                                </q-select>
                            </div>
                        </div>

                        <div class="col-12 col-md-7">
                            <q-input
                                outlined
                                v-model="editChapterForm.name"
                                label="Nome do episódio"
                                :bottom-slots="Boolean(editChapterForm.errors.name)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ editChapterForm.errors.name }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12 col-md-3">
                            <q-input
                                outlined
                                v-model="editChapterForm.duration"
                                mask="##:##"
                                label="Duração"
                                :bottom-slots="Boolean(editChapterForm.errors.duration)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ editChapterForm.errors.duration }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12 col-md-9">
                            <q-input
                                outlined
                                v-model="editChapterForm.cast"
                                label="Elenco"
                                :bottom-slots="Boolean(editChapterForm.errors.cast)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ editChapterForm.errors.cast }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12 col-md-3">
                            <q-input
                                outlined
                                v-model="editChapterForm.direction"
                                label="Direção"
                                :bottom-slots="Boolean(editChapterForm.errors.direction)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ editChapterForm.errors.direction }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12">
                            <q-input
                                    outlined
                                    v-model="editChapterForm.description"
                                    label="Descrição"
                                    :bottom-slots="Boolean(editChapterForm.errors.description)"
                                    type="textarea"
                                    clearable
                                    max_length="500"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ editChapterForm.errors.description }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12">
                            <q-input
                                    outlined
                                    v-model="editChapterForm.embed"
                                    label="Link embed"
                                    :bottom-slots="Boolean(editChapterForm.errors.embed)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ editChapterForm.errors.embed }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12">
                            <div class="q-gutter-sm row items-center">
                                <div> Autor da produção: </div>

                                <q-radio v-model="editChapterForm.main_player" val="vimeo" label="Vimeo" />
                                <q-radio v-model="editChapterForm.main_player" val="sambatech" label="Sambatech" />
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <q-input
                                outlined
                                v-model="editChapterForm.vimeo_link"
                                label="Link do Vimeo"
                                :bottom-slots="Boolean(editChapterForm.errors.vimeo_link)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ editChapterForm.errors.vimeo_link }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12 col-md-8">
                            <q-input
                                outlined
                                v-model="editChapterForm.vimeo_embed"
                                label="Código embed Vimeo"
                                :bottom-slots="Boolean(editChapterForm.errors.vimeo_embed)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ editChapterForm.errors.vimeo_embed }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12 col-md-4">
                            <q-input
                                outlined
                                v-model="editChapterForm.sambatech_link"
                                label="Link do Sambatech"
                                :bottom-slots="Boolean(editChapterForm.errors.sambatech_link)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ editChapterForm.errors.sambatech_link }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12 col-md-8">
                            <q-input
                                outlined
                                v-model="editChapterForm.sambatech_embed"
                                label="Código embed Sambatech"
                                :bottom-slots="Boolean(editChapterForm.errors.sambatech_embed)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ editChapterForm.errors.sambatech_embed }} </div>
                                </template>
                            </q-input>
                        </div>

                        <div class="col-12 items-center q-mt-xs">
                            <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                                Imagem opcional
                            </div>
                        </div>

                        <div class="col-12 col-md-4" v-if="imageChapterEditSrc">
                            <q-img
                                :src="imageChapterEditSrc"
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
                                        @click="removeChapterEditImage"
                                    />

                                    <div class="flex cursor-pointer" v-bind="dropZoneEditChapterImage.getRootProps()">
                                        <input v-bind="dropZoneEditChapterImage.getInputProps()"/>
                                        Alterar imagem
                                    </div>
                                </div>
                            </q-img>
                        </div>

                        <div class="col-12" v-else>
                            <div
                                v-bind="dropZoneEditChapterImage.getRootProps()"
                                class="column flex-center q-py-lg text-grey adm-border-dashed-blue app-br-16"
                            >
                                <input v-bind="dropZoneEditChapterImage.getInputProps()"/>

                                <q-icon name="o_photo" size="md"/>

                                <div class="q-mt-sm">
                                    Clique aqui ou arraste sua imagem
                                </div>
                            </div>
                        </div>


                        <div class="col-12 flex justify-end items-center">
                            <q-btn
                                color="primary"
                                rounded
                                no-caps
                                @click="hideEditChapterModal"
                                class="q-mr-sm"
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
                                @click="updateChapterSubmit"
                                :disabled="createChapterForm.processing"
                            >
                                <q-icon name="add" size="xs"/>

                                <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                                    Salvar
                                </div>
                            </q-btn>
                        </div>
                    </div>
                </div>
            </q-card>
        </q-dialog>

        <q-dialog v-model="showChapterModalShow" persistent>
            <q-card style="width: 80vw; max-width: 80vw;">
                <div class="bg-white q-py-lg q-px-lg app-br-16">

                    <div class="row q-col-gutter-lg">
                        <div class="col-12 items-center q-mt-xs row justify-between">
                            <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                                Visualizar episódio
                            </div>

                            <q-btn
                                color="primary"
                                @click="hideShowChapterModal"
                                flat
                            >
                                <q-icon name="close" size="xs"/>
                            </q-btn>
                        </div>

                        <div class="col-12 col-md-2">
                            <q-input
                                outlined
                                label="Número do episódio"
                                disable
                                v-model="showChapterForm.number"
                            />
                        </div>

                        <div class="col-12 col-md-7">
                            <q-input
                                outlined
                                v-model="showChapterForm.name"
                                label="Nome do episódio"
                                disable
                            />
                        </div>

                        <div class="col-12 col-md-3">
                            <q-input
                                outlined
                                v-model="showChapterForm.duration"
                                mask="##:##"
                                label="Duração"
                                disable
                            />
                        </div>

                        <div class="col-12 col-md-9">
                            <q-input
                                outlined
                                v-model="showChapterForm.cast"
                                label="Elenco"
                                disable
                            />
                        </div>

                        <div class="col-12 col-md-3">
                            <q-input
                                outlined
                                v-model="showChapterForm.direction"
                                label="Direção"
                                disable
                            />
                        </div>

                        <div class="col-12">
                            <q-input
                                outlined
                                v-model="showChapterForm.description"
                                label="Descrição"
                                type="textarea"
                                clearable
                                disable
                            />

                        </div>

                        <div class="col-12">
                            <q-input
                                outlined
                                v-model="showChapterForm.embed"
                                label="Link embed"
                                disable
                            />
                        </div>

                        <div class="col-12">
                            <div class="q-gutter-sm row items-center">
                                <div> Autor da produção: </div>

                                <q-radio v-model="showChapterForm.main_player" val="vimeo" label="Vimeo" disable/>
                                <q-radio v-model="showChapterForm.main_player" val="sambatech" label="Sambatech" disable/>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <q-input
                                outlined
                                v-model="showChapterForm.vimeo_link"
                                label="Link do Vimeo"
                                disable
                            />
                        </div>

                        <div class="col-12 col-md-8">
                            <q-input
                                outlined
                                v-model="showChapterForm.vimeo_embed"
                                label="Código embed Vimeo"
                                disable
                            />
                        </div>

                        <div class="col-12 col-md-4">
                            <q-input
                                outlined
                                v-model="showChapterForm.sambatech_link"
                                label="Link do Sambatech"
                                disable
                            />
                        </div>

                        <div class="col-12 col-md-8">
                            <q-input
                                outlined
                                v-model="showChapterForm.sambatech_embed"
                                label="Código embed Sambatech"
                                disable
                            />
                        </div>

                        <div class="col-12 items-center q-mt-xs">
                            <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                                Imagem opcional
                            </div>
                        </div>

                        <div class="col-12 col-md-4" v-if="imageChapterShowSrc">
                            <q-img
                                :src="imageChapterShowSrc"
                                style="height: 400px"
                                class="app-br-16"
                            >
                                <div class="absolute-bottom text-subtitle2 row items-center">
                                    <q-icon name="image" size="md"/>
                                </div>
                            </q-img>
                        </div>

                        <div class="col-12 flex justify-end items-center">
                            <q-btn
                                color="primary"
                                rounded
                                no-caps
                                @click="hideShowChapterModal"
                                outline
                            >
                                <q-icon name="close" size="xs"/>

                                <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                                    Fechar
                                </div>
                            </q-btn>
                        </div>
                    </div>
                </div>
            </q-card>
        </q-dialog>
    </AuthenticatedLayout>
</template>
