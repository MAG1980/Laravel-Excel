<template>
    <div class="flex flex-col items-center justify-center gap-2 p-2">
        <div>{{images.length? 'Images' : 'No images'}}</div>
        <div v-for="image in images" :key="image.id">
            <img class="rounded-md" :src="image.url" alt="image.id" />
        </div>
    </div>
</template>

<script setup lang="ts">
import type { PostImage } from '@spa/types';

defineProps<{
    images: PostImage[];
}>();
</script>
