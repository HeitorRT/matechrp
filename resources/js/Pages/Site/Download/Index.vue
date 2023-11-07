<script setup>
    import MainLayout from '@/Layouts/Site/MainLayout.vue';
    import { Head } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        teamViewerLink: String,
        anyDeskLink: String,
    });

</script>

<template>
    <Head title="Download"/>

    <MainLayout>
        <div class="row">
            <div class="site-container-core bg-blue column justify-end q-pb-xl" style="height: 300px;">
                <div class="text-white app-fs-40 app-fw-650 text-uppercase">
                    Download
                </div>

                <div class="text-white app-fs-18 q-mt-lg">
                    Utilize do nosso menu para acessar rapidamente o download de algumas ferramentas.
                </div>
            </div>

            <div class="q-py-xl site-container-core">
                <div class="row">
                    <div class="col-3">
                        <q-img
                            src="https://1000logos.net/wp-content/uploads/2023/04/TeamViewer-logo.png"
                            spinner-color="white"
                            style="max-width: 300px;"
                        />
                    </div>
                    <div class="col-9 flex items-center q-pl-xl">
                        <div class="q-gutter-x-lg">
                            <a href="https://download.teamviewer.com/download/TeamViewerQS.exe">Windows 32bits</a>
                            <a href="https://download.teamviewer.com/download/TeamViewerQS_x64.exe">Windows 64bits</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <q-img
                            src="https://cdn.worldvectorlogo.com/logos/anydesk-logo.svg"
                            spinner-color="white"
                            style="max-width: 300px;"
                        />
                    </div>
                    <div class="col-9 flex items-center q-pl-xl">
                        <div class="q-gutter-x-lg">
                            <a href="https://download.anydesk.com/AnyDesk.exe">Windows 32/64bits</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
