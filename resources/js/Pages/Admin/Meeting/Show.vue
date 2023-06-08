 <script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'
    import { ref, computed } from 'vue'
    import { useDropzone } from "vue3-dropzone";
    import DialogConfirm from '@/Components/Admin/DialogConfirm.vue';

    const $q = useQuasar();

    const props = defineProps({
        meeting: Object,
        errors: Object,
        types: Object,
        teachers: Array,
        linkableTypes: Object,
        contents: Array,
        seasonsOrChapters: Array,
        canMeetingDestroy: Boolean,
    });

    const form = useForm({
        id: props.meeting.id,
        name: props.meeting.name,
        description: props.meeting.description,
        type: props.meeting.type,
        tags: props.meeting.tags,
        group_ids: props.meeting.group_ids,
        student_ids: props.meeting.student_ids,
        teacher_id: props.meeting.teacher_id,
        number_of_students: props.meeting.number_of_students,
        start_at: props.meeting.start_at,
        end_at: props.meeting.end_at,
        has_live_offer: props.meeting.has_live_offer,
        name_offer: props.meeting.name_offer,
        description_offer: props.meeting.description_offer,
        embed_offer: props.meeting.embed_offer,
        materials: props.meeting.materials,
        image: props.meeting.image,
        linkable_id: props.meeting.linkable_id,
        linkable_type: props.meeting.linkable_type,
        content_id: props.meeting.content_id,
        has_link_with_content: props.meeting.has_link_with_content,
    });

    const imageSrc = computed(() => form.image ?? '');

    const imageForDoc = 'https://i.pinimg.com/564x/04/54/7c/04547c2b354abb70a85ed8a2d1b33e5f.jpg';

    const selectedLiveForStudent = computed(() => form.type == 'individual' || form.type == 'agendamento');

    const optionsTeachers = ref(props.teachers)

    const optionsTypes = computed(() => {
        let options = new Array();

        for (const key in props.types) {
            options.push({ label: props.types[key], value: key })
        }

        return options;
    })

    const optionsContents = ref(props.contents)

    const filterContents = (val, update, abort) => {
        update(() => optionsContents.value = props.contents.filter(s => s.name.toLowerCase().indexOf(val.toLowerCase()) > -1))
    }

    const labelOptionsSeasonsOrChapters = computed(() => {
        if (form.linkable_type === 'season') {
            return 'Temporada';
        }

        if (form.linkable_type === 'chapter') {
            return 'Episódio';
        }

        return '';
    })

    const optionsSeasonsOrChapters = ref(props.seasonsOrChapters)

    const optionsLinkableTypes = computed(() => {
        let options = new Array();

        for (const key in props.linkableTypes) {
            options.push({ label: props.linkableTypes[key], value: key })
        }

        return options;
    })

    const downloadMaterial = (material) => {
        const link = document.createElement('a');
        link.href = material.link;
        link.setAttribute('download', material.name);
        link.click();
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Encontro | Visualizar" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Visualizar encontro </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Encontros" class="text-grey"/>
                    <q-breadcrumbs-el label="Visualizar encontro" class="text-primary" />
                </q-breadcrumbs>
            </div>

            <div class="col-12 col-md-6 flex justify-end items-center">
            </div>
        </div>

        <div class="bg-white q-py-lg q-px-lg app-br-16">
            <div class="row q-col-gutter-lg">
                <div class="col-12 items-center q-mt-xs">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Informações
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.name"
                        label="Nome do encontro *"
                        disable
                    />
                </div>

                <div class="col-12 col-md-4">
                    <q-select
                        :options="optionsTypes"
                        emit-value
                        map-options
                        outlined
                        v-model="form.type"
                        label="Tipo *"
                        disable
                   />
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model.number="form.number_of_students"
                        label="Quantidade de alunos"
                        mask="########"
                        disable
                    />
                </div>

                <div class="col-12 col-md-4">
                    <q-select
                        :options="optionsTeachers"
                        option-value="id"
                        option-label="name"
                        emit-value
                        map-options
                        outlined
                        v-model="form.teacher_id"
                        label="Professor *"
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

                <div class="col-12 col-md-4">
                    <q-select
                        label="Palavras-chave"
                        outlined
                        v-model="form.tags"
                        multiple
                        hide-dropdown-icon
                        input-debounce="0"
                        new-value-mode="add-unique"
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

                <div class="col-12 col-md-2">
                    <q-input
                        outlined
                        v-model="form.start_at"
                        mask="##/##/#### ##:##"
                        label="Data e hora de inicio *"
                        disable
                    >
                        <template v-slot:prepend>
                            <q-icon name="o_calendar_today"/>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-2">
                    <q-input
                        outlined
                        v-model="form.end_at"
                        mask="##/##/#### ##:##"
                        label="Data e hora de término *"
                        disable
                    >
                        <template v-slot:prepend>
                            <q-icon name="o_calendar_today"/>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.description"
                        label="Descrição"
                        disable
                    />
                </div>

                <div class="col-12 col-md-4" v-if="form.has_link_with_content">
                    <q-select
                        :options="optionsContents"
                        option-value="id"
                        option-label="name"
                        emit-value
                        map-options
                        outlined
                        v-model="form.content_id"
                        label="Vincular ao conteúdo"
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

                <div class="col-12 col-md-4" v-if="form.has_link_with_content">
                    <q-select
                        v-if="form.content_id"
                        :options="optionsLinkableTypes"
                        emit-value
                        map-options
                        outlined
                        v-model="form.linkable_type"
                        label="Momento de vinculação do evento"
                        disable
                    />
                </div>

                <div class="col-12 col-md-4" v-if="form.has_link_with_content">
                    <q-select
                        v-if="form.linkable_type !== 'content'"
                        :options="optionsSeasonsOrChapters"
                        option-value="id"
                        option-label="name"
                        emit-value
                        map-options
                        outlined
                        v-model="form.linkable_id"
                        :label="labelOptionsSeasonsOrChapters"
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

                <div class="col-12 items-center q-mt-xs">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Imagem de capa

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

                <div class="col-12 col-md-12" v-if="imageSrc">
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

                <div class="col-12 items-center" v-if="form.materials.length > 0">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Material
                    </div>
                </div>

                <div
                    class="col-12 col-md-3"
                    v-for="(material, index) in form.materials"
                    :key="`material-${index}}}`"
                >
                    <q-img
                        :src="material.is_image ? material.link : imageForDoc"
                        style="height: 240px"
                        class="app-br-16"
                    >
                        <div class="absolute-bottom text-subtitle2 row items-center">
                            <q-icon name="attach_file" size="md" class="rotate-225 q-mr-md"/>

                            <div class="column">
                                <span class="text-caption">
                                    {{ material.name.length > 25 ? material.name.slice(0, 25) + '...' : material.name }}
                                </span>

                                <span class="text-caption">
                                    ({{ material.size ?? 0 }} kb)
                                </span>
                            </div>

                            <q-btn
                                color="white"
                                class="absolute"
                                style="top: 8px; right: 40px"
                                flat
                                icon="file_download"
                                size="md"
                                @click="downloadMaterial(material)"
                                dense
                            >
                                <q-tooltip
                                    anchor="center left"
                                    self="center right"
                                    :offset="[10, 10]"
                                    class="text-body2 bg-grey-10"
                                >
                                    Clique para fazer o download
                                </q-tooltip>
                            </q-btn>

                            <q-btn
                                color="white"
                                class="absolute"
                                style="top: 8px; right: 8px"
                                flat
                                icon="close"
                                size="md"
                                @click="removeMaterial(index)"
                                dense
                            >
                                <q-tooltip
                                    anchor="center left"
                                    self="center right"
                                    :offset="[10, 10]"
                                    class="text-body2 bg-grey-10"
                                >
                                    Remover {{ material.is_image ? 'imagem' : 'arquivo' }}
                                </q-tooltip>
                            </q-btn>
                        </div>
                    </q-img>
                </div>

                <div class="col-12">
                    <q-checkbox
                        v-model="form.has_live_offer"
                        label="Oferta ao vivo"
                        disable
                    />
                </div>

                <div class="col-12 col-md-5" v-if="form.has_live_offer">
                    <q-input
                        outlined
                        v-model="form.name_offer"
                        label="Nome da oferta"
                        disable
                    />
                </div>

                <div class="col-12 col-md-7" v-if="form.has_live_offer">
                    <q-input
                        outlined
                        v-model="form.embed_offer"
                        label="Link da oferta"
                        disable
                    />
                </div>

                <div class="col-12" v-if="form.has_live_offer">
                    <q-input
                        outlined
                        v-model="form.description_offer"
                        label="Descrição da oferta"
                        disable
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
