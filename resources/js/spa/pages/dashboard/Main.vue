<template>
    <div class="col-span-2 rounded-md bg-cyan-500 text-center text-white mb-2">
        Main
    </div>
    <div
        class="grid grid-cols-2 gap-2 text-center text-white rounded-md bg-cyan-300"
    >
        <div class="col-span-1 rounded-md">Posts</div>
        <ImagesList class="col-span-1" :images="images" />
    </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue';
import api from '@spa/axios';
import type { ApiResponse } from '@spa/axios/api.types';
import ImagesList from '@spa/pages/dashboard/components/ImagesList.vue';
import type { PostImage } from '@spa/types';

const images = ref<PostImage[]>([]);

onMounted(async () => {
    await fetchImages();
});

const fetchImages = async () => {
    const response = await api.get<ApiResponse<PostImage[]>>('api/images');
    images.value = response.data.data;
};
</script>
