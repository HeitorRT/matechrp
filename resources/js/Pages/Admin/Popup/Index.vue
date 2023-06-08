<script setup>
    import { ref, computed } from 'vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { useQuasar } from 'quasar'
    import DialogConfirm from '@/Components/Admin/DialogConfirm.vue';

    const $q = useQuasar()

    const props = defineProps({
        popups: Object,
        errors: Object,
        query: Object,
        contents: Array,

        canPopupStore: Boolean,
        canPopupEdit: Boolean,
        canPopupDestroy: Boolean,
    });

    const columns = [{
        name: 'description',
        align: 'left',
        label: 'Descrição',
        field: 'description',
        style: 'width: 40%',
    },{
        name: 'start_at',
        align: 'left',
        label: 'Início',
        field: 'start_at',
        style: 'width: 25%',
    },{
        name: 'end_at',
        align: 'left',
        label: 'Término',
        field: 'end_at',
        style: 'width: 25%',
    },{
        name: 'actions',
        label: 'Ação',
    }];

    const requestData = useForm({
        orderBy: props.query.orderBy,
        sort: props.query.sort,
        page: props.query.page,
        rowsPerPage: props.query.rowsPerPage,
        filters: {
            description: props.query.filters.description,
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

    const removeFilter = (filterDescription) => {
        requestData.filters[filterDescription] = null;
        submit();
    }

    const submit = () => {
        requestData.get(route('admin.popup.index'), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => showFilters.value = false,
        });
    }

    const create = () => useForm().get(route('admin.popup.create'));

    const edit = (id) => useForm().get(route('admin.popup.edit', id));

    const show = (id) => useForm().get(route('admin.popup.show', id));

    const destroy = (id) => {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Excluir pop-up',
                message: 'Ao excluir pop-up, ela será desvinculada dos conteúdos. Tem certeza que deseja excluir pop-up?',
            },
        }).onOk(() => {
            useForm().delete(route('admin.popup.destroy', id), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Popup excluído com sucesso',
                        position: 'top',
                    })
                }
            })
        });
    }

    const destroySelected = () => {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Excluir selecionados',
                message: 'Ao excluir popups selecionadas, elas serão desvinculadas dos conteúdos. Tem certeza que deseja excluir popups selecionadas?',
            },
        }).onOk(() => {
            useForm({ ids: selected.value.map(s => s.id) }).post(route('admin.popup.destroy-multiples'), {
                onSuccess: () => {
                    selected.value = [];

                    $q.notify({
                        type: 'positive',
                        message: 'Popups excluídas com sucesso',
                        position: 'top',
                    })
                }
            })
        });
    }

    const selected = ref([])

    const countAppliedFilters = computed(() => Object.values(props.query.filters).filter(fil => fil).length);

    const showFilters = ref(false)

    const clearFilters = () => useForm().get(route('admin.popup.index'))

    const optionsContents = ref(props.contents)

    const filterContents = (val, update, abort) => {
        update(() => optionsContents.value = props.contents.filter(s => s.name.toLowerCase().indexOf(val.toLowerCase()) > -1))
    }

    const getClassStatus = (status) => {
        switch (status) {
            case 'ativo': return 'adm-bg-positive';
            case 'inativo': return 'adm-bg-negative';
            case 'a_exibir': return 'adm-bg-caution';
            default: return 'bg-white'
        }
    }


</script>

<template>
    <AuthenticatedLayout>
        <Head title="Pop-ups" />

        <div class="row q-pb-xl">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Pop-ups </div>

                <q-breadcrumbs
                    class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                    gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Pop-ups" class="text-primary" />
                </q-breadcrumbs>
            </div>

             <div class="col-12 col-md-6 flex justify-end items-center">
                <q-btn
                    color="negative"
                    class="q-mr-md"
                    rounded
                    no-caps
                    outline
                    v-if="canPopupDestroy"
                    @click="destroySelected"
                >
                    <q-icon name="close" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Excluir selecionados
                    </div>
                </q-btn>

                <q-btn
                    color="primary"
                    rounded
                    no-caps
                    @click="create"
                >
                    <q-icon name="add" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Novo pop-up
                    </div>
                </q-btn>
            </div>
        </div>

        <q-card flat class="app-br-16">
            <q-card-popup class="row items-center q-py-sm q-px-lg">
                <q-chip
                    class="adm-chip-primary"
                    v-if="query.filters.description"
                    :label="`Descrição = ${query.filters.description}`"
                >
                    <q-icon
                        name="cancel"
                        size="xs"
                        @click="removeFilter('description')"
                        class="q-ml-xs cursor-pointer"
                    />
                </q-chip>

                <q-chip
                    class="adm-chip-primary"
                    v-if="query.filters.start_at"
                    :label="`Data e hora de início = ${query.filters.start_at}`"
                >
                    <q-icon
                        name="cancel"
                        size="xs"
                        @click="removeFilter('start_at')"
                        class="q-ml-xs cursor-pointer"
                    />
                </q-chip>

                <q-chip
                    class="adm-chip-primary"
                    v-if="query.filters.end_at"
                    :label="`Data e hora de término = ${query.filters.end_at}`"
                >
                    <q-icon
                        name="cancel"
                        size="xs"
                        @click="removeFilter('end_at')"
                        class="q-ml-xs cursor-pointer"
                    />
                </q-chip>

                <q-chip
                    class="adm-chip-primary"
                    v-if="query.filters.active==`ativo`"
                    :label="`Status = Ativo`"
                >
                    <q-icon
                        name="cancel"
                        size="xs"
                        @click="removeFilter('active')"
                        class="q-ml-xs cursor-pointer"
                    />
                </q-chip>

                <q-chip
                    class="adm-chip-primary"
                    v-if="query.filters.active==`inativo`"
                    :label="`Status = Inativo`"
                >
                    <q-icon
                        name="cancel"
                        size="xs"
                        @click="removeFilter('active')"
                        class="q-ml-xs cursor-pointer"
                    />
                </q-chip>

                <q-chip
                        class="adm-chip-primary"
                        v-if="query.filters.active==`a_exibir`"
                        :label="`Status = A exibir`"
                >
                    <q-icon
                            name="cancel"
                            size="xs"
                            @click="removeFilter('active')"
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
                                    v-model="requestData.filters.description"
                                    label="Descrição do pop-up"
                                />
                            </div>

                            <div class="col-12">
                                <q-select
                                    :options="optionsContents"
                                    option-value="id"
                                    option-label="name"
                                    emit-value
                                    map-options
                                    outlined
                                    v-model="requestData.filters.content_id"
                                    label="Conteúdo"
                                    clearable
                                    use-input
                                    @filter="filterContents"
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

                            <div class="col-12">
                                <q-input
                                    outlined
                                    v-model="requestData.filters.start_at"
                                    mask="##/##/#### ##:##"
                                    label="Data e hora de início"
                                    placeholder="dia/mês/ano hora:min"
                                    :bottom-slots="Boolean(errors['filters.start_at'])"
                                    clearable
                                >
                                    <template v-slot:hint>
                                        <div class="text-red"> {{ errors['filters.start_at'] }} </div>
                                    </template>

                                    <template v-slot:prepend>
                                        <q-icon name="o_calendar_today" />
                                    </template>

                                    <q-popup-proxy class="row">
                                        <q-date
                                            v-model="requestData.filters.start_at"
                                            mask="DD/MM/YYYY HH:mm"
                                            flat
                                            square
                                        />

                                        <q-time
                                            v-model="requestData.filters.start_at"
                                            mask="DD/MM/YYYY HH:mm"
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

                            <div class="col-12">
                                <q-input
                                    outlined
                                    v-model="requestData.filters.end_at"
                                    mask="##/##/#### ##:##"
                                    label="Data e hora de término"
                                    :bottom-slots="Boolean(errors['filters.end_at'])"
                                    placeholder="dia/mês/ano hora:min"
                                    clearable
                                >
                                    <template v-slot:hint>
                                        <div class="text-red"> {{ errors['filters.end_at'] }} </div>
                                    </template>

                                    <template v-slot:prepend>
                                        <q-icon name="o_calendar_today" />
                                    </template>

                                    <q-popup-proxy class="row">
                                        <q-date
                                            v-model="requestData.filters.end_at"
                                            mask="DD/MM/YYYY HH:mm"
                                            flat
                                            square
                                        />

                                        <q-time
                                            v-model="requestData.filters.end_at"
                                            mask="DD/MM/YYYY HH:mm"
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


                            <div class="col-12">
                                <q-select
                                        :options="[{
                                        label: 'Ativo',
                                        value: 'ativo'
                                    }, {
                                        label: 'Inativo',
                                        value: 'inativo'
                                    }, {
                                        label: 'A exibir',
                                        value: 'a_exibir'
                                    }]"
                                        outlined
                                        v-model="requestData.filters.active"
                                        label="Status"
                                        map-options
                                        emit-value
                                >
                                    <template v-slot:selected-item="scope">
                                        <q-chip
                                            :tabindex="scope.tabindex"
                                            text-color="white"
                                            :class="getClassStatus(scope.opt.value)"
                                            dense
                                            class="q-my-none"
                                        >
                                            {{ scope.opt.label }}
                                        </q-chip>
                                    </template>
                                </q-select>
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
            </q-card-popup>

            <q-card-popup class="q-py-none">
                <q-separator color="grey-3"/>
            </q-card-popup>

            <q-card-popup class="q-py-none">
                <q-table
                    :rows="popups.data"
                    :columns="columns"
                    flat
                    class="text-grey-8"
                    v-model:selected="selected"
                    selection="multiple"
                    hide-pagination
                    :pagination.sync="{rowsPerPage: requestData.rowsPerPage}"
                >
                    <template v-slot:header-selection="scope">
                        <q-checkbox v-model="scope.selected" />
                    </template>

                    <template v-slot:body-selection="scope">
                        <q-checkbox
                            :model-value="scope.selected"
                            @update:model-value="(val, evt) => { Object.getOwnPropertyDescriptor(scope, 'selected').set(val, evt) }"
                        />
                    </template>

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

                    <template v-slot:body-cell-actions="props">
                        <q-td :props="props">
                            <div class="app-fw-700 app-fs-16">
                                <q-btn icon="more_vert" flat v-if="canPopupEdit || canPopupDestroy">
                                    <q-menu :offset="[65, 0]">
                                        <q-list>
                                            <q-item
                                                v-if="canPopupEdit"
                                                clickable
                                                @click="edit(props.row.id)"
                                                class="text-grey-7 flex items-center"
                                            >
                                                <q-icon name="edit" size="xs"/>

                                                <q-item-popup no-wrap>
                                                    <div class="q-ml-sm"> Editar </div>
                                                </q-item-popup>
                                            </q-item>

                                            <q-separator/>

                                            <q-item
                                                clickable
                                                @click="show(props.row.id)"
                                                class="text-grey-7 flex items-center"
                                            >
                                                <q-icon name="visibility" size="xs"/>

                                                <q-item-popup no-wrap>
                                                    <div class="q-ml-sm"> Visualizar </div>
                                                </q-item-popup>
                                            </q-item>

                                            <q-separator/>

                                            <q-item
                                                v-if="canPopupDestroy"
                                                clickable
                                                @click="destroy(props.row.id)"
                                                class="text-grey-7 flex flex-center"
                                            >
                                                <q-icon name="close" size="xs"/>

                                                <q-item-popup no-wrap>
                                                    <div class="q-ml-sm"> Excluir </div>
                                                </q-item-popup>
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
                        :max="popups.meta.last_page"
                        @update:model-value="submit"
                        direction-links
                        boundary-links
                        color="grey"
                        input
                        icon-first="keyboard_double_arrow_left"
                        icon-last="keyboard_double_arrow_right"
                    />
                </div>
            </q-card-popup>
        </q-card>
    </AuthenticatedLayout>
</template>

