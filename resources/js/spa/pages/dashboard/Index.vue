<!-- pages/dashboard/Index.vue -->
<script setup lang="ts">
import DashboardLayout from '@spa/pages/dashboard/layouts/DashboardLayout.vue';

</script>

<template>
    <h1>Dashboard</h1>

    <DashboardLayout>
        <transition>
            <!-- Единый слот для вложенных маршрутов -->
            <router-view class="flex-1"/>
        </transition>
    </DashboardLayout>
</template>
