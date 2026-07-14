<script setup lang="ts">
import AppSidebarLayout from '@inertia/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItem } from '@inertia/types';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppSidebarLayout :breadcrumbs="breadcrumbs">
        <slot />
    </AppSidebarLayout>
</template>
