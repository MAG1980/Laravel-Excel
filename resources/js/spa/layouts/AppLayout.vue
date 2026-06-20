<script setup lang="ts">
import Navigation from '@spa/components/Navigation.vue';
import { useTitle } from '@spa/composables/useTitle';

useTitle()
</script>

<template>
        <Navigation />

        <!-- Слот для основного контента страницы -->
        <slot />
</template>
