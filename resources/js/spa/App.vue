<!-- resources/js/spa/App.vue (пример) -->
<template>
    <div id="app">
        <AppLayout>
            <router-view v-slot="{ Component }">
                <OutInTransition>
                    <component :is="Component" />
                </OutInTransition>
            </router-view>
        </AppLayout>
    </div>
</template>

<script setup lang="ts">
// здесь может быть логика приложения
import OutInTransition from '@spa/components/OutInTransition.vue';
import AppLayout from '@spa/layouts/AppLayout.vue';
</script>
