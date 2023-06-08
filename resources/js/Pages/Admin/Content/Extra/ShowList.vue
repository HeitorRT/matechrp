<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { ref, computed } from 'vue'
    import { useQuasar } from 'quasar'
    import DialogConfirm from '@/Components/Admin/DialogConfirm.vue';

    const $q = useQuasar()

    const props = defineProps({
        content: Object,
        extras: Object,
        errors: Object,
        types: Object,
        players: Object,
    });

    const tab = ref('extras')

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

    const goMainTab = () => useForm().get(route('admin.content.show', props.content.id))

    const goTitlesTab = () => useForm().get(route('admin.content.titles.show', props.content.id))

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
        <Head :title="`Visualizar extras ${content.name}`" />

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
                    <q-breadcrumbs-el :label="`Visualizar extras: ${content.name}`" class="text-primary" />
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
                        />
                    </div>

                    <div class="col-12" v-if="extra.type === 'arquivo'">
                        <q-img
                            :src="handleFile(extra)"
                            style="height: 400px"
                            class="app-br-16"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
