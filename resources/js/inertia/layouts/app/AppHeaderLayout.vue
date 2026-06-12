<script setup lang="ts">
import AppContent from '@inertia/components/AppContent.vue';
import AppHeader from '@inertia/components/AppHeader.vue';
import AppShell from '@inertia/components/AppShell.vue';
import type { BreadcrumbItem } from '@inertia/types';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell class="flex-col">
        <AppHeader :breadcrumbs="breadcrumbs" />
        <AppContent>
            <slot />
        </AppContent>
    </AppShell>
</template>
