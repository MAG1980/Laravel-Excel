<template>
    <div id="app">
        <h1>Dashboard</h1>

        <CreatePostTable />

        <UploadImageForm />
    </div>
</template>

<script setup lang="ts">
// здесь может быть логика приложения
import CreatePostTable from '@spa/components/CreatePostTable.vue';
import UploadImageForm from '@spa/components/UploadImageForm.vue';
</script>
