<script setup>
    import { ref, computed } from 'vue'
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar, date} from 'quasar'
    import axios from 'axios';

    const $q = useQuasar()

    const props = defineProps({
        errors: Object,
        paymentMethods: Object,
        statuses: Object,
        campaigns: Object,
    });

    const form = useForm({
        id: null,
        student: null,
        campaign_id: null,
        status: 'adimplente',
        payment_value: 0,
        payment_method: 'boleto',
        term_accepted: null,
        text_terms_acceptance: null,
        registration_type: null,
        hiring_start_at: date.formatDate(Date.now(), 'DD/MM/YYYY'),
        hiring_end_at: null,
        invoices: null,
        student_id: null,
        student: {
            id: null,
            name: null,
            email: null,
            cpf: null,
            phone: null,
            customer_cpf: null,
            customer_phone: null,
            equal_data: false,
        },
    });

    const submit = () => {
        form.post(route("admin.order.store"), {
            onSuccess: () => {
                $q.notify({
                    type: 'positive',
                    message: 'Pedido cadastrada com sucesso',
                    position: 'top',
                })
            },
        })
    };

    const optionsCampaigns = ref(props.campaigns)

    const optionsPaymentMethods = computed(() => {
        let options = new Array();

        for (const key in props.paymentMethods) {
            options.push({ label: props.paymentMethods[key], value: key })
        }

        return options;
    })

    const optionsStatuses = computed(() => {
        let options = new Array();

        for (const key in props.statuses) {
            options.push({ label: props.statuses[key], value: key })
        }

        return options;
    })

    const getClassStatus = (status) => {
        switch (status) {
            case 'adimplente': return 'adm-bg-positive';
            case 'cancelado': return 'adm-bg-error';
            case 'nao_renovou': return 'adm-bg-negative';
            case 'vencido': return 'adm-bg-caution';
            default: return 'bg-white'
        }
    }

    const registrationTypeComputed = computed(() => 'Anual');

    const students = ref([])

    const searchStudents = (val, update, abort) => {
        if (val.length < 4) {
            abort()
            return
        }

        update(() => {
            students.value = [];

            axios.get(route('admin.student.search'), { params: { name: val } }).then(response => {
                students.value = response.data.students;
            })
        })
    }

    const selectedStudent = () => {
        let student = students.value.filter(v => v.id == form.student_id)

        form.student.cpf = student.length > 0 ? student[0].cpf : null;
        form.student.email = student.length > 0 ? student[0].email : null;
        form.student.phone = student.length > 0 ? student[0].phone : null;
        form.student.customer_cpf = student.length > 0 ? student[0].customer_cpf : null;
        form.student.customer_phone = student.length > 0 ? student[0].customer_phone : null;
        form.student.equal_data = student.length > 0 ? student[0].equal_data : null;
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Pedido | Cadastrar" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Cadastrar novo pedido </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Cadastrar novo pedido" class="text-primary" />
                </q-breadcrumbs>
            </div>

            <div class="col-12 col-md-6 flex justify-end items-center">
                <q-btn
                    color="primary"
                    rounded
                    no-caps
                    @click="submit"
                >
                    <q-icon name="check" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Salvar pedido
                    </div>
                </q-btn>
            </div>
        </div>

        <div class="bg-white q-py-lg q-px-lg app-br-16">
            <div class="row q-col-gutter-lg">
                <div class="col-12 items-center q-mt-xs">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Pedido do aluno
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <q-select
                        :options="optionsStatuses"
                        outlined
                        v-model="form.status"
                        label="Status do pedido"
                        map-options
                        emit-value
                        :bottom-slots="Boolean(errors.status)"
                        disable
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.status }} </div>
                        </template>

                        <template v-slot:selected-item="scope">
                            <q-chip
                                text-color="white"
                                :class="getClassStatus(scope.opt.value)"
                                class="q-my-none"
                            >
                                {{ scope.opt.label }}
                            </q-chip>
                        </template>

                    </q-select>
                </div>

                <div class="col-12 col-md-4">
                    <q-select
                        :options="optionsPaymentMethods"
                        outlined
                        v-model="form.payment_method"
                        label="Forma de pagamento"
                        map-options
                        emit-value
                        :bottom-slots="Boolean(errors.payment_method)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.payment_method }} </div>
                        </template>
                    </q-select>
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="registrationTypeComputed"
                        label="Tipo de cadastrado"
                        disable
                    />
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.payment_value"
                        label="Valor pago"
                        mask="#.##"
                        fill-mask="0"
                        reverse-fill-mask
                        :bottom-slots="Boolean(errors.payment_value)"
                        prefix="R$"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.payment_value }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.hiring_start_at"
                        mask="##/##/####"
                        label="Data da contratação"
                        :bottom-slots="Boolean(errors.hiring_start_at)"
                    >
                        <template v-slot:prepend>
                            <q-icon name="o_calendar_today"/>
                        </template>

                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.hiring_start_at }} </div>
                        </template>

                        <q-popup-proxy class="row">
                            <q-date
                                v-model="form.hiring_start_at"
                                mask="DD/MM/YYYY"
                                flat
                                square
                            />
                        </q-popup-proxy>
                    </q-input>
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.hiring_end_at"
                        mask="##/##/####"
                        label="Data final da contratação"
                        :bottom-slots="Boolean(errors.hiring_end_at)"
                    >
                        <template v-slot:prepend>
                            <q-icon name="o_calendar_today"/>
                        </template>

                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.hiring_end_at }} </div>
                        </template>

                        <q-popup-proxy class="row">
                            <q-date
                                v-model="form.hiring_end_at"
                                mask="DD/MM/YYYY"
                                flat
                                square
                            />
                        </q-popup-proxy>
                    </q-input>
                </div>

                <div class="col-12 items-center q-mt-xs">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Dados do aluno
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.student_id"
                        label="ID do aluno"
                        disable
                    />
                </div>

                <div class="col-12 col-md-6">
                    <q-select
                        option-value="id"
                        option-label="name"
                        :options="students"
                        outlined
                        v-model="form.student_id"
                        label="Aluno"
                        map-options
                        emit-value
                        :bottom-slots="true"
                        use-input
                        @filter="searchStudents"
                        @update:model-value="selectedStudent"
                    >
                        <template v-slot:hint>
                            <div class="text-red" v-if="errors.student_id"> {{ errors.student_id }} </div>
                            <div class="text-grey" v-else> Digite ao menos 4 caracteres para procurar o aluno </div>
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

                        <template v-slot:no-option>
                            <q-item>
                                <q-item-section class="text-grey">
                                    Nenhum resultado encontrado
                                </q-item-section>
                            </q-item>
                        </template>
                    </q-select>
                </div>

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.student.cpf"
                        label="CPF do aluno"
                        mask="###.###.###-##"
                        disable
                    />
                </div>


                <div class="col-12 col-md-9">
                    <q-input
                        outlined
                        v-model="form.student.email"
                        label="E-mail do aluno"
                        disable
                    />
                </div>

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.student.phone"
                        label="Telefone do aluno"
                        mask="(##) #########"
                        disable
                    />
                </div>

                <div class="col-12 col-md-5">
                    <q-input
                        outlined
                        label="Produto"
                        disable
                    />
                </div>

                <div class="col-12 col-md-7">
                    <q-select
                        :options="optionsCampaigns"
                        option-value="id"
                        option-label="name"
                        emit-value
                        map-options
                        outlined
                        v-model="form.campaign_id"
                        label="Campanha"
                        :bottom-slots="Boolean(errors.campaign_id)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.campaign_id }} </div>
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

                <div class="col-12 items-center q-mt-xs">
                    <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                        Dados do cliente
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="form.student.customer_cpf"
                        label="CPF do cliente"
                        mask="###.###.###-##"
                        disable
                    />
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="form.student.customer_phone"
                        label="Telefone do cliente"
                        mask="(##) #########"
                        disable
                    />
                </div>

                <div class="col-12">
                    <q-checkbox
                        v-model="form.student.equal_data"
                        label="Dados iguais para cliente e aluno"
                        disable
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
