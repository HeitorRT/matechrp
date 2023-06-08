<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar';
    import { ref, computed } from 'vue'
    import { useDropzone } from "vue3-dropzone";
    import AdminDialog from '@/Components/Admin/AdminDialog.vue';

    const $q = useQuasar()

    const props = defineProps({
        errors: Object,
        categories: Array,
        sections: Array,
        contents: Array,
        genres: Array,
        responsibles: Array,
    });

    const form = useForm({
        id: null,
        name: null,
        tags: [],
        category_id: null,
        launch_start_at: null,
        launch_end_at: null,
        end_at: null,
        sections: null,
        genres: null,
        has_seasons: false,
        number_of_seasons: null,
        production_type: 'licenciamento',
        author: 'confeccao_propria',
        responsible_id: null,
        highlight: false,
        contents_of_the_same_collection: null,
        similar_contents: null,
        description: null,
        active: true,

        image: null,
        secondary_image: null,
        description_image: null,
        screensaver_image: null,
    });

    const submit = () => {
        form.post(route("admin.content.store"), {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Conteúdo cadastrado com sucesso',
                        position: 'top',
                    })
                },
            })
    };

    const mainImageSrc = computed(() => {
        return form.image == null ? '' : (typeof form.image === 'object') ? URL.createObjectURL(form.image) : form.image;
    });

    const dropZoneMainImage = useDropzone({
        onDrop: (acceptFiles, rejectReasons) => {
            form.image = acceptFiles[0];

            if (rejectReasons.length > 0) {
                $q.notify({ message: 'Insira apenas uma imagem', position: 'center' })
            }
        },
        accept: ['image/*'],
        maxFiles: 1
    });

    const removeImageMain = () => form.image = null;

    const secondaryImageSrc = computed(() => {
        return form.secondary_image == null ? '' : (typeof form.secondary_image === 'object') ? URL.createObjectURL(form.secondary_image) : form.secondary_image;
    });

    const dropZoneSecondaryImage = useDropzone({
        onDrop: (acceptFiles, rejectReasons) => {
            form.secondary_image = acceptFiles[0];

            if (rejectReasons.length > 0) {
                $q.notify({ message: 'Insira apenas uma imagem', position: 'center' })
            }
        },
        accept: ['image/*'],
        maxFiles: 1
    });

    const removeImageSecondary = () => form.secondary_image = null;

    const descritiptionImageSrc = computed(() => {
        return form.description_image == null ? '' : (typeof form.description_image === 'object') ? URL.createObjectURL(form.description_image) : form.description_image;
    });

    const dropZoneDescritiptionImage = useDropzone({
        onDrop: (acceptFiles, rejectReasons) => {
            form.description_image = acceptFiles[0];

            if (rejectReasons.length > 0) {
                $q.notify({ message: 'Insira apenas uma imagem', position: 'center' })
            }
        },
        accept: ['image/*'],
        maxFiles: 1
    });

    const removeImageDescritiption = () => form.description_image = null;

    const screensaverImageSrc = computed(() => {
        return form.screensaver_image == null ? '' : (typeof form.screensaver_image === 'object') ? URL.createObjectURL(form.screensaver_image) : form.screensaver_image;
    });

    const dropZoneScreensaverImage = useDropzone({
        onDrop: (acceptFiles, rejectReasons) => {
            form.screensaver_image = acceptFiles[0];

            if (rejectReasons.length > 0) {
                $q.notify({ message: 'Insira apenas uma imagem', position: 'center' })
            }
        },
        accept: ['image/*'],
        maxFiles: 1
    });

    const removeImageScreensaver = () => form.screensaver_image = null;

    const optionsCategories = ref(props.categories)

    const filterCategories = (val, update, abort) => {
        update(() => optionsCategories.value = props.categories.filter(s => s.name.toLowerCase().indexOf(val.toLowerCase()) > -1))
    }

    const optionsSections = ref(props.sections)

    const filterSections = (val, update, abort) => {
        update(() => optionsSections.value = props.sections.filter(s => s.name.toLowerCase().indexOf(val.toLowerCase()) > -1))
    }

    const optionsContents = ref(props.contents)

    const filterContents = (val, update, abort) => {
        update(() => optionsContents.value = props.contents.filter(s => s.name.toLowerCase().indexOf(val.toLowerCase()) > -1))
    }

    const optionsGenres = ref(props.genres)

    const filterGenres = (val, update, abort) => {
        update(() => optionsGenres.value = props.genres.filter(s => s.name.toLowerCase().indexOf(val.toLowerCase()) > -1))
    }

    const optionsResponsibles = ref(props.responsibles)

    const filterResponsibles = (val, update, abort) => {
        update(() => optionsResponsibles.value = props.responsibles.filter(s => s.name.toLowerCase().indexOf(val.toLowerCase()) > -1))
    }

    const tab = ref('main')

    const goBack = () => useForm().get(route('admin.content.index'));

    const messageSave = () => {
        tab.value = 'main';

        $q.dialog({
            component: AdminDialog,
            componentProps: {
                title: 'Salve o conteúdo',
                message: 'Para navegar pelas abas, salve o conteúdo.',
            },
        })
    }

    const chosenCategoryIsMovie = computed(()=> {
        let index = optionsCategories.value.findIndex(c => c.id == form.category_id);

        return optionsCategories.value[index]?.name.includes('Filme');
    })

    const checkIfCategory = () => {
        if (chosenCategoryIsMovie) form.has_seasons = false;
    }

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Adicionar conteudo" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8">
                    Adicionar conteudo
                </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Conteúdos" class="text-grey"/>
                    <q-breadcrumbs-el label="Adicionar conteudo" class="text-primary" />
                </q-breadcrumbs>
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
                @update:model-value="messageSave"
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
                />

                <q-tab
                    name="extras"
                    label="Extras"
                    class="q-py-md"
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
                        label="Nome do conteúdo *"
                        :bottom-slots="Boolean(errors.name)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.name }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-6">
                    <q-select
                        :options="optionsCategories"
                        option-value="id"
                        option-label="name"
                        emit-value
                        map-options
                        outlined
                        v-model="form.category_id"
                        label="Categoria"
                        :bottom-slots="Boolean(errors.category_id)"
                        clearable
                        @filter="filterCategories"
                        stack-label
                        @update:model-value="checkIfCategory"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.category_id }} </div>
                        </template>
                    </q-select>
                </div>

                <div class="col-12">
                    <q-select
                        :options="optionsSections"
                        option-value="id"
                        option-label="name"
                        emit-value
                        map-options
                        outlined
                        v-model="form.sections"
                        label="Seções"
                        :bottom-slots="Boolean(errors.sections)"
                        multiple
                        clearable
                        use-input
                        @filter="filterSections"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.sections }} </div>
                        </template>

                        <template v-slot:selected-item="scope">
                            <q-chip
                                class="adm-chip-primary q-my-none"
                                :label="scope.opt.name"
                                dense
                            >
                                <q-icon
                                    name="cancel"
                                    size="xs"
                                    @click="scope.removeAtIndex(scope.index)"
                                    class="q-ml-xs cursor-pointer"
                                />
                            </q-chip>
                        </template>
                    </q-select>
                </div>

                <div class="col-12">
                    <q-select
                        label="Tags"
                        outlined
                        v-model="form.tags"
                        use-input
                        multiple
                        hide-dropdown-icon
                        input-debounce="0"
                        new-value-mode="add-unique"
                        bottom-slots
                    >
                        <template v-slot:selected-item="scope">
                            <q-chip
                                class="adm-chip-primary q-my-none"
                                :label="scope.opt"
                                dense
                            >
                                <q-icon
                                    name="cancel"
                                    size="xs"
                                    @click="scope.removeAtIndex(scope.index)"
                                    class="q-ml-xs cursor-pointer"
                                />
                            </q-chip>
                        </template>

                        <template v-slot:hint>
                            <div> Para adicionar uma tag, digite o valor e aperte enter. </div>
                            <div class="text-red" v-if="errors.tags"> {{ errors.tags }} </div>
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
                        label="Genero"
                        :bottom-slots="Boolean(errors.genres)"
                        multiple
                        clearable
                        @filter="filterGenres"
                        stack-label
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.genres }} </div>
                        </template>
                    </q-select>
                </div>

                <div class="col-12 col-xl-3 col-md-6">
                    <q-input
                        outlined
                        v-model="form.launch_start_at"
                        mask="##/##/#### ##:##"
                        label="Data e hora de inicio do lançamento *"
                        :bottom-slots="Boolean(errors.launch_start_at)"
                        clearable
                    >
                        <template v-slot:prepend>
                            <q-icon name="o_calendar_today" />
                        </template>

                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.launch_start_at }} </div>
                        </template>

                        <q-popup-proxy class="row">
                            <q-date
                                v-model="form.launch_start_at"
                                mask="DD/MM/YYYY HH:mm"
                                flat
                                square
                            />

                            <q-time
                                v-model="form.launch_start_at"
                                mask="DD/MM/YYYY HH:mm"
                                format24h
                                flat
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
                            </q-time>
                        </q-popup-proxy>
                    </q-input>
                </div>

                <div class="col-12 col-xl-3 col-md-6">
                    <q-input
                        outlined
                        v-model="form.launch_end_at"
                        mask="##/##/#### ##:##"
                        label="Data e hora de término de lançamento *"
                        :bottom-slots="Boolean(errors.launch_end_at)"
                    >
                        <template v-slot:prepend>
                            <q-icon name="o_calendar_today" />
                        </template>

                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.launch_end_at }} </div>
                        </template>

                        <q-popup-proxy class="row">
                            <q-date
                                v-model="form.launch_end_at"
                                mask="DD/MM/YYYY HH:mm"
                                flat
                                square
                            />

                            <q-time
                                v-model="form.launch_end_at"
                                mask="DD/MM/YYYY HH:mm"
                                format24h
                                flat
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
                            </q-time>
                        </q-popup-proxy>
                    </q-input>
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
                        :bottom-slots="Boolean(errors.contents_of_the_same_collection)"
                        multiple
                        clearable
                        use-input
                        @filter="filterContents"
                        stack-label
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.contents_of_the_same_collection }} </div>
                        </template>

                        <template v-slot:selected-item="scope">
                            <q-chip
                                class="adm-chip-primary q-my-none"
                                :label="scope.opt.name"
                                dense
                            >
                                <q-icon
                                    name="cancel"
                                    size="xs"
                                    @click="scope.removeAtIndex(scope.index)"
                                    class="q-ml-xs cursor-pointer"
                                />
                            </q-chip>
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
                        :bottom-slots="Boolean(errors.similar_contents)"
                        multiple
                        clearable
                        use-input
                        @filter="filterContents"
                        stack-label
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.similar_contents }} </div>
                        </template>

                        <template v-slot:selected-item="scope">
                            <q-chip
                                class="adm-chip-primary q-my-none"
                                :label="scope.opt.name"
                                dense
                            >
                                <q-icon
                                    name="cancel"
                                    size="xs"
                                    @click="scope.removeAtIndex(scope.index)"
                                    class="q-ml-xs cursor-pointer"
                                />
                            </q-chip>
                        </template>
                    </q-select>
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
                    <q-checkbox
                        v-model="form.has_seasons"
                        label="Conteúdo em temporadas"
                        :disable="chosenCategoryIsMovie"
                    />
                </div>

                <div class="col-12 col-md-4" v-if="form.has_seasons">
                    <q-select
                        :options="[...Array(20).keys()].map(i => ++i)"
                        outlined
                        v-model="form.number_of_seasons"
                        label="Quantidade de temporadas"
                        :bottom-slots="Boolean(errors.number_of_seasons)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.number_of_seasons }} </div>
                        </template>
                    </q-select>
                </div>

                <div class="col-12">
                    <div class="q-gutter-sm row items-center">
                        <div> Autor da produção: </div>

                        <q-radio v-model="form.author" val="confeccao_propria" label="Própria" />
                        <q-radio v-model="form.author" val="outro" label="Outro" />
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
                            :bottom-slots="Boolean(errors.responsible_id)"
                            clearable
                            @filter="filterResponsibles"
                            stack-label
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.responsible_id }} </div>
                        </template>
                    </q-select>
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.end_at"
                        mask="##/##/#### ##:##"
                        label="Prazo de encerramento"
                        :bottom-slots="Boolean(errors.end_at)"
                    >
                        <template v-slot:prepend>
                            <q-icon name="o_calendar_today" />
                        </template>

                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.end_at }} </div>
                        </template>

                        <q-popup-proxy class="row">
                            <q-date
                                v-model="form.end_at"
                                mask="DD/MM/YYYY HH:mm"
                                flat
                                square
                            />

                            <q-time
                                v-model="form.end_at"
                                mask="DD/MM/YYYY HH:mm"
                                format24h
                                flat
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
                            </q-time>
                        </q-popup-proxy>
                    </q-input>
                </div>

                <div class="col-4" v-if="form.author === 'outro'">
                    <div class="q-gutter-sm row items-center">
                        <div> Tipo produção: </div>

                        <q-radio v-model="form.production_type" val="licenciamento" label="Licenciatura" />
                        <q-radio v-model="form.production_type" val="parceria" label="Parceria" />
                    </div>
                </div>

                <div class="col-12">
                    <q-checkbox
                            v-model="form.highlight"
                            label="Destacar conteúdo para alunos"
                    />
                </div>

                <div class="col-12">
                    <q-checkbox
                            v-model="form.active"
                            label="Ativo"
                    />
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

                <div class="col-12" v-if="mainImageSrc">
                    <q-img
                        :src="mainImageSrc"
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
                                @click="removeImageMain"
                            />

                            <div class="flex cursor-pointer" v-bind="dropZoneMainImage.getRootProps()">
                                <input v-bind="dropZoneMainImage.getInputProps()"/>
                                Alterar imagem
                            </div>
                        </div>
                    </q-img>
                </div>

                <div class="col-12" v-else>
                    <div
                        v-bind="dropZoneMainImage.getRootProps()"
                        class="column flex-center q-py-lg text-grey adm-border-dashed-blue app-br-16"
                    >
                        <input v-bind="dropZoneMainImage.getInputProps()"/>

                        <q-icon name="o_photo" size="md"/>

                        <div class="q-mt-sm">
                            Clique aqui ou arraste sua imagem
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4" v-if="secondaryImageSrc">
                    <div class="q-ml-sm q-my-xs text-grey-8 app-fw-500 app-lh-32 app-fs-16">
                        Capa secundária (opcional)

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

                    <q-img
                        :src="secondaryImageSrc"
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
                                @click="removeImageSecondary"
                            />

                            <div class="flex cursor-pointer" v-bind="dropZoneSecondaryImage.getRootProps()">
                                <input v-bind="dropZoneSecondaryImage.getInputProps()"/>
                                Alterar imagem
                            </div>
                        </div>
                    </q-img>
                </div>

                <div class="col-12 col-md-4" v-else>
                    <div class="q-ml-sm q-my-xs text-grey-8 app-fw-500 app-lh-32 app-fs-16">
                        Capa secundária (opcional)

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

                    <div
                        v-bind="dropZoneSecondaryImage.getRootProps()"
                        class="column flex-center q-py-lg text-grey adm-border-dashed-blue app-br-16"
                    >
                        <input v-bind="dropZoneSecondaryImage.getInputProps()"/>

                        <q-icon name="o_photo" size="md"/>

                        <div class="q-mt-sm">
                            Clique aqui ou arraste sua imagem
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4" v-if="descritiptionImageSrc">
                    <div class="q-ml-sm q-my-xs text-grey-8 app-fw-500 app-lh-32 app-fs-16">
                        Imagem de descrição (opcional)

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

                    <q-img
                        :src="descritiptionImageSrc"
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
                                @click="removeImageDescritiption"
                            />

                            <div class="flex cursor-pointer" v-bind="dropZoneDescritiptionImage.getRootProps()">
                                <input v-bind="dropZoneDescritiptionImage.getInputProps()"/>
                                Alterar imagem
                            </div>
                        </div>
                    </q-img>
                </div>

                <div class="col-12 col-md-4" v-else>
                    <div class="q-ml-sm q-my-xs text-grey-8 app-fw-500 app-lh-32 app-fs-16">
                        Imagem de descrição (opcional)

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

                    <div
                        v-bind="dropZoneDescritiptionImage.getRootProps()"
                        class="column flex-center q-py-lg text-grey adm-border-dashed-blue app-br-16"
                    >
                        <input v-bind="dropZoneDescritiptionImage.getInputProps()"/>

                        <q-icon name="o_photo" size="md"/>

                        <div class="q-mt-sm">
                            Clique aqui ou arraste sua imagem
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4" v-if="screensaverImageSrc">
                    <div class="q-ml-sm q-my-xs text-grey-8 app-fw-500 app-lh-32 app-fs-16">
                        Imagem de descanso (opcional)

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

                    <q-img
                        :src="screensaverImageSrc"
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
                                @click="removeImageScreensaver"
                            />

                            <div class="flex cursor-pointer" v-bind="dropZoneScreensaverImage.getRootProps()">
                                <input v-bind="dropZoneScreensaverImage.getInputProps()"/>
                                Alterar imagem
                            </div>
                        </div>
                    </q-img>
                </div>

                <div class="col-12 col-md-4" v-else>
                    <div class="q-ml-sm q-my-xs text-grey-8 app-fw-500 app-lh-32 app-fs-16">
                        Imagem de descanso (opcional)

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

                    <div
                        v-bind="dropZoneScreensaverImage.getRootProps()"
                        class="column flex-center q-py-lg text-grey adm-border-dashed-blue app-br-16"
                    >
                        <input v-bind="dropZoneScreensaverImage.getInputProps()"/>

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
                        <q-icon name="check" size="xs"/>

                        <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                            Cadastrar conteúdo
                        </div>
                    </q-btn>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
