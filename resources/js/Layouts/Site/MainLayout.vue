<script setup>
    import TopBar from '@/Components/Site/TopBar/Index.vue';
</script>

<template>
    <q-layout>
        <q-header>
            <TopBar />
        </q-header>
        
        <q-page-container>
            <q-page class="window-height window-width">
                <slot />
            </q-page>
        </q-page-container>
    </q-layout>
</template>
