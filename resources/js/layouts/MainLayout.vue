<script lang="ts">
import { defineComponent } from 'vue';
import { route } from 'ziggy-js';

export default defineComponent({
    name: 'MainLayout',
    methods: { route },
});
</script>

<template>
    <div class="mx-auto w-96">
        <h1>Excel Parser App</h1>
        <nav class="hidden space-x-8 sm:-py-px sm:ml-10 sm:flex">
            <Link :href="route('projects.index')" :active="route().current('projects.index')">Projects</Link>
            <Link :href="route('projects.import')" :active="route().current('projects.import')">Import Project</Link>
        </nav>
        <slot />
    </div>
</template>

<style scoped></style>
