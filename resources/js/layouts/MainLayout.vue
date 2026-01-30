<script lang="ts">
import { Link } from '@inertiajs/vue3';
import { defineComponent } from 'vue';
import { index as projectsIndex } from '@/routes/projects';
import { importData as projectsImportData } from '@/routes/projects';

export default defineComponent({
    name: 'MainLayout',
    components: { Link },
    methods: { projectsIndex, projectsImportData },
});
</script>

<template>
    <div class="mx-auto w-96">
        <h1>Excel Parser App</h1>
        <nav class="sm:-py-px hidden space-x-8 sm:ml-10 sm:flex">
            <Link :href="projectsIndex()" :active="projectsIndex()"
                >Projects</Link
            >
            <!--            <Link :href="route('projects.index')" :active="route().current('projects.index')">Projects</Link>-->
            <Link :href="projectsImportData()" :active="projectsImportData()"
                >Import Project</Link
            >
        </nav>
        <slot />
    </div>
</template>

<style scoped></style>
