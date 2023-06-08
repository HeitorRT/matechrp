<script setup>
    import GuestLayout from '@/Layouts/Student/GuestLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';

    const form = useForm({
        email: 'aluno@aluno.com',
        password: 'aluno',
    });

    const submit = () => {
        form.post(route('student.auth.login'), {
            onFinish: () => form.reset('password'),
        });
    };

    const goToForgot = () => useForm().get(route('student.auth.forgot'))

</script>

<template>
    <GuestLayout>
        <Head title="Login" />

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
                            Faça login
                        </div>

                        <div class="app-fs-19 app-fw-500">
                            Lorem ipsum dolor sit amet consectetur. <br/>
                            Vitae pellentesque amet molestie lorem in urna ac eu imperdiet.
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

                        <div class="col-12">
                            <q-input
                                outlined
                                v-model="form.password"
                                type="password"
                                label="Senha"
                                dark
                                color="purple"
                            />

                            <div class="col-12 float-right q-mt-lg cursor-pointer" @click="goToForgot">
                                Esqueci minha senha
                            </div>
                        </div>
                    </q-card-section>

                    <q-card-section class="row q-col-gutter-sm q-mt-sm  ">
                        <div class="col-12">
                            <q-btn
                                unelevated
                                label="Fazer login"
                                @click="submit"
                                padding="10px 24px"
                                class="app-br-16 app-fs-16 student-bg-purple"
                            />
                        </div>
                    </q-card-section>
                </q-card>
            </div>
        </div>
    </GuestLayout>
</template>
