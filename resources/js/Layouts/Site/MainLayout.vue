<script setup>
    import TopBar from '@/Components/Site/TopBar/Index.vue';
    import BottomBar from '@/Components/Site/BottomBar/Index.vue';
    import { ref, computed } from 'vue';
    import { useForm } from '@inertiajs/inertia-vue3';

    import { useQuasar } from 'quasar'

    const $q = useQuasar()

    const goRoute = (routeName) => useForm().get(route(routeName));

    const leftDrawerOpen = ref(false)

    const toggleLeftDrawer = () => leftDrawerOpen.value = !leftDrawerOpen.value

    const tabs = [{
        label: 'Página Inicial',
        route: 'site.home'
    }, {
        label: 'Quem somos',
        route: 'site.about-us'
    }, {
        label: 'Serviços',
        route: 'site.teste'
    }, {
        label: 'Contato',
        route: 'site.teste'
    }];

    const isMobile = computed(() => !$q.screen.gt.sm)
    const isNotMobile = computed(() => $q.screen.gt.sm)
</script>

<template>
    <q-layout>
        <q-header>
            <q-toolbar class="site-topbar bg-grey-3 row justify-between">
                <q-icon 
                    name="computer" 
                    :size="isMobile ? '30px' : '70px'" 
                    color="blue-grey-10"
                />
        
                <div class="row justify-center" v-if="isNotMobile">
                    <div
                        v-for="tab in tabs"
                        class="q-mr-xl app-lh-24 app-fs-19 cursor-pointer "
                        :class="{
                            'app-fw-600 text-blue text-uppercase': route().current(tab.route),
                            'app-fw-350 text-blue-grey-10': ! route().current(tab.route)
                        }"
                        @click="goRoute(tab.route)"
                    >
                        {{ tab.label }}

                        <div 
                            style="height: 5px;" 
                            class="bg-blue app-br-16" 
                            v-if="route().current(tab.route)"
                        />
                    </div>
                </div>

                <q-btn
                    flat
                    dense
                    round
                    icon="menu"
                    @click="toggleLeftDrawer"
                    v-if="isMobile"
                    color="blue-grey-10"
                />
            </q-toolbar>
        </q-header>

        
        <q-drawer
            v-if="isMobile"
            v-model="leftDrawerOpen"
            :width="256"
            class="bg-grey-3"
        >
            <q-scroll-area class="fit text-center">
                <q-icon 
                    name="computer" 
                    size="50px" 
                    color="blue-grey-10"
                    class="q-my-xl"
                />

                <q-list
                    padding
                    v-for="(tab, index) in tabs"
                    :key="index"
                >
                    <q-item
                        v-ripple
                        class="cursor-pointer q-px-xl"
                        clickable
                        @click="goRoute(tab.route)"
                    >
                        <q-item-section
                            class="app-fs-19 app-lh-24"
                            :class="{
                                'app-fw-600 text-blue text-uppercase': route().current(tab.route),
                                'app-fw-350 text-blue-grey-10': ! route().current(tab.route)
                            }"
                        >
                            {{ tab.label }}

                            <div 
                                style="height: 5px;" 
                                class="bg-blue app-br-16" 
                                v-if="route().current(tab.route)"
                            />
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-scroll-area>
        </q-drawer>
        
        <q-page-container>
            <q-page class="bg-grey-3">
                <slot />
            </q-page>
        </q-page-container>

        <q-footer class="bg-white">
            <BottomBar />
        </q-footer>
    </q-layout>
</template>
