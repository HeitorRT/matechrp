<script setup>
    import { useForm, usePage } from '@inertiajs/inertia-vue3';
    import { ref, computed, onMounted } from 'vue';
    import { useQuasar } from 'quasar'
    import AdminDialog from '@/Components/Admin/AdminDialog.vue';
    import Notification from '@/Components/Student/TopBar/Notification.vue';

    const $q = useQuasar()

    const student = computed(() => usePage().props.value.auth.user)

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

    const searchPage = () => useForm().get(route('student.search'))

    const editProfile = () => useForm().get(route('student.edit-profile'))

    const goRoute = (routeName) => useForm().get(route(routeName));

    const profileImage = computed(() => student.value.profile_image ? student.value.profile_image : '/img/student/avatar.png')

    const scrollPosition = ref(0);

    onMounted(() => {
        window.addEventListener('scroll', () => scrollPosition.value = window.scrollY);
    })

    const tabs = [{
        label: 'Pagina Inicial',
        route: 'student.home'
    }, {
        label: 'Filmes',
        route: 'student.movie'
    }, {
        label: 'Séries',
        route: 'student.serie'
    }, {
        label: 'Lives',
        route: 'student.live'
    }, {
        label: 'MasterClass',
        route: 'student.test'
    }, {
        label: 'Ciné Debát',
        route: 'student.test'
    }, {
        label: 'Agenda',
        route: 'student.test'
    }, {
        label: 'Loja',
        route: 'student.test'
    }, {
        label: 'Suporte',
        route: 'student.test'
    }];
</script>

<template>
    <q-toolbar
        class="text-white student-topbar"
        :class="{'student-bg-dark': scrollPosition > 150}"
    >
        <q-img
            src="/img/student/logo_ligia_academy.png"
            class="student-topbar-logo q-mr-xl"
        />

        <q-space />

        <div
            v-for="tab in tabs"
            class="q-mr-xl app-lh-24 app-fs-19 cursor-pointer"
            :class="{
                'app-fw-700': route().current(tab.route),
                'app-fw-400': ! route().current(tab.route)
            }"
            @click="goRoute(tab.route)"
        >
            {{ tab.label }}
        </div>

        <q-space />

        <Notification/>

        <q-icon
            name="search"
            size="28px"
            class="q-mx-sm cursor-pointer"
            @click="searchPage"
        />

        <q-avatar
            size="40px"
            class="q-mx-sm"
        >
            <img :src="profileImage">
        </q-avatar>

        <q-icon
            name="keyboard_arrow_down"
            size="28px"
            class="q-ml-sm cursor-pointer"
        >
            <q-menu
                class="app-br-16 student-bg-dark"
            >
                <div class="row no-wrap student-bg-dark">
                    <div class="column items-center">
                        <q-list>
                            <q-item
                                clickable
                                @click="editProfile"
                                class="student-text-grey flex items-center"
                            >
                                <q-icon name="o_edit" size="21px"/>

                                <q-item-section no-wrap>
                                    <div class="q-ml-sm app-fs-19 app-fw-400 app-lh-24"> Editar perfil</div>
                                </q-item-section>
                            </q-item>

                            <q-separator dark/>

                            <q-item
                                clickable
                                @click="logout"
                                class="student-text-grey flex items-center"
                            >
                                <q-icon name="close" size="xs"/>

                                <q-item-section no-wrap>
                                    <div class="q-ml-sm app-fs-19 app-fw-400 app-lh-24"> Logout</div>
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </div>
                </div>
            </q-menu>
        </q-icon>
    </q-toolbar>
</template>
