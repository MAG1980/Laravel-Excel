<!-- resources/js/spa/App.vue (пример) -->
<template>
    <div id="app">
        <AppLayout>

            <router-view />
        </AppLayout>
    </div>
</template>

<script setup lang="ts">
// здесь может быть логика приложения
import AppLayout from '@spa/layouts/AppLayout.vue';
</script>
