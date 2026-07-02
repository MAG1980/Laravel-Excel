<!-- pages/dashboard/Index.vue -->
<script setup lang="ts">
import DashboardLayout from '@spa/pages/dashboard/layouts/DashboardLayout.vue';
import { type BreadcrumbItem } from '@spa/types';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        name: 'user.dashboard',
    },
];
</script>

<template>
    <h1>Dashboard</h1>

    <DashboardLayout :breadcrumbs="breadcrumbs">
        <transition>
            <!-- Единый слот для вложенных маршрутов -->
            <router-view class="flex-1"/>
        </transition>
    </DashboardLayout>
</template>
