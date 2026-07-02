<script setup lang="ts">
import {
    Breadcrumb,
    BreadcrumbList,
    BreadcrumbSeparator,
} from '@/components/ui/breadcrumb';
import type { BreadcrumbItem } from '@spa/types';

type Props = {
    breadcrumbs: BreadcrumbItem[];
};

defineProps<Props>();
</script>

<template>
    <Breadcrumb>
        <BreadcrumbList>
            <template v-for="(item, index) in breadcrumbs" :key="index">
                <router-link :to="{ name: item.name }"
                    >{{ item.title }}
                </router-link>
                <BreadcrumbSeparator v-if="index !== breadcrumbs.length - 1" />
            </template>
        </BreadcrumbList>
    </Breadcrumb>
</template>
