<script lang="ts">
import { defineComponent } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';

export default defineComponent({
    name: 'Index',
    components: { AppLayout },
});
</script>

<template>
    <AppLayout>
        <div>
            <h1>Projects Index</h1>
        </div>
    </AppLayout>
</template>

<style scoped></style>
