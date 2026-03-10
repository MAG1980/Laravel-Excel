<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { importData } from '@/routes/projects';
import type { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Project Import',
        href: importData().url,
    },
];
</script>
<template>
    <Head title="Project Import" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <h1>Project Import</h1>
        </div>
    </AppLayout>
</template>

<style scoped></style>
