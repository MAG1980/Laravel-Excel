<!-- pages/dashboard/Index.vue -->
<script setup lang="ts">
import DashboardLayout from '@spa/pages/dashboard/layouts/DashboardLayout.vue';
</script>

<template>
    <h1>Dashboard</h1>

    <DashboardLayout>
        <h2 class="text-right">User Dashboard</h2>
        <!-- Единый слот для вложенных маршрутов -->
        <router-view v-slot="{ Component }" class="flex-1">
            <Transition
                mode="out-in"
                enter-active-class="transition-all duration-300 ease-out"
                enter-from-class="opacity-0 -translate-y-4"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition-all duration-300 ease-in"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-4"
            >
                <component :is="Component" />
            </Transition>
        </router-view>
    </DashboardLayout>
</template>
