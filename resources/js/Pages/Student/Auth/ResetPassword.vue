<script setup>
    import GuestLayout from '@/Layouts/Student/GuestLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'

    const $q = useQuasar()

    const props = defineProps({
        email: String,
        token: String,
        errors: Object,
    });

    const form = useForm({
        token: props.token,
        email: props.email,
        password: null,
        password_confirmation: null,
    });

    const submit = () => {
        form.post(route('student.auth.password.reset'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };
</script>

<template>
    <GuestLayout>
        <Head title="Redefinir a senha" />

        <div class="row items-center justify-center">

            <q-img
                    src="/img/student/logo_ligia_academy.png"
                    class="student-navbar-logo student-logo-login-float"
            />

            <div class="col-6 q-pa-none">
                <div class="student-login-image"></div>
            </div>

            <div class="col-6">
                <q-card
                        class="transparent text-white"
                        flat
                        style="padding: 0 100px;"
                >
                    <q-card-section class="q-mb-lg">
                        <div class="app-fs-42 app-fw-800">
                            Redefinir a senha
                        </div>

                        <div class="app-fs-19 app-fw-500">
                            Informe a Senha e Confirme a senha.
                        </div>
                    </q-card-section>

                    <q-card-section class="row q-col-gutter-sm">
                        <div class="col-12">
                            <q-input
                                outlined
                                v-model="form.email"
                                type="email"
                                label="E-mail"
                                :hint="form.errors.email"
                                dark
                                color="purple"
                            />
                        </div>
                    </q-card-section>

                    <q-card-section class="row q-col-gutter-sm">
                        <div class="col-12">
                            <q-input
                                outlined
                                v-model="form.password"
                                type="password"
                                label="Senha"
                                :hint="form.errors.password"
                                dark
                                color="purple"
                            />
                        </div>
                    </q-card-section>

                    <q-card-section class="row q-col-gutter-sm">
                        <div class="col-12">
                            <q-input
                                outlined
                                v-model="form.password_confirmation"
                                type="password"
                                label="Confirmar senha"
                                :hint="form.errors.password_confirmation"
                                dark
                                color="purple"
                            />
                        </div>
                    </q-card-section>

                    <q-card-section class="row q-col-gutter-sm q-mt-sm">
                        <div class="col-12">
                            <q-btn
                                unelevated
                                @click="submit"
                                padding="10px 24px"
                                class="app-br-16 app-fs-16 student-bg-purple"
                                :disabled="form.processing"
                                :loading="form.processing"
                            >
                                <div class="flex flex-center">
                                    <div class="q-mr-sm"> Redefinir </div>
                                </div>

                                <template v-slot:loading>
                                    <div class="q-mr-sm">
                                        <q-spinner-ios size="sm"/>
                                    </div>
                                </template>
                            </q-btn>
                        </div>
                    </q-card-section>
                </q-card>
            </div>
        </div>
    </GuestLayout>
</template>
