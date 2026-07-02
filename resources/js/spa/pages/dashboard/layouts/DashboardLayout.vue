<script setup lang="ts">
import { useTitle } from '@spa/composables/useTitle';
import DashboardSidebar from '@spa/pages/dashboard/components/DashboardSidebar.vue';
import { dashboardRoutes } from '@spa/router/dashboardRoutes';

useTitle();
</script>

<template>
    <div class="grid flex-1 grid-cols-12 grid-rows-1 gap-4">
        <DashboardSidebar class="col-span-2">
            <router-link
                class="block px-4 py-2 text-gray-700 hover:bg-gray-50"
                v-for="route in dashboardRoutes"
                :key="route.path"
                :to="{ name: route.name }"
            >
                {{ route.meta.title }}
            </router-link>
        </DashboardSidebar>
        <div class="col-span-10">
            <!-- Слот для основного контента страницы -->
            <slot />
        </div>
    </div>
</template>
