<script setup>
    import AuthenticatedLayout from '@/Layouts/Student/AuthenticatedLayout.vue';
    import AdminDialog from '@/Components/Admin/AdminDialog.vue';
    import { date } from 'quasar';
    import { useQuasar } from 'quasar';
    import { ref, computed } from 'vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useDropzone } from "vue3-dropzone";

    const $q = useQuasar()

    const props = defineProps({
        errors: Object,
        student: Object,
    });

    const form = useForm({
        id: props.student.id,
        name: props.student.name,
        email: props.student.email,
        profile_image: props.student.profile_image,
        created_at: props.student.created_at,
    });

    const subscriberSince = computed(() => {
        return date.formatDate(new Date(props.student.created_at), 'MMMM [de] YYYY');
    })

    const profileImage = computed(() => {
        return props.student.profile_image ? props.student.profile_image : '/img/student/avatar.png';
    })

    const dropZoneProfileImage = useDropzone({
        onDrop: (acceptFiles, rejectReasons) => {
            form.profile_image = acceptFiles[0];

            if (rejectReasons.length > 0) {
                $q.notify({ message: 'Insira apenas uma imagem', position: 'center' })
            } else {
                uploadPhoto();
            }

        },
        accept: ['image/*'],
        maxFiles: 1
    });

    function uploadPhoto() {
        form.post(route("student.upload-photo", form.id), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                $q.notify({
                    type: 'positive',
                    message: 'Foto alterada com sucesso',
                    position: 'top',
                })
            },
        })
    }

    const logout = () => {
        $q.dialog({
            component: AdminDialog,
            componentProps: {
                title: 'Logout',
                message: 'Deseja realmente sair da área do aluno?',
                confirm: true
            },
        }).onOk(() => {
            useForm().post(route('student.auth.logout'));
        });
    }

    const resetPassword = () => {
        useForm().get(route('student.reset-password'));
    }

</script>

<template>
    <Head title="Home"/>

    <AuthenticatedLayout>
        <div class="student-edit-profile-container">
            <div class="student-edit-profile-container-content d-flex justify-content-center">
                <div class="row justify-center items-center">

                    <div class="col-4 col-md-4">
                        <div class="text-center">
                            <img :src="profileImage" class="student-edit-profile-avatar">
                            <div class="student-edit-profile-link-photo app-my-90 cursor-pointer" v-bind="dropZoneProfileImage.getRootProps()">
                                <input v-bind="dropZoneProfileImage.getInputProps()"/>
                                Alterar foto
                            </div>
                            <div class="student-edit-profile-text-logout app-my-120 cursor-pointer" @click="logout">LOGOUT</div>
                        </div>
                    </div>

                    <div class="col-8 col-md-7">
                        <div class="text-left q-ml-md">
                            <div class="student-edit-profile-text-name">{{ form.name }}</div>
                            <div class="student-edit-profile-text-light">Assinante desde {{ subscriberSince }}</div>

                            <div class="student-edit-profile-text-data app-my-50">Dados de acesso</div>
                            <div class="student-edit-profile-text-label q-mt-md">E-mail</div>
                            <div class="student-edit-profile-text-light">{{ form.email }}</div>

                            <div class="row">
                                <div class="col-6 student-edit-profile-text-label q-mt-md">Senha</div>
                                <a class="col-6 student-edit-profile-text-password float-right text-white q-mt-md cursor-pointer" @click="resetPassword">Alterar senha</a>
                            </div>
                            <div class="student-edit-profile-text-light">******</div>

                            <div class="student-edit-profile-text-data q-mt-lg">Dados do cartão</div>
                            <div class="student-edit-profile-text-label q-mt-sm">Visa &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; 6789</div>
                            <div class="student-edit-profile-text-light q-mt-sm">Sua próxima cobrança é em Março de 2024</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
