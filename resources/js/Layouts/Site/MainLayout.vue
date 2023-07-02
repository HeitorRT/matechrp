<script setup>
    import TopBar from '@/Components/Site/TopBar/Index.vue';
    import BottomBar from '@/Components/Site/BottomBar/Index.vue';
</script>

<template>
    <q-layout>
        <q-header>
            <TopBar />
        </q-header>
        
        <q-page-container>
            <q-page>
                <slot />
            </q-page>
        </q-page-container>

        <q-footer elevated>
            <BottomBar />
        </q-footer>
    </q-layout>
</template>
