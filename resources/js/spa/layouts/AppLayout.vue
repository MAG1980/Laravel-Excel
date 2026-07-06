<script setup lang="ts">
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import Breadcrumbs from '@spa/components/Breadcrumbs.vue';
import Navigation from '@spa/components/Navigation.vue';
import { useTitle } from '@spa/composables/useTitle';
import type { BreadcrumbItem } from '@spa/types';

useTitle();

const route = useRoute();

const breadcrumbs = computed<BreadcrumbItem[]>(() => {
    // Собираем все matched-маршруты, у которых есть meta.title
    return route.matched
        .filter((r) => r.meta?.title)
        .map((r) => ({
            title: r.meta.title as string,
            name: r.name as string, // или путь
        }));
});
</script>

<template>
    <div class="flex min-h-screen flex-col p-4">
        <Navigation class="flex-shrink-0" />
        <Breadcrumbs class="flex-shrink-0" :breadcrumbs="breadcrumbs" />
        <!-- Слот для основного контента страницы -->
        <slot class="flex-1" />
    </div>
</template>
