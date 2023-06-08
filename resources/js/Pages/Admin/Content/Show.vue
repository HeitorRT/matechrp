<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar';
    import { ref, computed } from 'vue'

    const $q = useQuasar()

    const props = defineProps({
        content: Object,
        errors: Object,
        categories: Array,
        sections: Array,
        contents: Array,
        genres: Array,
        responsibles: Array,
    });

    const form = useForm({
        id: props.content.id,
        name: props.content.name,
        tags: props.content.tags,
        category_id: props.content.category_id,
        launch_start_at: props.content.launch_start_at,
        launch_end_at: props.content.launch_end_at,
        end_at: props.content.end_at,
        sections: props.content.sections.map(s => s.id),
        genres: props.content.genres.map(s => s.id),
        has_seasons: props.content.has_seasons,
        number_of_seasons: props.content.number_of_seasons,
        production_type: props.content.production_type,
        author: props.content.author,
        responsible_id: props.content.responsible_id,
        highlight: props.content.highlight,
        contents_of_the_same_collection: props.content.contents_of_the_same_collection.map(s => s.id),
        similar_contents: props.content.similar_contents.map(s => s.id),
        image: props.content.image,
        secondary_image: props.content.secondary_image,
        description_image: props.content.description_image,
        screensaver_image: props.content.screensaver_image,
        description: props.content.description,
        active: props.content.active,
    });


    const mainImageSrc = computed(() => {
        return form.image == null ? '' : (typeof form.image === 'object') ? URL.createObjectURL(form.image) : form.image;
    });

    const secondaryImageSrc = computed(() => {
        return form.secondary_image == null ? '' : (typeof form.secondary_image === 'object') ? URL.createObjectURL(form.secondary_image) : form.secondary_image;
    });

    const descritiptionImageSrc = computed(() => {
        return form.description_image == null ? '' : (typeof form.description_image === 'object') ? URL.createObjectURL(form.description_image) : form.description_image;
    });

    const screensaverImageSrc = computed(() => {
        return form.screensaver_image == null ? '' : (typeof form.screensaver_image === 'object') ? URL.createObjectURL(form.screensaver_image) : form.screensaver_image;
    });

    const optionsCategories = ref(props.categories)

    const optionsSections = ref(props.sections)

    const optionsContents = ref(props.contents)

    const optionsGenres = ref(props.genres)

    const optionsResponsibles = ref(props.responsibles)

    const tab = ref('main')

    const goExtraTab = () => useForm().get(route('admin.content.extra.show-list', props.content.id))

    const goTitlesTab = () => useForm().get(route('admin.content.titles.show', props.content.id))

    const goBack = () => useForm().get(route('admin.content.index'))

</script>

<template>
    <AuthenticatedLayout>
        <Head :title="`Visualizar conteúdo: ${content.name}`" />

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
                    <q-breadcrumbs-el :label="`Visualizar conteúdo: ${content.name}`" class="text-primary" />
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
                    @click="goExtraTab"
                />
            </q-tabs>

            <div class="row q-col-gutter-lg q-py-lg q-px-lg">
                <div class="col-12 items-center q-mt-xs">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Informações
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="form.name"
                        label="Nome do conteúdo"
                        disable
                    />
                </div>

                <div class="col-12 col-md-6">
                    <q-select
                        :options="optionsCategories"
                        outlined
                        v-model="form.category_id"
                        label="Categoria"
                        disable
                    />
                </div>

                <div class="col-12">
                    <q-select
                        :options="optionsSections"
                        option-value="id"
                        option-label="name"
                        map-options
                        outlined
                        v-model="form.sections"
                        label="Seções"
                        multiple
                        disable
                    >
                        <template v-slot:selected-item="scope">
                            <q-chip
                                class="adm-chip-primary q-my-none"
                                :label="scope.opt.name"
                                dense
                            />
                        </template>
                    </q-select>
                </div>

                <div class="col-12">
                    <q-select
                        label="Tags"
                        outlined
                        v-model="form.tags"
                        multiple
                        hide-dropdown-icon
                        input-debounce="0"
                        new-value-mode="add-unique"
                        bottom-slots
                        disable
                    >
                        <template v-slot:selected-item="scope">
                            <q-chip
                                class="adm-chip-primary q-my-none"
                                :label="scope.opt"
                                dense
                            />
                        </template>
                    </q-select>
                </div>

                <div class="col-12 col-xl-6">
                    <q-select
                        :options="optionsGenres"
                        option-value="id"
                        option-label="name"
                        emit-value
                        map-options
                        outlined
                        v-model="form.genres"
                        label="Gênero"
                        multiple
                        disable
                    />
                </div>

                <div class="col-12 col-xl-3 col-md-6">
                    <q-input
                        outlined
                        v-model="form.launch_start_at"
                        mask="##/##/#### ##:##"
                        label="Data e hora de inicio do lançamento"
                        disable
                    />
                </div>

                <div class="col-12 col-xl-3 col-md-6">
                    <q-input
                        outlined
                        v-model="form.launch_end_at"
                        mask="##/##/#### ##:##"
                        label="Data e hora de inicio de termino de lançamento"
                        disable
                    />
                </div>

                <div class="col-12">
                    <q-select
                        :options="optionsContents"
                        option-value="id"
                        option-label="name"
                        emit-value
                        map-options
                        outlined
                        v-model="form.contents_of_the_same_collection"
                        label="Títulos da mesma coleção"
                        multiple
                        clearable
                        use-input
                        disable
                    >
                        <template v-slot:selected-item="scope">
                            <q-chip
                                class="adm-chip-primary q-my-none"
                                :label="scope.opt.name"
                                dense
                            />
                        </template>
                    </q-select>
                </div>

                <div class="col-12">
                    <q-select
                        :options="optionsContents"
                        option-value="id"
                        option-label="name"
                        emit-value
                        map-options
                        outlined
                        v-model="form.similar_contents"
                        label="Títulos semelhantes"
                        multiple
                        clearable
                        use-input
                        disable
                    >
                        <template v-slot:selected-item="scope">
                            <q-chip
                                class="adm-chip-primary q-my-none"
                                :label="scope.opt.name"
                                dense
                            />
                        </template>
                    </q-select>
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
                    <q-checkbox
                        v-model="form.has_seasons"
                        label="Conteúdo em temporadas"
                        disable
                    />
                </div>

                <div class="col-12 col-md-4" v-if="form.has_seasons">
                    <q-select
                        outlined
                        v-model="form.number_of_seasons"
                        label="Quantidade de temporadas"
                        disable
                    />
                </div>

                <div class="col-12">
                    <div class="q-gutter-sm row items-center">
                        <div> Autor da produção: </div>

                        <q-radio v-model="form.author" val="confeccao_propria" label="Própria" disable />
                        <q-radio v-model="form.author" val="outro" label="Outro" disable />
                    </div>
                </div>

                <div class="col-12 col-md-4" v-if="form.author === 'outro'">
                    <q-select
                            :options="optionsResponsibles"
                            option-value="id"
                            option-label="name"
                            emit-value
                            map-options
                            outlined
                            v-model="form.responsible_id"
                            label="Responsável pela produção"
                            disable
                            stack-label
                    />
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.end_at"
                        mask="##/##/#### ##:##"
                        label="Prazo de encerramento"
                        disable
                    >
                        <template v-slot:prepend>
                            <q-icon name="o_calendar_today" />
                        </template>
                    </q-input>
                </div>

                <div class="col-4" v-if="form.author === 'outro'">
                    <div class="q-gutter-sm row items-center">
                        <div> Tipo produção: </div>

                        <q-radio v-model="form.production_type" val="licenciamento" label="Licenciatura" disable />
                        <q-radio v-model="form.production_type" val="parceria" label="Parceria" disable />
                    </div>
                </div>

                <div class="col-12">
                    <q-checkbox
                        v-model="form.highlight"
                        label="Destacar conteúdo para alunos"
                        disable
                    />
                </div>

                <div class="col-12">
                    <q-checkbox
                        v-model="form.active"
                        label="Ativo"
                        disable
                    />
                </div>

                <div class="col-12 items-center q-mt-xs">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Capa principal
                    </div>
                </div>

                <div class="col-12" v-if="mainImageSrc">
                    <q-img
                        :src="mainImageSrc"
                        style="height: 400px"
                        class="app-br-16"
                    >
                        <div class="absolute-bottom text-subtitle2 row items-center">
                            <q-icon name="image" size="md"/>
                        </div>
                    </q-img>
                </div>

                <div class="col-12 col-md-4" v-if="secondaryImageSrc">
                    <div class="q-ml-sm q-my-xs text-grey-8 app-fw-500 app-lh-32 app-fs-16">
                        Capa secundária (opcional)
                    </div>

                    <q-img
                        :src="secondaryImageSrc"
                        style="height: 400px"
                        class="app-br-16"
                    >
                        <div class="absolute-bottom text-subtitle2 row items-center">
                            <q-icon name="image" size="md"/>
                        </div>
                    </q-img>
                </div>

                <div class="col-12 col-md-4" v-if="descritiptionImageSrc">
                    <div class="q-ml-sm q-my-xs text-grey-8 app-fw-500 app-lh-32 app-fs-16">
                        Imagem de descrição (opcional)
                    </div>

                    <q-img
                        :src="descritiptionImageSrc"
                        style="height: 400px"
                        class="app-br-16"
                    >
                        <div class="absolute-bottom text-subtitle2 row items-center">
                            <q-icon name="image" size="md"/>
                        </div>
                    </q-img>
                </div>

                <div class="col-12 col-md-4" v-if="screensaverImageSrc">
                    <div class="q-ml-sm q-my-xs text-grey-8 app-fw-500 app-lh-32 app-fs-16">
                        Imagem de descanso (opcional)
                    </div>

                    <q-img
                        :src="screensaverImageSrc"
                        style="height: 400px"
                        class="app-br-16"
                    >
                        <div class="absolute-bottom text-subtitle2 row items-center">
                            <q-icon name="image" size="md"/>
                        </div>
                    </q-img>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
