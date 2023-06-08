<script setup>
    import { ref, computed } from 'vue'
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'
    import { useDropzone } from "vue3-dropzone";
    import AdminDialog from '@/Components/Admin/AdminDialog.vue';

    const $q = useQuasar()

    const props = defineProps({
        popup: Object,
        errors: Object,
        contents: Array,

        canPopupDestroy: Boolean,
    });

    const form = useForm({
        id: props.popup.id,
        description: props.popup.description,
        image: props.popup.image,
        start_at: props.popup.start_at,
        end_at: props.popup.end_at,
        content_ids: props.popup.content_ids,
    });

    const optionsContents = ref(props.contents)

    const imageSrc = computed(() => {
        return form.image == null ? '' : (typeof form.image === 'object') ? URL.createObjectURL(form.image) : form.image;
    });

    const goBack = () => useForm().get(route('admin.popup.index'))

</script>

<template>
    <AuthenticatedLayout>
        <Head :title="`Visualizar popup: ${popup.description}`" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8">
                    Visualizar {{ popup.description }}
                </div>

                <q-breadcrumbs
                        class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                        gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Popup" class="text-grey"/>
                    <q-breadcrumbs-el :label="`Visualizar pop-up: ${popup.description}`" class="text-primary" />
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

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.description"
                        label="Descrição *"
                        disable
                    />
                </div>

                <div class="col-12 col-xl-6 col-md-6">
                    <q-input
                        outlined
                        v-model="form.start_at"
                        mask="##/##/#### ##:##"
                        label="Data e hora início"
                        disable
                    />
                </div>

                <div class="col-12 col-xl-6 col-md-6">
                    <q-input
                        outlined
                        v-model="form.end_at"
                        mask="##/##/#### ##:##"
                        label="Data e hora fim"
                        disable
                    />
                </div>

                <div class="col-12 col-md-12">
                    <q-select
                        :options="optionsContents"
                        option-value="id"
                        option-label="name"
                        emit-value
                        map-options
                        outlined
                        v-model="form.content_ids"
                        label="Conteúdo"
                        multiple
                        disable
                    >
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

                <div class="col-12 items-center q-mt-xs">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Imagem
                    </div>
                </div>

                <div class="col-12" v-if="imageSrc">
                    <q-img
                        :src="imageSrc"
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
        </div>
    </AuthenticatedLayout>
</template>
