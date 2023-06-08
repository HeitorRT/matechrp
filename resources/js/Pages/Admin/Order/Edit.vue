<script setup>
    import { ref, computed } from 'vue'
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import DialogConfirm from '@/Components/Admin/DialogConfirm.vue';
    import { useQuasar } from 'quasar'
    import { date } from 'quasar';


    const $q = useQuasar()

    const tab = ref('titles')

    const props = defineProps({
        order: Object,
        errors: Object,
        paymentMethods: Object,
        statuses: Object,
        campaigns: Object,
        installmentYears: Object,
        installments: Array,

    });

    const form = useForm({
        id: props.order.id,
        student: props.order.student,
        campaign_id: props.order.campaign_id,
        status: props.order.status,
        payment_value: props.order.payment_value,
        payment_method: props.order.payment_method,
        term_accepted: props.order.term_accepted,
        text_terms_acceptance: props.order.text_terms_acceptance,
        registration_type: props.order.registration_type,
        hiring_start_at: props.order.hiring_start_at,
        hiring_end_at: props.order.hiring_end_at,
        invoices: props.order.invoices,
        student_id: props.order.student_id,
        student: {
            id: props.order.student.id,
            name: props.order.student.name,
            email: props.order.student.email,
            cpf: props.order.student.cpf,
            phone: props.order.student.phone,
            active: props.order.student.active,
            customer_cpf: props.order.student.customer_cpf,
            customer_phone: props.order.student.customer_phone,
            equal_data: props.order.student.equal_data,
        },
    });

    const submit = () => {
        form.put(route("admin.order.update", form.id), {
            onSuccess: () => {
                $q.notify({
                    type: 'positive',
                    message: 'Pedido atualizado com sucesso',
                    position: 'top',
                })
            },
        })
    };

    const cancelRecurrence = () => {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Cancelar recorrência?',
                message: 'Tem certeza que deseja cancelar recorrência?',
            },
        }).onOk(() => {
            useForm().post(route('admin.order.cancel', props.order.id), {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Recorrência cancelada com sucesso',
                        position: 'top',
                    })

                    form.status = props.order.status;
                }
            })
        });
    }

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

    const registrationTypeComputed = computed(() => props.order.registration_type.replace(/^./, str => str.toUpperCase()));

    const dateFormated = (date_original) => {
        return date.formatDate(new Date(date_original), 'DD/MM/YYYY');
    }

    const priceFormated = (price) => {
        return parseFloat(price).toFixed(2).replace('.',',');
    }

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Aluno | Pedido" />

        <div class="row q-mb-lg">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Pedido do aluno </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Pedido do aluno" class="text-primary" />
                </q-breadcrumbs>
            </div>

            <div class="col-12 col-md-6 flex justify-end items-center">
                <q-btn
                    color="indigo-8"
                    class="q-mr-md"
                    rounded
                    no-caps
                    outline
                >
                    <q-icon name="attach_money" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Notas fiscais
                    </div>
                </q-btn>

                <q-btn
                    color="negative"
                    class="q-mr-md"
                    rounded
                    no-caps
                    outline
                    @click="cancelRecurrence"
                >
                    <q-icon name="close" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Cancelar recorrência
                    </div>
                </q-btn>

                <q-btn
                    color="primary"
                    rounded
                    no-caps
                    @click="submit"
                >
                    <q-icon name="check" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Atualizar pedido
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
                        mask="#,##"
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

                            <q-time
                                v-model="form.hiring_start_at"
                                mask="DD/MM/YYYY"
                                format24h
                                flat
                                square
                            >
                                <div class="row items-center justify-end">
                                    <q-btn
                                        label="Ok"
                                        color="primary"
                                        flat
                                        v-close-popup
                                    />
                                </div>
                            </q-time>
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

                            <q-time
                                v-model="form.hiring_end_at"
                                mask="DD/MM/YYYY"
                                format24h
                                flat
                                square
                            >
                                <div class="row items-center justify-end">
                                    <q-btn
                                        label="Ok"
                                        color="primary"
                                        flat
                                        v-close-popup
                                    />
                                </div>
                            </q-time>
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
                        v-model="form.student.id"
                        label="ID do aluno"
                        disable
                    />
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="form.student.name"
                        label="Nome do aluno"
                        disable
                    />
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

                <div class="col-12 col-md-4">
                    <q-select
                        :options="optionsCampaigns"
                        option-value="id"
                        option-label="name"
                        emit-value
                        map-options
                        outlined
                        v-model="form.campaign_id"
                        label="Campanha"
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

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.id"
                        label="Pedido"
                        disable
                    />
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

        <div class="bg-white q-py-lg q-px-lg app-br-16 q-mt-lg" >

            <div class="col-12 items-center q-mt-xs">
                <div class="q-ml-sm text-grey-8 app-fw-700 app-lh-32 app-fs-23">
                    Parcelas do pedido
                </div>
            </div>

            <div class="bg-white q-mt-lg">
                <q-card
                        v-for="(item, index) in installments"
                        flat
                        bordered
                        class="q-mt-sm bg-blue-grey-1"
                >
                    <q-card-section class="q-pa-none">
                        <q-expansion-item header-class="q-pa-none">

                            <template v-slot:header>
                                <div class="row full-width">
                                    <div class="col-2 app-fw-700 text-grey-7 q-pa-lg">
                                        Ano: {{ index }}
                                    </div>

                                    <div class="col-7 app-fw-700 q-pa-lg text-grey-7">
                                        Parcelas: {{ item.length }}
                                    </div>

                                    <div class="col-2 flex items-center justify-end">

                                    </div>
                                </div>
                            </template>

                            <template v-slot:default>
                                <div class="q-pa-md">

                                    <q-markup-table
                                            class="text-grey-8"
                                            flat
                                            dense
                                    >
                                        <thead>
                                        <tr>
                                            <th class="text-left">
                                                <div class="app-fw-600 app-fw-15">
                                                    Código
                                                </div>
                                            </th>
                                            <th class="text-left">
                                                <div class="app-fw-600 app-fw-15">
                                                    Forma de pagamento
                                                </div>
                                            </th>
                                            <th class="text-left">
                                                <div class="app-fw-600 app-fw-15">
                                                    Status
                                                </div>
                                            </th>
                                            <th class="text-left">
                                                <div class="app-fw-600 app-fw-15">
                                                    Parcela
                                                </div>
                                            </th>
                                            <th class="text-left">
                                                <div class="app-fw-600 app-fw-15">
                                                    Valor
                                                </div>
                                            </th>
                                            <th class="text-left">
                                                <div class="app-fw-600 app-fw-15">
                                                    Criação
                                                </div>
                                            </th>
                                            <th class="text-left">
                                                <div class="app-fw-600 app-fw-15">
                                                    Vencimento
                                                </div>
                                            </th>
                                            <th class="text-left">
                                                <div class="app-fw-600 app-fw-15">
                                                    Vencimento original
                                                </div>
                                            </th>
                                            <th class="text-left">
                                                <div class="app-fw-600 app-fw-15">
                                                    Pagamento
                                                </div>
                                            </th>
                                            <th class="text-left">
                                                Ações
                                            </th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                            <tr v-for="item in item">
                                                <td class="text-left">{{ item.id }}</td>
                                                <td class="text-uppercase">{{ item.payment_method }}</td>
                                                <td class="text-uppercase">{{ item.status }}</td>
                                                <td>{{ item.intstallment_number }}</td>
                                                <td>R$ {{ priceFormated(item.payment_value) }}</td>
                                                <td>{{ dateFormated(item.created_at) }}</td>
                                                <td>{{ dateFormated(item.expiration_at) }}</td>
                                                <td>{{ dateFormated(item.expiration_original_at) }}</td>
                                                <td>{{ item.payday_at ? dateFormated(item.payday_at) : '-' }}</td>

                                                <td style="width: 5%">
                                                    <q-btn icon="more_vert" flat>
                                                        <q-menu>
                                                            <q-list>
                                                                <q-item
                                                                        clickable
                                                                        class="text-grey-7 flex flex-center"
                                                                        @click=""
                                                                >
                                                                    <q-icon name="edit" size="xs"/>
                                                                    <div class="q-ml-sm"> Ver </div>
                                                                </q-item>

                                                                <q-separator/>

                                                                <q-item
                                                                        clickable
                                                                        class="text-grey-7 flex flex-center"
                                                                        @click=""
                                                                >
                                                                    <q-icon name="close" size="xs"/>
                                                                    <div class="q-ml-sm"> Excluir </div>
                                                                </q-item>
                                                            </q-list>
                                                        </q-menu>
                                                    </q-btn>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </q-markup-table>
                                </div>
                            </template>
                        </q-expansion-item>
                    </q-card-section>
                </q-card>

            </div>

        </div>

    </AuthenticatedLayout>
</template>
