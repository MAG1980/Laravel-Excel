<script setup lang="ts">
import AppContent from '@inertia/components/AppContent.vue';
import AppShell from '@inertia/components/AppShell.vue';
import AppSidebar from '@inertia/components/AppSidebar.vue';
import AppSidebarHeader from '@inertia/components/AppSidebarHeader.vue';
import type { BreadcrumbItem } from '@inertia/types';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell variant="sidebar">
        <AppSidebar />
        <AppContent variant="sidebar" class="overflow-x-hidden">
            <AppSidebarHeader :breadcrumbs="breadcrumbs" />
            <slot />
        </AppContent>
    </AppShell>
</template>
