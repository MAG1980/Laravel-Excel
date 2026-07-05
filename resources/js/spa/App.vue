<!-- resources/js/spa/App.vue (пример) -->
<template>
    <div id="app">
        <AppLayout>
            <OutInTransition>
                <router-view />
            </OutInTransition>
        </AppLayout>
    </div>
</template>

<script setup lang="ts">
// здесь может быть логика приложения
import OutInTransition from '@spa/components/OutInTransition.vue';
import AppLayout from '@spa/layouts/AppLayout.vue';
</script>
