<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'MainLayout',
});
</script>

<template>
    <div class="mx-auto w-96">
        <h1>Excel Parser App</h1>
        <slot />
    </div>
</template>

<style scoped></style>
