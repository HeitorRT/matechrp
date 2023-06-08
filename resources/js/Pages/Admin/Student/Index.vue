<script setup>
    import { ref, computed } from 'vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { useQuasar } from 'quasar'
    import DialogConfirm from '@/Components/Admin/DialogConfirm.vue';

    const $q = useQuasar()

    const props = defineProps({
        students: Object,
        errors: Object,
        query: Object,

        canStudentStore: Boolean,
        canStudentEdit: Boolean,
        canStudentDestroy: Boolean,
        canGroupIndex: Boolean,
    });

    const columns = [{
        name: 'name',
        align: 'left',
        label: 'Nome',
        field: 'name',
        style: 'width: 40%',
    }, {
        name: 'email',
        align: 'left',
        label: 'E-mail',
        field: 'email',
        style: 'width: 30%',
    }, {
        name: 'cpf',
        align: 'left',
        label: 'CPF',
        field: 'cpf',
        style: 'width: 20%',
    }, {
        name: 'active',
        align: 'left',
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
            email: props.query.filters.email,
            cpf: props.query.filters.cpf,
            phone: props.query.filters.phone,
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
        requestData.get(route('admin.student.index'), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => showFilters.value = false,
        });
    }

    const create = () => useForm().get(route('admin.student.create'));

    const edit = (id) => useForm().get(route('admin.student.edit', id));

    const show = (id) => useForm().get(route('admin.student.show', id));

    const exportExcel = () => {
        axios.get(route('admin.student.export', requestData), {
            responseType: "blob"
        })
            .then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'alunos.xlsx');
                link.click();
            })
            .catch(response => {
                $q.notify({
                    type: 'negative',
                    message: 'Erro ao fazer a exportação',
                    position: 'center',
                })
            });
    }

    function destroy(id) {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Excluir aluno',
                message: 'Tem certeza que deseja excluir esse aluno?',
            },
        }).onOk(() => {
            useForm().delete(route('admin.student.destroy', id), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Usuário excluído com sucesso',
                        position: 'top',
                    })
                }
            })
        });
    }

    function destroySelected() {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Excluir selecionados',
                message: 'Tem certeza que deseja excluir alunos selecionados?',
            },
        }).onOk(() => {
            useForm({ ids: selected.value.map(s => s.id) }).post(route('admin.student.destroy-multiples'), {
                onSuccess: () => {
                    selected.value = [];

                    $q.notify({
                        type: 'positive',
                        message: 'Alunos excluídos com sucesso',
                        position: 'top',
                    })
                }
            })
        });
    }

    const selected = ref([])

    const countAppliedFilters = computed(() => Object.values(props.query.filters).filter(fil => fil).length);

    const showFilters = ref(false)

    const clearFilters = () => useForm().get(route('admin.student.index'))
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Alunos" />

        <div class="row q-pb-xl">
            <div class="column col-12 col-md-6 justify-center">
                <div class="app-fs-28 app-fw-700 app-lh-32 text-grey-8"> Alunos </div>

                <q-breadcrumbs
                        class="text-grey q-mt-sm app-fs-13 app-fw-400 app-lh-16"
                        gutter="xs"
                >
                    <q-breadcrumbs-el label="Home" class="text-grey"/>
                    <q-breadcrumbs-el label="Alunos" class="text-primary" />
                </q-breadcrumbs>
            </div>

            <div class="col-12 col-md-6 flex justify-end items-center">
                <q-btn
                    v-if="selected.length > 0 && canStudentDestroy"
                    color="negative"
                    class="q-mr-md"
                    rounded
                    no-caps
                    outline
                    @click="destroySelected"
                >
                    <q-icon name="close" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Excluir selecionados
                    </div>
                </q-btn>

                <q-btn
                    v-if="canStudentStore"
                    color="primary"
                    rounded
                    no-caps
                    @click="create"
                >
                    <q-icon name="add" size="xs"/>

                    <div class="q-ml-sm app-fw-500 app-fs-14 app-lh-20">
                        Novo aluno
                    </div>
                </q-btn>
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

                <q-chip
                    class="adm-chip-primary"
                    v-if="query.filters.email"
                    :label="`E-mail = ${query.filters.email}`"
                >
                    <q-icon
                        name="cancel"
                        size="xs"
                        @click="removeFilter('email')"
                        class="q-ml-xs cursor-pointer"
                    />
                </q-chip>

                <q-chip
                    class="adm-chip-primary"
                    v-if="query.filters.cpf"
                    :label="`CPF = ${query.filters.cpf}`"
                >
                    <q-icon
                        name="cancel"
                        size="xs"
                        @click="removeFilter('cpf')"
                        class="q-ml-xs cursor-pointer"
                    />
                </q-chip>

                <q-chip
                    class="adm-chip-primary"
                    v-if="query.filters.phone"
                    :label="`Telefone = ${query.filters.phone}`"
                >
                    <q-icon
                        name="cancel"
                        size="xs"
                        @click="removeFilter('phone')"
                        class="q-ml-xs cursor-pointer"
                    />
                </q-chip>


                <q-chip
                    class="adm-chip-primary"
                    v-if="query.filters.active==1"
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
                    v-if="query.filters.active==0"
                    :label="`Status = Inativo`"
                >
                    <q-icon
                        name="cancel"
                        size="xs"
                        @click="removeFilter('active')"
                        class="q-ml-xs cursor-pointer"
                    />
                </q-chip>

                <q-space/>

                <q-btn
                    round
                    dense
                    flat
                    color="primary"
                    @click="exportExcel"
                >
                    <q-icon name="save_alt"/>

                    <q-tooltip
                        anchor="center left"
                        self="center right"
                        :offset="[10, 10]"
                        class="text-body2 bg-grey-10"
                    >
                        Exportar todos os registros filtrados
                    </q-tooltip>
                </q-btn>

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
                                    label="Nome do aluno"
                                />
                            </div>

                            <div class="col-12">
                                <q-input
                                    outlined
                                    v-model="requestData.filters.email"
                                    label="Email"
                                />
                            </div>

                            <div class="col-12">
                                <q-input
                                    outlined
                                    v-model="requestData.filters.cpf"
                                    label="CPF"
                                    mask="###.###.###-##"
                                />
                            </div>

                            <div class="col-12">
                                <q-input
                                    outlined
                                    v-model="requestData.filters.phone"
                                    label="Telefone do aluno"
                                    mask="(##) #########"
                                />
                            </div>

                            <div class="col-12">
                                <q-select
                                    :options="[{
                                    label: 'Ativo',
                                    value: 1
                                }, {
                                    label: 'Inativo',
                                    value: 0
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
                                            :class="{
                                                'adm-bg-positive':  scope.opt.value,
                                                'adm-bg-negative': !scope.opt.value
                                            }"
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
            </q-card-section>

            <q-card-section class="q-py-none">
                <q-separator color="grey-3"/>
            </q-card-section>

            <q-card-section class="q-py-none">
                <q-table
                    :rows="students.data"
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

                    <template v-slot:header-cell-actions="props">
                        <q-th :props="props" auto-width>
                            <div class="flex flex-center app-fw-700 app-fs-16">
                                {{  props.col.label  }}
                            </div>
                        </q-th>
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
                                <q-btn icon="more_vert" flat v-if="canStudentEdit || canStudentDestroy">
                                    <q-menu :offset="[65, 0]">
                                        <q-list>
                                            <q-item
                                                v-if="canStudentEdit"
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

                                            <q-separator/>

                                            <q-item
                                                v-if="canStudentDestroy"
                                                clickable
                                                @click="destroy(props.row.id)"
                                                class="text-grey-7 flex flex-center"
                                            >
                                                <q-icon name="close" size="xs"/>

                                                <q-item-section no-wrap>
                                                    <div class="q-ml-sm"> Excluir </div>
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
                        :max="students.meta.last_page"
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
