<script setup>
    import TopBar from '@/Components/Student/TopBar/Index.vue';
</script>

<template>
    <q-layout  view="lHh lpr lFf">
        <q-header >
            <TopBar/>
        </q-header>

        <q-page-container>
            <q-page >
                <slot />
            </q-page>
        </q-page-container>
    </q-layout>
</template>

<style lang="sass">
    body
        background: #1D1E20 radial-gradient(46.62% 48.33% at 50% 100%, rgba(91, 43, 153, 0.35) 0%, rgba(91, 43, 153, 0) 100%) no-repeat center center fixed

    ::-webkit-scrollbar
        width: 10px
        border-radius: 5px
        background: #1D1E20

    ::-webkit-scrollbar-track
        width: 2px
        background: #1D1E20

    ::-webkit-scrollbar-thumb
        background: #9C51FF
        border-radius: 5px
</style>
