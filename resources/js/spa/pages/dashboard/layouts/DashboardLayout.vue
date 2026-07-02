<script setup lang="ts">
import { useTitle } from '@spa/composables/useTitle';
import DashboardSidebar from '@spa/pages/dashboard/components/DashboardSidebar.vue';
import Main from '@spa/pages/dashboard/Main.vue';


useTitle()

</script>


<template>
 <div class="flex-1 grid grid-cols-12 grid-rows-1 gap-4">
     <DashboardSidebar class="col-span-2"/>
    <div class="col-span-10">
        <Main/>
        <!-- Слот для основного контента страницы -->
        <slot />
    </div>
 </div>
</template>
