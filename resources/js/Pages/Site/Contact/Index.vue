<script setup>
    import MainLayout from '@/Layouts/Site/MainLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { ref, computed } from 'vue'

    const props = defineProps({
        errors: Object,
    });

    const form = useForm({
        subject: null,
        name: null,
        email: null,
        phone: null,
        city: null,
        message: null,
    });

    const subjects = computed(() => [
        'Assistência técnica',
        'Garantia',
        'Outros'
    ]);

    const sendContact = () => {
        alert('Ação de envio de contato (email/whatsapp/sms). Definir.')
    }
</script>

<template>
    <Head title="Contato"/>

    <MainLayout>
        <div class="row">
            <div class="site-container-core bg-blue column justify-end q-pb-xl" style="height: 300px;">
                <div class="text-white app-fs-40 app-fw-650 text-uppercase">
                    Contato
                </div>

                <div class="text-white app-fs-18 q-mt-lg">
                    Utilize nosso formulário para solicitar orçamento de um dos nossos serviços ou mesmo para falar conosco.
                </div>
            </div>

            <div class="q-py-xl site-container-core">
                <div class="row q-col-gutter-lg">
                    <div class="col-12">
                        <q-select
                            :options="subjects"
                            outlined
                            v-model="form.subject"
                            label="Selecione o assunto"
                            :bottom-slots="Boolean(errors.subject)"
                            map-options
                            emit-value
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.subject }} </div>
                            </template>
                        </q-select>
                    </div>

                    <div class="col-12 col-md-6">
                        <q-input
                            outlined
                            v-model="form.name"
                            label="Nome"
                            :bottom-slots="Boolean(errors.name)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.name }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 col-md-6">
                        <q-input
                            outlined
                            v-model="form.email"
                            label="E-mai"
                            :bottom-slots="Boolean(errors.email)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.email }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 col-md-6">
                        <q-input
                            outlined
                            v-model="form.phone"
                            label="Telefone"
                            :bottom-slots="Boolean(errors.phone)"
                            mask="(##) #########"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.phone }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 col-md-6">
                        <q-input
                            outlined
                            v-model="form.city"
                            label="Cidade"
                            :bottom-slots="Boolean(errors.city)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.city }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 col-md-12">
                        <q-input
                            outlined
                            v-model="form.message"
                            label="Mensagem"
                            :bottom-slots="Boolean(errors.message)"
                            type="textarea"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.message }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 col-md-3">
                        <q-btn
                            color="blue"
                            :disabled="form.processing"
                            class="full-width"
                            @click="sendContact"
                        >
                            <q-icon name="send" size="xs"/>

                            <div class="q-ml-sm app-fs-14">
                                Enviar
                            </div>
                        </q-btn>
                    </div>
                </div>
            </div>

            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6326.896027282484!2d-46.64570939219926!3d-23.598067506081108!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce5a264d6b6611%3A0xae18ff6a2797997b!2sHospital%20S%C3%A3o%20Paulo!5e1!3m2!1spt-BR!2sbr!4v1690757710215!5m2!1spt-BR!2sbr" 
                allowfullscreen="" 
                style="width: 100%; height: 700px;"
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade"
            >
            </iframe>
        </div>
    </MainLayout>
</template>
