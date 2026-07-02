Main.vue
<template>
    <div class="p-4">
        <h2 class="text-2xl font-bold mb-4">Создание поста</h2>
        <CreatePostForm />
    </div>
</template>

<script setup lang="ts">
import CreatePostForm from '@spa/pages/dashboard/components/CreatePostForm.vue';
</script>
