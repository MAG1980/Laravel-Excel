<script setup lang="ts">
import Navigation from '@spa/components/Navigation.vue';
import { useTitle } from '@spa/composables/useTitle';

useTitle();
</script>

<template>
    <div class="flex min-h-screen flex-col p-4">
        <Navigation />
        <!-- Слот для основного контента страницы -->
        <slot />
</div>
</template>
