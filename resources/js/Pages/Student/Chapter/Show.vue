<script setup>
    import { ref, computed } from 'vue';
    import { Head } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        chapter: Object
    });

    const embedVimeo = computed(() => {
        if (props.chapter.main_player === 'vimeo') {
            return props.chapter.vimeo_embed;
        }

        return props.chapter.embed;
    });
</script>

<template>
    <Head title="Assistir"/>
        <div class="q-video student-bg-main">
            <div v-html="embedVimeo" style="height: 100vh;">
            </div>
        </div>
</template>
