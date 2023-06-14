<script setup>
    const goRoute = (routeName) => useForm().get(route(routeName));

    const tabs = [{
        label: 'Página Inicial',
        route: 'site.home'
    }, {
        label: 'Quem somos',
        route: 'site.home'
    }, {
        label: 'Serviços',
        route: 'site.home'
    }, {
        label: 'Contato',
        route: 'site.home'
    }];
</script>

<template>
    <q-toolbar
        class="text-white site-topbar bg-blue-grey-10"
    >
        <q-icon name="computer" size="70px" color="green"/>

        <q-space />

        <div class="row justify-center">
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
        </div>
        
        <q-space />

    </q-toolbar>
</template>
