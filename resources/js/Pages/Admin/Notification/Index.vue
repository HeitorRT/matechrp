<script setup>
    import { ref, computed } from 'vue';
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        notifications: Object,
        errors: Object,
        query: Object,

        canNotificationEdit: Boolean,
    });

    const columns = [{
        name: 'name',
        align: 'left',
        label: 'Nome',
        field: 'name',
        style: 'width: 40%',
    }, {
        name: 'send_by_whatsapp',
        align: 'left',
        label: 'Enviar por WhatsApp',
        field: 'send_by_whatsapp',
        style: 'width: 10%',
    }, {
        name: 'send_by_sms',
        align: 'left',
        label: 'Enviar por SMS',
        field: 'send_by_sms',
        style: 'width: 10%',
    }, {
        name: 'send_by_email',
        align: 'left',
        label: 'Enviar por e-mail',
        field: 'send_by_email',
        style: 'width: 10%',
    },  {
        name: 'send_by_pusher',
        align: 'left',
        label: 'Enviar por pusher',
        field: 'send_by_pusher',
        style: 'width: 10%',
    }, {
        name: 'active',
        align: 'center',
        label: 'Status',
        field: 'active',
        style: 'width: 10%',
    }, {
        name: 'actions',
        label: 'Ação',
    }];

    const requestData = useForm({
        orderBy: props.query.orderBy,
        sort: props.query.sort,
        page: props.query.page,
        rowsPerPage: props.query.rowsPerPage,
        filters: {
            name: props.query.filters.name,
        },
    });

    const sortBy = (field) => {
        if (requestData.orderBy === field) {
            requestData.sort = requestData.sort == 'desc' ? 'asc' : 'desc';
        } else {
            requestData.sort == 'asc';
        }

        requestData.orderBy = field;
        requestData.page = 1;

        submit();
    }

    const removeFilter = (filterName) => {
        requestData.filters[filterName] = null;
        submit();
    }

    const submit = () => {
        requestData.get(route('admin.notification.index'), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => showFilters.value = false,
        });
    }

    const edit = (id) => useForm().get(route('admin.notification.edit', id));

    const show = (id) => useForm().get(route('admin.notification.show', id));

    const countAppliedFilters = computed(() => Object.values(props.query.filters).filter(fil => fil).length);

    const showFilters = ref(false)

    const clearFilters = () => useForm().get(route('admin.notification.index'))
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Notificações" />

        <div class="row q-pb-xl">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Notificações </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Notificações" class="text-primary" />
                </q-breadcrumbs>
            </div>
        </div>

        <q-card flat class="app-br-16">
            <q-card-section class="row items-center q-py-sm q-px-lg">
                <q-chip
                    class="adm-chip-primary"
                    v-if="query.filters.name"
                    :label="`Nome = ${query.filters.name}`"
                >
                    <q-icon
                        name="cancel"
                        size="xs"
                        @click="removeFilter('name')"
                        class="q-ml-xs cursor-pointer"
                    />
                </q-chip>

                <q-space/>

                <q-btn round dense flat color="primary">
                    <q-badge
                        color="primary"
                        floating
                        rounded
                        :label="countAppliedFilters"
                        v-if="countAppliedFilters"
                    />

                    <q-icon name="tune" class="rotate-90"/>

                    <q-menu
                        style="min-width: 500px"
                        max-width='500px'
                        class="bg-white q-pa-md app-br-16"
                        v-model="showFilters"
                    >
                        <div class="row q-col-gutter-sm">
                            <div class="col-12">
                                <q-input
                                    outlined
                                    v-model="requestData.filters.name"
                                    label="Nome"
                                />
                            </div>
                        </div>

                        <div class="flex flex-center q-pt-lg q-pa-md q-gutter-sm">
                            <q-btn
                                color="primary"
                                rounded
                                no-caps
                                @click="submit"
                            >
                                <q-icon name="check" size="xs"/>

                                <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                                    Filtrar
                                </div>
                            </q-btn>

                            <q-btn
                                color="primary"
                                rounded
                                outline
                                no-caps
                                @click="clearFilters"
                            >
                                <q-icon name="close" size="xs"/>

                                <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20 m-4">
                                    Limpar
                                </div>
                            </q-btn>
                        </div>
                    </q-menu>
                </q-btn>
            </q-card-section>

            <q-card-section class="q-py-none">
                <q-separator color="grey-3"/>
            </q-card-section>

            <q-card-section class="q-py-none">
                <q-table
                    :rows="notifications.data"
                    :columns="columns"
                    flat
                    class="text-grey-8"
                    hide-pagination
                    :pagination.sync="{rowsPerPage: requestData.rowsPerPage}"
                >
                    <template v-slot:header-cell="props">
                        <q-th :props="props">
                            <div class="app-fw-700 app-fs-16 cursor-pointer" @click="sortBy(props.col.name)">
                                {{ props.col.label }}

                                <q-icon
                                    :name="query.sort == 'desc' ? 'keyboard_arrow_up' : 'keyboard_arrow_down'"
                                    v-if="props.col.name === query.orderBy"
                                />
                            </div>
                        </q-th>
                    </template>

                    <template v-slot:header-cell-actions="props">
                        <q-th :props="props" auto-width>
                            <div class="flex flex-center app-fw-700 app-fs-16">
                                {{  props.col.label  }}
                            </div>
                        </q-th>
                    </template>

                    <template v-slot:body-cell-send_by_email="props">
                        <q-td :props="props">
                            <div class="text-center">
                                <q-icon
                                    :name="props.row.send_by_email ? 'check' : 'not_interested'"
                                    :color="props.row.send_by_email ? 'green' : 'red'"
                                    size="xs"
                                />
                            </div>
                        </q-td>
                    </template>

                    <template v-slot:body-cell-send_by_whatsapp="props">
                        <q-td :props="props">
                            <div class="text-center">
                                <q-icon
                                    :name="props.row.send_by_whatsapp ? 'check' : 'not_interested'"
                                    :color="props.row.send_by_whatsapp ? 'green' : 'red'"
                                    size="xs"
                                />
                            </div>
                        </q-td>
                    </template>

                    <template v-slot:body-cell-send_by_sms="props">
                        <q-td :props="props">
                            <div class="text-center">
                                <q-icon
                                    :name="props.row.send_by_sms ? 'check' : 'not_interested'"
                                    :color="props.row.send_by_sms ? 'green' : 'red'"
                                    size="xs"
                                />
                            </div>
                        </q-td>
                    </template>

                    <template v-slot:body-cell-send_by_pusher="props">
                        <q-td :props="props" >
                            <div class="text-center">
                                <q-icon
                                    :name="props.row.send_by_pusher ? 'check' : 'not_interested'"
                                    :color="props.row.send_by_pusher ? 'green' : 'red'"
                                    size="xs"
                                />
                            </div>
                        </q-td>
                    </template>

                    <template v-slot:body-cell-active="props">
                        <q-td :props="props">
                            <q-chip
                                text-color="white"
                                :class="{
                                    'adm-bg-positive': props.row.active,
                                    'adm-bg-negative': !props.row.active
                                }"
                            >
                                {{ props.row.active ? 'Ativo' : 'Inativo' }}
                            </q-chip>
                        </q-td>
                    </template>

                    <template v-slot:body-cell-actions="props">
                        <q-td :props="props">
                            <div class="app-fw-700 app-fs-16">
                                <q-btn icon="more_vert" flat v-if="canNotificationEdit">
                                    <q-menu :offset="[65, 0]">
                                        <q-list>
                                            <q-item
                                                v-if="canNotificationEdit"
                                                clickable
                                                @click="edit(props.row.id)"
                                                class="text-grey-7 flex items-center"
                                            >
                                                <q-icon name="edit" size="xs"/>

                                                <q-item-section no-wrap>
                                                    <div class="q-ml-sm"> Editar </div>
                                                </q-item-section>
                                            </q-item>

                                            <q-separator/>

                                            <q-item
                                                clickable
                                                @click="show(props.row.id)"
                                                class="text-grey-7 flex items-center"
                                            >
                                                <q-icon name="visibility" size="xs"/>

                                                <q-item-section no-wrap>
                                                    <div class="q-ml-sm"> Visualizar </div>
                                                </q-item-section>
                                            </q-item>
                                        </q-list>
                                    </q-menu>
                                </q-btn>

                                <q-btn
                                    v-else
                                    @click="show(props.row.id)"
                                    class="text-grey-7 flex flex-center text-no-wrap"
                                    flat
                                    no-caps
                                >
                                    <q-icon name="visibility" size="xs"/>
                                    <div class="q-ml-sm"> Visualizar </div>
                                </q-btn>
                            </div>
                        </q-td>
                    </template>
                </q-table>

                <div class="row items-center text-grey">
                    <q-space/>

                    <div class="row items-center text-grey">
                        Resultado por página

                        <q-select
                            :options="[5, 10, 15]"
                            v-model="requestData.rowsPerPage"
                            borderless
                            class="q-ml-md"
                            @update:model-value="submit"
                        />
                    </div>

                    <q-pagination
                        v-model="requestData.page"
                        :max="notifications.meta.last_page"
                        @update:model-value="submit"
                        direction-links
                        boundary-links
                        color="grey"
                        input
                        icon-first="keyboard_double_arrow_left"
                        icon-last="keyboard_double_arrow_right"
                    />
                </div>
            </q-card-section>
        </q-card>
    </AuthenticatedLayout>
</template>
