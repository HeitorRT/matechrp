<script setup>
    import AuthenticatedLayout from '@/Layouts/Student/AuthenticatedLayout.vue';
    import ModalContentLive from '@/Components/Student/Content/ModalContentLive/Index.vue';

    import { Head } from '@inertiajs/inertia-vue3';
    import { ref, computed } from 'vue';

    const props = defineProps({
        liveEvent: Object
    });

    const showModalContentLive = ref(false);

    const downloadmaterial = (path, name = 'material') => {
        const link = document.createElement('a');
        link.href = path;
        link.target = '_blank';
        link.setAttribute('download', name);
        link.click();
    }
</script>

<template>
    <Head :title="`Assistir ${liveEvent.name}`"/>

    <AuthenticatedLayout>
        <div class="student-container-responsive" style="margin-top: 140px;">
            <div class="row">
                <div class="col-12" v-if="liveEvent.embed">
                    <div
                        v-html="liveEvent.embed"
                        class="app-player-iframe"
                    ></div>
                </div>

                <div class="col-12 col-md-5 q-mt-xl">
                    <div class="student-text-purple app-fw-800 app-fs-12 app-lh-16 q-mb-md student-label-category-carrousel">
                        Live
                    </div>

                    <div class="text-white app-fw-800 app-fs-58 app-lh-72 q-mb-lg">
                        {{ liveEvent.name }}
                    </div>

                    <div class="text-white app-fw-400 app-fs-19 app-lh-24 q-mb-lg" >
                        {{ liveEvent.description }}
                    </div>

                    <div v-if="liveEvent.has_link_with_content" class="q-mt-xl">
                        <div class="text-white app-fw-700 app-fs-27 app-lh-22 q-mb-lg">
                            Conteúdo vinculado
                        </div>

                        <q-img
                            class="app-br-16 cursor-pointer"
                            :src="liveEvent.content.image"
                            height="256px"
                            @click="showModalContentLive = true"
                        />

                        <div class="text-white app-fw-700 app-fs-23 app-lh-22 q-my-lg">
                            {{ liveEvent.content.name }}
                        </div>

                        <div class="text-white app-fw-400 app-fs-19 app-lh-24 q-mb-lg">
                            {{ liveEvent.content.description }}
                        </div>

                        <div class="text-white app-fw-400 app-fs-19 app-lh-24 row justify-between">
                            <div>
                                Direção: {{ liveEvent.content.responsible_name }}
                            </div>

                            <div v-if="liveEvent.content.count_seasons">
                                {{ liveEvent.content.count_seasons }} temporadas
                            </div>

                            <div v-else>
                                {{ liveEvent.content.chapter?.duration }}
                            </div>
                        </div>

                        <ModalContentLive
                            :content="liveEvent.content"
                            :show="showModalContentLive"
                            v-on:close="(e) => showModalContentLive = e"
                        />
                    </div>

                    <div v-if="!liveEvent.has_link_with_content" class="q-mt-xl">
                        <div class="text-white app-fw-400 app-fs-19 app-lh-24 q-mb-lg">
                            Não há conteúdo vinculado
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-7">
                </div>
            </div>

            <div class="text-white app-fw-700 app-fs-27 app-lh-22 q-mt-xl q-mb-md">
                Materiais da live
            </div>

            <div class="row">
                <div class="col-md-3 col-12" v-for="material in liveEvent.materials">
                    <q-card class="transparent full-height" flat>
                        <q-card-section class="q-px-none">
                            <q-img
                                class="app-br-16"
                                :src="material.link"
                                height="162px"
                                v-if="material.is_image"
                                style="max-width: 90"
                            />

                            <div
                                v-else
                                class="app-br-16 flex flex-center"
                                style="max-width: 90%; height: 162px; border: 1px dashed grey"
                            >
                                <q-icon name="folder" size="80px" color="grey"/>
                            </div>

                            <div class="text-white app-fw-700 app-fs-22 app-lh-32 q-py-md">
                                {{ material.name }}
                            </div>

                            <div
                                class="text-white app-fw-400 app-fs-16 app-lh-24 app-text-with-underline cursor-pointer"
                                @click="downloadmaterial(material.link, material.name)"
                            >
                                Download
                            </div>
                        </q-card-section>
                    </q-card>
                </div>

                <div v-if="liveEvent.materials.length === 0" class="col-12">
                    <div class="text-white app-fw-400 app-fs-19 app-lh-24 q-mb-lg">
                        Não há materiais disponiveis
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
